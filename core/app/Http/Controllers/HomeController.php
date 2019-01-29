<?php

namespace App\Http\Controllers;

use App\CommissionLog;
use App\Match;
use App\Trx;
use App\WithdrawLog;
use App\WithdrawMethod;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Session;
use Image;
use App\Gateway;
use App\GeneralSettings;
use App\Deposit;


use App\BetInvest;
use App\BetOption;
use App\BetQuestion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = "Dashboard";
        $user = Auth::user();
        $data['invests'] = BetInvest::whereUser_id($user->id)->latest()->paginate(20);
        return view('user.activites',$data);
    }


    public function authCheck(){
        if(Auth()->user()->status == '1' && Auth()->user()->email_verify == '1' && Auth()->user()->sms_verify == '1')
        {
            return redirect()->route('home');
        }
        else
        {
            $data['page_title'] = "Authorization";
            return view('user.authorization',$data);
        }
    }

    public function sendVcode(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if(Carbon::parse($user->phone_time)->addMinutes(1) > Carbon::now()){
            $time = Carbon::parse($user->phone_time)->addMinutes(1);
            $delay= $time->diffInSeconds(Carbon::now());
            $delay = gmdate('i:s', $delay);
            session()->flash('alert', 'You can resend Verification Code after '.$delay. ' minutes');
        }else{
            $code = strtoupper(Str::random(6));
            $user->phone_time = Carbon::now();
            $user->sms_code = $code;
            $user->save();
            send_sms($user->phone, 'Your Verification Code is '.$code);

            session()->flash('success', 'Verification Code Send successfully');
        }
        return back();
    }

    public function smsVerify(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if($user->sms_code == $request->sms_code){
            $user->phone_verify = 1;
            $user->save();
            session()->flash('success', 'Your Profile has been verfied successfully');
            return redirect()->route('home');
        }else{
            session()->flash('alert', 'Verification Code Did not matched');
        }
        return back();
    }

    public function sendEmailVcode(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if(Carbon::parse($user->email_time)->addMinutes(1) > Carbon::now()){
            $time = Carbon::parse($user->email_time)->addMinutes(1);
            $delay= $time->diffInSeconds(Carbon::now());
            $delay = gmdate('i:s', $delay);
            session()->flash('alert', 'You can resend Verification Code after '.$delay. ' minutes');
        }else{
            $code = strtoupper(Str::random(6));
            $user->email_time = Carbon::now();
            $user->verification_code = $code;
            $user->save();
            send_email($user->email, $user->username, 'Verificatin Code', 'Your Verification Code is '.$code);
            session()->flash('success', 'Verification Code Send successfully');
        }
        return back();
    }

    public function postEmailVerify(Request $request)
    {

            $user = User::find(Auth::user()->id);
        if($user->	verification_code == $request->email_code){
            $user->email_verify = 1;
            $user->save();
            session()->flash('success', 'Your Profile has been verfied successfully');
            return redirect()->route('home');
        }else{
            session()->flash('alert', 'Verification Code Did not matched');
        }
        return back();
    }




    public function editProfile()
    {
        $data['page_title'] = "Edit Profile";
        $data['user'] = User::findOrFail(Auth::user()->id);
        return view('user.edit-profile', $data);
    }

    public function submitProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|min:10|unique:users,phone,' . $user->id,
            'username' => 'required|min:5||regex:/^\S*$/u|unique:users,username,' . $user->id,
            'image' => 'mimes:png,jpg,jpeg'
        ]);
        $in = Input::except('_method', '_token');
        $in['reference'] = $request->username;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $request->username . '.jpg';
            $location = 'assets/images/user/' . $filename;
            $in['image'] = $filename;
            if ($user->image != 'user-default.png') {
                $path = './assets/images/user/';
                $link = $path . $user->image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(400, 400)->save($location);
        }
        $user->fill($in)->save();
        $notification = array('message' => 'Profile Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);

    }

    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view('user.change-password', $data);
    }

    public function submitPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {

            $c_password = Auth::user()->password;
            $c_id = Auth::user()->id;
            $user = User::findOrFail($c_id);
            if (Hash::check($request->current_password, $c_password)) {

                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();

                $notification = array('message' => 'Password Changes Successfully.', 'alert-type' => 'success');
                return back()->with($notification);
            } else {
                $notification = array('message' => 'Current Password Not Match', 'alert-type' => 'warning');
                return back()->with($notification);
            }

        } catch (\PDOException $e) {
            $notification = array('message' => $e->getMessage(), 'alert-type' => 'warning');
            return back()->with($notification);
        }
    }

    public function deposit()
    {
        $data['page_title'] = "Select Payment Gateways";
        $data['gates'] = Gateway::whereStatus(1)->get();
        return view('user.deposit', $data);
    }


    public function depositDataInsert(Request $request)
    {
        $this->validate($request,['amount' => 'required|numeric|min:1','gateway' => 'required']);

        if($request->amount<=0)
        {
            return back()->with('alert', 'Invalid Amount');
        }
        else
        {
            $gate = Gateway::findOrFail($request->gateway);

            if(isset($gate))
            {
                if($gate->minamo <= $request->amount && $gate->maxamo >= $request->amount)
                {
                    $charge = $gate->fixed_charge + ($request->amount*$gate->percent_charge/100);
                    $usdamo = ($request->amount + $charge)/$gate->rate;

                    $depo['user_id'] = Auth::id();
                    $depo['gateway_id'] = $gate->id;
                    $depo['amount'] = $request->amount;
                    $depo['charge'] = $charge;
                    $depo['usd_amo'] = round($usdamo,2);
                    $depo['btc_amo'] = 0;
                    $depo['btc_wallet'] = "";
                    $depo['trx'] = str_random(16);
                    $depo['try'] = 0;
                    $depo['status'] = 0;
                    Deposit::create($depo);

                    Session::put('Track', $depo['trx']);

                    return redirect()->route('user.deposit.preview');

                }
                else
                {
                    return back()->with('alert', 'Please Follow Deposit Limit');
                }
            }
            else
            {
                return back()->with('alert', 'Please Select Deposit gateway');
            }
        }

    }

    public function depositPreview()
    {
        $track = Session::get('Track');
        $data = Deposit::where('status',0)->where('trx',$track)->first();
        $page_title = "Deposit Preview";
        return view('user.payment.preview', compact('data', 'page_title'));
    }


    public function betByUser(Request $request)
    {
        $basic = GeneralSettings::first();

        $this->validate($request,
            [
                'return_amount' => 'required',
            ]);

        $bet = BetOption::find($request->betoption_id);
        $user = User::find($request->user_id);
        if($user->balance > $request->invest_amount)
        {
            if($bet->min_amo <= $request->invest_amount)
            {
                $data['user_id'] =$request->user_id;
                $data['betoption_id'] =$request->betoption_id;
                $data['match_id'] =$request->match_id;
                $data['invest_amount'] =$request->invest_amount;
                $data['return_amount'] =$request->return_amount;

                BetInvest::create($data);
                $user->balance -= $request->invest_amount;
                $user->save();


                $mm = Match::whereId($request->match_id)->first();
                $tr = strtoupper(str_random(20));
                $trx = Trx::create([
                    'user_id' => $user->id,
                    'amount' => $request->invest_amount,
                    'main_amo' => $user->balance,
                    'charge' => 0,
                    'type' => '-',
                    'title' => 'Bet in '. $mm->name,
                    'trx' => $tr
                ]);

                return back()->with('success', 'Succesfully Bet this');
            }
            else{
                return back()->with('alert', "minimum pay $bet->min_amo $basic->currency");
            }
        }else{
            return back()->with('alert', 'Insufficent Balance');
        }
    }

    public function activity()
    {
        $user = Auth::user();
         $data['invests'] = Trx::whereUser_id($user->id)->latest()->paginate(15);
        $data['page_title'] = "Transaction Log";
        return view('user.trx',$data);
    }
    public function referLog()
    {
        $user = Auth::user();
         $data['invests'] = User::where('refer',$user->id)->latest()->paginate(10);
        $data['page_title'] = "Referral List";
        return view('user.refer',$data);
    }


    public function depositLog()
    {
        $user = Auth::user();
        $data['invests'] = Deposit::whereUser_id($user->id)->latest()->paginate(15);
        $data['page_title'] = "Deposit Log";
        return view('user.trans',$data);
    }
    public function withdrawLog()
    {
        $user = Auth::user();
        $data['invests'] = WithdrawLog::whereUser_id($user->id)->where('status', '!=',0)->latest()->paginate(20);
        $data['page_title'] = "Withdraw Log";
        return view('user.withdraw-log',$data);
    }

    public function withdrawMoney()
    {
        $data['withdrawMethod'] = WithdrawMethod::whereStatus(1)->get();
        $data['page_title'] = "Withdraw Money";
        return view('user.withdraw-money', $data);
    }

    public function requestPreview(Request $request)
    {
        $this->validate($request,[
            'method_id' => 'required|numeric',
            'amount' => 'required|numeric'
        ]);
        $basic = GeneralSettings::first();
        $bal = User::findOrFail(Auth::user()->id);

        $method = WithdrawMethod::findOrFail($request->method_id);
        $ch = $method->fix + round(($request->amount * $method->percent) / 100,$basic->decimal);
        $reAmo = $request->amount + $ch;
        if ($reAmo < $method->withdraw_min){
            return back()->with('alert','Your Request Amount is Smaller Then Withdraw Minimum Amount.');
        }
        if ($reAmo > $method->withdraw_max){
            return back()->with('alert','Your Request Amount is Larger Then Withdraw Maximum Amount.');
        }
        if ($reAmo > $bal->balance){
            return back()->with('alert','Your Request Amount is Larger Then Your Current Balance.');
        }else{

            $tr = strtoupper(str_random(20));
            $w['amount'] = $request->amount;
            $w['method_id'] = $request->method_id;
            $w['charge'] = $ch;
            $w['transaction_id'] = $tr;
            $w['net_amount'] = $reAmo;
            $w['user_id'] = Auth::user()->id;
            $trr = WithdrawLog::create($w);
            $data['withdraw'] = $trr;
            Session::put('wtrx', $trr->transaction_id);

            $data['method'] = $method;
            $data['balance'] = Auth::user();

            $data['page_title'] = "Preview";
            return view('user.withdraw-preview', $data);
        }
    }


    public function requestSubmit(Request $request)
    {
//        return $request->all();
        $basic = GeneralSettings::first();
        $this->validate($request,[
            'withdraw_id' => 'required|numeric',
            'send_details' => 'required'
        ]);

        $ww = WithdrawLog::findOrFail($request->withdraw_id);
        $ww->send_details = $request->send_details;
        $ww->message = $request->message;
        $ww->status = 1;
        $ww->save();

        $user = Auth::user();
        $user->balance = $user->balance - $ww->net_amount;
        $user->save();

        $trx = Trx::create([
            'user_id' => $user->id,
            'amount' => $ww->amount,
            'main_amo' => $user->balance,
            'charge' => $ww->charge,
            'type' => '-',
            'title' => 'Withdraw Via ' . $ww->method->name,
            'trx' => $ww->transaction_id
        ]);

        $text = $ww->amount." - ". $basic->currency." Withdraw Request Send via ".$ww->method->name.". <br> Transaction ID Is : <b>#$ww->transaction_id</b>";
        notify($user, 'Withdraw Via ' . $ww->method->name, $text);
        return redirect()->route('withdraw.money')->with('success', 'Withdraw request Successfully Submitted. Wait For Confirmation.');

    }



}
