<?php

namespace App\Http\Controllers;

use App\Trx;
use Illuminate\Http\Request;
use App\WithdrawMethod;
use App\WithdrawLog;
use App\User;
use App\GeneralSettings;
use Illuminate\Support\Facades\Input;

class WithdrawController extends Controller
{
    public function __construct()
    {
    }
    
    public function index()
    {
        $page_title = "Withdraw Methods";
    	$withdarws = WithdrawMethod::latest()->get();
    	return view('admin.withdraw.index', compact('withdarws','page_title'));
    }

    public function store(Request $request)
    {

        $in = Input::except('_token','image');
        if($request->hasFile('image'))
        {
            $in['image'] = uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/images',$in['image']);
        }

        WithdrawMethod::create($in);

        return back()->with('success', 'Withdraw Settings Updated Successfully!');
    }

    public function withdrawUpdateSettings(Request $request)
    {
        $data = WithdrawMethod::find($request->id);
        $in = Input::except('_token','image');
        if($request->hasFile('image'))
        {
            $path = 'assets/images/'.$data->image;
            if(file_exists($path)){
                @unlink($path);
            }
            $data['image'] = uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/images',$data['image']);
        }
        $data->fill($in)->save();
        return back()->with('success', 'Withdraw Settings Updated Successfully!');
    }

    public function requests()
    {
    	$bits = WithdrawLog::latest()->where('status', '!=', 0)->paginate(30);
        $page_title = " Withdraw Request";
    	return view('admin.withdraw.requests', compact('bits','page_title'));
    }

     public function approve(Request $request, $id)
    {
        $basic = GeneralSettings::first();
        $withdr = WithdrawLog::findorFail($id);

        $withdr['status'] = 2;
        $withdr->save();
        return back()->with('success', 'Withdraw Request Approved Successfully!');
    }

    public function refundAmount(Request $request)
    {
        $basic = GeneralSettings::first();
        $withdr = WithdrawLog::findorFail($request->id);
        $withdr['status'] = 3;
        $withdr->save();

        $user = User::find($withdr['user_id']);
        $user->balance += $request->net_amount;
        $user->save();

        $tr = strtoupper(str_random(20));
        $trx = Trx::create([
            'user_id' => $user->id,
            'amount' => $request->net_amount,
            'main_amo' => $user->balance,
            'charge' => 0,
            'type' => '+',
            'title' => 'Withdraw Amount Refunded  ' ,
            'trx' => $tr,
        ]);


        $msg =  'Your withdraw amount refund  successfully ' . $request->net_amount. ' '.$basic->currency;
        send_email($user->email, $user->username, 'Withdraw Amount Refunded', $msg);
        send_sms($user->phone, $msg);

        return back()->with('success', 'Withdraw Amount Refunded Successfully!');
    }





}
