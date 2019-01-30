<?php

namespace App\Http\Controllers;

use App\CommissionLog;
use App\Deposit;
use App\Trx;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Gateway;
use App\GeneralSettings;

use Session;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\Charge;
use App\Lib\coinPayments;
use CoinGate\CoinGate;
use App\Lib\BlockIo;
use App\Lib\CoinPaymentHosted;

class PaymentController extends Controller
{

    public function userDataUpdate($data)
    {
        $gnl = GeneralSettings::first();

        if ($data->status == 0) {
            $data['status'] = 1;
            $data->update();

            $user = User::find($data->user_id);
            $user['balance'] = $user->balance + $data->amount;

            if($user->refer != 0)
            {
                $referUser = User::findOrfail($user->refer);
                $comission = ($data->amount *$gnl->refcom)/100;
                $referUser['balance']  += round($comission,2);
                $referUser->save();

                Trx::create([
                    'user_id' => $referUser->id,
                    'refer_id' => $user->id,
                    'amount' => $comission,
                    'main_amo' => $referUser->balance,
                    'type' => '+',
                    'title' => $comission . ' '.$gnl->currency. ' you got referral bonus  by ' .$user->username ,
                    'trx' => str_random(16)
                ]);
            }

            $user->update();


            Trx::create([
                'user_id' => $user->id,
                'amount' => $data->amount,
                'main_amo' => $user->balance,
                'charge' => 0,
                'type' => '+',
                'title' => 'Deposit Via ' . $data->gateway->name,
                'trx' => $data->trx
            ]);

            $txt = $data->amount . ' ' . $gnl->currency . ' Deposited Successfully Via ' . $data->gateway->name;
            send_email($user->email, $user->username, 'Deposit Successful', $txt);
            send_sms($user->phone, $txt);
        }

    }

    public function depositConfirm()
    {
        $gnl = GeneralSettings::first();

        $track = Session::get('Track');

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();

        if (is_null($data)) {
            return redirect()->route('deposit')->with('alert', 'Invalid Deposit Request');
        }
        if ($data->status != 0) {
            return redirect()->route('deposit')->with('alert', 'Invalid Deposit Request');
        }

        $gatewayData = Gateway::where('id', $data->gateway_id)->first();

        if ($data->gateway_id == 101) {
            $page_title = $gatewayData->name;
            $paypal['amount'] = $data->usd_amo;
            $paypal['sendto'] = $gatewayData->val1;
            $paypal['track'] = $track;
            return view('user.payment.paypal', compact('paypal', 'gnl', 'page_title'));

        } elseif ($data->gateway_id == 102) {
            $page_title = $gatewayData->name;
            $perfect['amount'] = $data->usd_amo;
            $perfect['value1'] = $gatewayData->val1;
            $perfect['value2'] = $gatewayData->val2;
            $perfect['track'] = $track;
            return view('user.payment.perfect', compact('perfect', 'gnl', 'page_title'));
        } elseif ($data->gateway_id == 103) {
            $page_title = $gatewayData->name;
            return view('user.payment.stripe', compact('track', 'page_title'));
        } elseif ($data->gateway_id == 104) {
            $page_title = $gatewayData->name;
            return view('user.payment.skrill', compact('page_title', 'gnl', 'gatewayData', 'data'));
        } elseif ($data->gateway_id == 501) {
            $page_title = $gatewayData->name;

            $all = file_get_contents("https://blockchain.info/ticker");
            $res = json_decode($all);
            $btcrate = $res->USD->last;

            $usd = $data->usd_amo;
            $btcamount = $usd / $btcrate;
            $btc = round($btcamount, 8);

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $blockchain_root = "https://blockchain.info/";
                $blockchain_receive_root = "https://api.blockchain.info/";
                $mysite_root = url('/');
                $secret = "ABIR";
                $my_xpub = $gatewayData->val2;
                $my_api_key = $gatewayData->val1;

                $invoice_id = $track;
                $callback_url = $mysite_root . "/ipnbtc?invoice_id=" . $invoice_id . "&secret=" . $secret;

                $resp = @file_get_contents($blockchain_receive_root . "v2/receive?key=" . $my_api_key . "&callback=" . urlencode($callback_url) . "&xpub=" . $my_xpub);

                if (!$resp) {
                    return redirect()->route('deposit')->with('alert', 'BLOCKCHAIN API HAVING ISSUE. PLEASE TRY LATER');
                }

                $response = json_decode($resp);
                $sendto = $response->address;

                $data['btc_wallet'] = $sendto;
                $data['btc_amo'] = $btc;
                $data->update();
            }

            $DepositData = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $bitcoin['amount'] = $DepositData->btc_amo;
            $bitcoin['sendto'] = $DepositData->btc_wallet;

            $var = "bitcoin:$DepositData->btc_wallet?amount=$DepositData->btc_amo";
            $bitcoin['code'] = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$var&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.blockchain', compact('bitcoin', 'page_title'));
        } elseif ($data->gateway_id == 502) {
            $method = Gateway::find(502);
            $apiKey = $method->val1;
            $version = 2;
            $pin = $method->val2;
            $block_io = new BlockIo($apiKey, $pin, $version);
            $btcdata = $block_io->get_current_price(array('price_base' => 'USD'));
            if ($btcdata->status != 'success') {
                return back()->with('alert', 'Failed to Process');
            }
            $btcrate = $btcdata->data->prices[0]->price;

            $usd = $data->usd_amo;
            $bcoin = round($usd / $btcrate, 8);

            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $ad = $block_io->get_new_address();

                if ($ad->status == 'success') {
                    $blockad = $ad->data;
                    $wallet = $blockad->address;
                    $data['btc_wallet'] = $wallet;
                    $data['btc_amo'] = $bcoin;
                    $data->update();
                } else {
                    return back()->with('alert', 'Failed to Process');
                }
            }

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = $gatewayData->name;
            $varb = "bitcoin:" . $wallet . "?amount=" . $bcoin;
            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.blockbtc', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 503) {
            $method = Gateway::find(503);
            $apiKey = $method->val1;
            $version = 2;
            $pin = $method->val2;
            $block_io = new BlockIo($apiKey, $pin, $version);
            $btcdata = $block_io->get_current_price(array('price_base' => 'USD'));
            if ($btcdata->status != 'success') {
                return back()->with('alert', 'Failed to Process');
            }
            $btcrate = $btcdata->data->prices[0]->price;

            $usd = $data->usd_amo;
            $bcoin = round($usd / $btcrate, 8);

            if ($data->btc_wallet == "") {
                $ad = $block_io->get_new_address();

                if ($ad->status == 'success') {
                    $blockad = $ad->data;
                    $wallet = $blockad->address;
                    $data['btc_wallet'] = $wallet;
                    $data['btc_amo'] = $bcoin;
                    $data->update();
                } else {
                    return back()->with('alert', 'Failed to Process');
                }
            }

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = $gatewayData->name;
            $varb = "litecoin:" . $wallet;
            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.blocklite', compact('bcoin', 'wallet', 'qrurl', 'page_title'));
        } elseif ($data->gateway_id == 504) {
            $method = Gateway::find(504);
            $apiKey = $method->val1;
            $version = 2;
            $pin = $method->val2;
            $block_io = new BlockIo($apiKey, $pin, $version);

            $dogeprice = file_get_contents("https://api.coinmarketcap.com/v1/ticker/dogecoin");
            $dresult = json_decode($dogeprice);
            $doge_usd = $dresult[0]->price_usd;

            $usd = $data->usd_amo;
            $bcoin = round($usd / $doge_usd, 8);

            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $ad = $block_io->get_new_address();

                if ($ad->status == 'success') {
                    $blockad = $ad->data;
                    $wallet = $blockad->address;
                    $data['btc_wallet'] = $wallet;
                    $data['btc_amo'] = $bcoin;
                    $data->update();
                } else {
                    return back()->with('alert', 'Failed to Process');
                }
            }

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = $gatewayData->name;
            $varb = $wallet;
            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.blockdog', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 505) {

            $method = Gateway::find(505);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {

                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.btc');

                $req = array(
                    'amount' => $data->usd_amo,
                    'currency1' => 'USD',
                    'currency2' => 'BTC',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );

                $result = $cps->CreateTransaction($req);
                if ($result['error'] == 'ok') {

                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];
                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();
                } else {
                    return back()->with('alert', 'Failed to Process');
                }
            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = $method->name;


            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=bitcoin:$wallet&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.coinpaybtc', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 506) {

            $method = Gateway::find(506);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {

                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.eth');

                $req = array(
                    'amount' => $data->usd_amo,
                    'currency1' => 'USD',
                    'currency2' => 'ETH',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );


                $result = $cps->CreateTransaction($req);

                if ($result['error'] == 'ok') {

                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();

                } else {
                    return back()->with('alert', 'Failed to Process');
                }

            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = $method->name;


            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.coinpayeth', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 507) {
            $method = Gateway::find(507);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {

                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.bch');

                $req = array(
                    'amount' => $data->usd_amo,
                    'currency1' => 'USD',
                    'currency2' => 'BCH',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );

                $result = $cps->CreateTransaction($req);

                if ($result['error'] == 'ok') {

                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();

                } else {
                    return back()->with('alert', 'Failed to Process');
                }

            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = $method->name;


            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.coinpaybch', compact('bcoin', 'wallet', 'qrurl', 'page_title'));
        } elseif ($data->gateway_id == 508) {

            $method = Gateway::find(508);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {

                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.dash');

                $req = array(
                    'amount' => $data->usd_amo,
                    'currency1' => 'USD',
                    'currency2' => 'DASH',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );

                $result = $cps->CreateTransaction($req);
                if ($result['error'] == 'ok') {

                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();
                } else {
                    return back()->with('alert', 'Failed to Process');
                }

            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = $method->name;

            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.coinpaydash', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 509) {

            $method = Gateway::find(509);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {

                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.doge');

                $req = array(
                    'amount' => $data->usd_amo,
                    'currency1' => 'USD',
                    'currency2' => 'DOGE',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );


                $result = $cps->CreateTransaction($req);

                if ($result['error'] == 'ok') {

                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();
                } else {
                    return back()->with('alert', 'Failed to Process');
                }

            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = $method->name;


            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.coinpaydoge', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 510) {

            $method = Gateway::find(510);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {

                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.ltc');

                $req = array(
                    'amount' => $data->usd_amo,
                    'currency1' => 'USD',
                    'currency2' => 'LTC',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );


                $result = $cps->CreateTransaction($req);

                if ($result['error'] == 'ok') {

                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();

                } else {
                    return back()->with('alert', 'Failed to Process');
                }

            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = $method->name;


            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.coinpayltc', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        }
        elseif ($data->gateway_id == 512) {
            $usd = $data->usd_amo;

            \CoinGate\CoinGate::config(array(
                'environment' => 'live', // sandbox OR live
                'auth_token' => $gatewayData->val1
            ));

            $post_params = array(
                'order_id' => $data->trx,
                'price_amount' => $usd,
                'price_currency' => 'USD',
                'receive_currency' => 'USD',
                'callback_url' => route('ipn.coingate'),
                'cancel_url' => route('deposit'),
                'success_url' => route('deposit'),
                'title' => 'Deposit' . $data->trx,
                'description' => 'Deposit'
            );

            $order = \CoinGate\Merchant\Order::create($post_params);

            if ($order) {

                return redirect($order->payment_url);
                exit();

            } else {
                return redirect()->route('deposit')->with('alert', 'Unexpected Error! Please Try Again');
                exit();
            }

        }
        elseif ($data->gateway_id == 513) {
            $all = file_get_contents("https://blockchain.info/ticker");
            $res = json_decode($all);
            $btcrate = $res->USD->last;
            $amon = $data->amount;
            $usd = $data->usd_amo;
            $bcoin = round($usd / $btcrate, 8);
            $method = Gateway::find(513);

            $callbackUrl = route('ipn.coinpay');
            $CP = new coinPayments();
            $CP->setMerchantId($method->val1);
            $CP->setSecretKey($method->val2);
            $ntrc = $data->trx;

            $form = $CP->createPayment('Purchase Coin', 'BTC', $bcoin, $ntrc, $callbackUrl);
            $page_title = $method->name;
            return view('user.payment.coinpay', compact('bcoin', 'form', 'page_title', 'amon'));
        }


    }


    //IPN Functions //
    //IPN Functions //////

    public function ipnpaypal()
    {

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        $paypalURL = "https://ipnpb.paypal.com/cgi-bin/webscr?";
        $callUrl = $paypalURL . $req;
        $verify = file_get_contents($callUrl);
        if ($verify == "VERIFIED") {
            //PAYPAL VERIFIED THE PAYMENT
            $receiver_email = $_POST['receiver_email'];
            $mc_currency = $_POST['mc_currency'];
            $mc_gross = $_POST['mc_gross'];
            $track = $_POST['custom'];

            //GRAB DATA FROM DATABASE!!
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $gatewayData = Gateway::find(101);
            $amount = $data->usd_amo;

            if ($receiver_email == $gatewayData->val1 && $mc_currency == "USD" && $mc_gross == $amount && $data->status == '0') {
                //Update User Data
                $this->userDataUpdate($data);
            }
        }

    }

    public function ipnperfect()
    {
        $gatewayData = Gateway::find(102);
        $passphrase = strtoupper(md5($gatewayData->val2));

        define('ALTERNATE_PHRASE_HASH', $passphrase);
        define('PATH_TO_LOG', '/somewhere/out/of/document_root/');
        $string =
            $_POST['PAYMENT_ID'] . ':' . $_POST['PAYEE_ACCOUNT'] . ':' .
            $_POST['PAYMENT_AMOUNT'] . ':' . $_POST['PAYMENT_UNITS'] . ':' .
            $_POST['PAYMENT_BATCH_NUM'] . ':' .
            $_POST['PAYER_ACCOUNT'] . ':' . ALTERNATE_PHRASE_HASH . ':' .
            $_POST['TIMESTAMPGMT'];

        $hash = strtoupper(md5($string));
        $hash2 = $_POST['V2_HASH'];

        if ($hash == $hash2) {

            $amo = $_POST['PAYMENT_AMOUNT'];
            $unit = $_POST['PAYMENT_UNITS'];
            $track = $_POST['PAYMENT_ID'];

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $gnl = GeneralSettings::first();

            if ($_POST['PAYEE_ACCOUNT'] == $gatewayData->val1 && $unit == "USD" && $amo == $data->usd_amo && $data->status == '0') {
                //Update User Data
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnstripe(Request $request)
    {
        $track = Session::get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();

        $this->validate($request,
            [
                'cardNumber' => 'required',
                'cardExpiry' => 'required',
                'cardCVC' => 'required',
            ]);

        $cc = $request->cardNumber;
        $exp = $request->cardExpiry;
        $cvc = $request->cardCVC;

        $exp = $pieces = explode("/", $_POST['cardExpiry']);
        $emo = trim($exp[0]);
        $eyr = trim($exp[1]);
        $cnts = round($data->usd_amo, 2) * 100;

        $gatewayData = Gateway::find(103);
        $gnl = GeneralSettings::first();

        Stripe::setApiKey($gatewayData->val1);

        try {
            $token = Token::create(array(
                "card" => array(
                    "number" => "$cc",
                    "exp_month" => $emo,
                    "exp_year" => $eyr,
                    "cvc" => "$cvc"
                )
            ));

            try {
                $charge = Charge::create(array(
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount' => $cnts,
                    'description' => 'item',
                ));

                if ($charge['status'] == 'succeeded') {

                    //Update User Data
                    $this->userDataUpdate($data);
                    return redirect()->route('deposit')->with('success', 'Deposit Amount Successfully');
                }
            } catch (Exception $e) {
                return redirect()->route('deposit')->with('alert', $e->getMessage());
            }

        } catch (Exception $e) {
            return redirect()->route('deposit')->with('alert', $e->getMessage());
        }

    }

    public function skrillIPN()
    {
        $track = Session::get('Track');
        $skrill = Gateway::find(104);
        $concatFields = $_POST['merchant_id']
            . $_POST['transaction_id']
            . strtoupper(md5($skrill->val2))
            . $_POST['mb_amount']
            . $_POST['mb_currency']
            . $_POST['status'];

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $gnl = GeneralSettings::first();

        if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == $skrill->val1 && $data->status = '0') {
            //Update User Data
            $this->userDataUpdate($data);
        }
    }

    public function ipnBchain()
    {
        $gatewayData = Gateway::find(501);

        $track = $_GET['invoice_id'];
        $secret = $_GET['secret'];
        $address = $_GET['address'];
        $value = $_GET['value'];
        $confirmations = $_GET['confirmations'];
        $value_in_btc = $_GET['value'] / 100000000;

        $trx_hash = $_GET['transaction_hash'];

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();


        if ($data->status == 0) {
            if ($data->btc_amo == $value_in_btc && $data->btc_wallet == $address && $secret == "ABIR" && $confirmations > 2) {

                //Update User Data
                $this->userDataUpdate($data);
            }

        }

    }

    public function blockIpnBtc(Request $request)
    {

        $DepositData = Deposit::where('status', 0)->where('gateway_id', 502)->where('try', '<=', 100)->get();

        $method = Gateway::find(502);
        $apiKey = $method->val1;
        $version = 2;
        $pin = $method->val2;
        $block_io = new BlockIo($apiKey, $pin, $version);


        foreach ($DepositData as $data) {
            $balance = $block_io->get_address_balance(array('addresses' => $data->btc_wallet));
            $bal = $balance->data->available_balance;

            if ($bal > 0 && $bal >= $data->btc_amo) {
                //Update User Data
                $this->userDataUpdate($data);
            }
            $data['try'] = $data->try + 1;
            $data->update();
        }

    }

    public function blockIpnLite(Request $request)
    {

        $DepositData = Deposit::where('status', 0)->where('gateway_id', 503)->where('try', '<=', 100)->get();

        $method = Gateway::find(503);
        $apiKey = $method->val1;
        $version = 2;
        $pin = $method->val2;
        $block_io = new BlockIo($apiKey, $pin, $version);


        foreach ($DepositData as $data) {
            $balance = $block_io->get_address_balance(array('addresses' => $data->btc_wallet));
            $bal = $balance->data->available_balance;

            if ($bal > 0 && $bal >= $data->btc_amo) {
                //Update User Data
                $this->userDataUpdate($data);
            }
            $data['try'] = $data->try + 1;
            $data->update();
        }
    }

    public function blockIpnDog(Request $request)
    {
        $DepositData = Deposit::where('status', 0)->where('gateway_id', 504)->where('try', '<=', 100)->get();

        $method = Gateway::find(504);
        $apiKey = $method->val1;
        $version = 2;
        $pin = $method->val2;
        $block_io = new BlockIo($apiKey, $pin, $version);


        foreach ($DepositData as $data) {
            $balance = $block_io->get_address_balance(array('addresses' => $data->btc_wallet));
            $bal = $balance->data->available_balance;

            if ($bal > 0 && $bal >= $data->btc_amo) {
                //Update User Data
                $this->userDataUpdate($data);
            }
            $data['try'] = $data->try + 1;
            $data->update();
        }
    }

    public function ipnCoinPayBtc(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "BTC" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayEth(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "ETH" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayBch(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "BCH" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayDash(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "DASH" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayDoge(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "DOGE" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayLtc(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "LTC" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }


    public function ipnCoinGate()
    {
        $data = Deposit::where('trx', $_POST['order_id'])->orderBy('id', 'DESC')->first();

        if ($_POST['status'] == 'paid' && $_POST['price_amount'] == $data->usd_amo && $data->status == '0') {
            $this->userDataUpdate($data);
        }

    }

    public function ipnCoin(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount1 = floatval($request->amount1);
        $currency1 = $request->currency1;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;

        if ($currency1 == "BTC" && $amount1 >= $bcoin && $data->status == '0') {
            if ($status >= 100 || $status == 2) {
                //Update User Data
                $this->userDataUpdate($data);
            }
        }

    }




}	
                                        