<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\BetOption;
use App\Match;
use App\BetQuestion;
use App\Soccer;
use Carbon\Carbon;
use App\Helper;

use App\Menu;
use App\Faq;
use App\Advertisment;

class FrontendController extends Controller{

    public function __construct()
    {
        $now = Carbon::now();
        $data = Match::where('end_date','<', $now)->get();
        foreach ($data as $d) {
            $d->status = 2;
            $d->save();
        }


    }

    public function soccers(){
        $url = 'https://api.sportradar.us/soccer-t3/eu/en/schedules/2019-01-13/results.json?api_key=q6hk5teg3qs59a2w4ubnxvqt';
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $jsonData = curl_exec($curlSession);

        $results = json_decode($jsonData);
        //print_r($jsonData);

        foreach($results as $key => $result){
            if($key=='results'){
                foreach($result as $keyval => $value){
                  $input['match_id'] = $value->sport_event->id; 
                  $input['scheduled'] = $value->sport_event->scheduled; 
                  $input['tournament_round'] = serialize($value->sport_event->tournament_round); 
                  $input['season'] = serialize($value->sport_event->season); 
                  $input['venue'] = serialize($value->sport_event->venue); 
                  $input['tournament'] = serialize($value->sport_event->tournament); 
                  $input['competitors'] = serialize($value->sport_event->competitors); 
                  $input['tournament_name'] = $value->sport_event->tournament->name; 
                  $input['tournament_id'] = $value->sport_event->tournament->id; 
                  $input['status'] = '1'; 
                  Soccer::create($input);                   
                }
            }
        }
        curl_close($curlSession);
        $soccer = Soccer::where('status','1')->get();
        return view('front.index',$soccer);
    }

    public function soccerEvent($id,$slug){
        $title = Soccer::find($id);
        $data['page_title'] = "$title->tournament_name All Matches";
        $now = Carbon::now();
        $data['matches'] = Soccer::where('tournament_name',$title->tournament_name)->where('status','1')->where('start_date','<=', $now)->where('end_date','>', $now)->get();
        $matches = $data['matches'];
        $soccer = Soccer::where('status','1')->groupBy('tournament_name')->get();
        return view('front.soccer-events',compact('matches','soccer'));
    }

    public function soccerMatch($id,$slug){
        $title = Soccer::where('match_id',$id)->first();
        $data['page_title'] = "$title->tournament_name All Matches";
        $now = Carbon::now();
        $match = Soccer::where('match_id',$id)->where('status','1')->where('start_date','<=', $now)->where('end_date','>', $now)->first();
        //$matches = $data['matches'];
        $soccer = Soccer::where('status','1')->groupBy('tournament_name')->get();
        return view('front.soccer-match',compact('match','soccer'));
    }

    public function index()
    {
        $now = Carbon::now();
        $data['page_title'] = "Home";
        $data['matches'] = Match::whereStatus(1)->where('status', '!=' ,2)->where('start_date','<=', $now)->where('end_date','>', $now)->latest()->take(7)->get();
        $url = 'https://api.sportradar.us/soccer-t3/eu/en/schedules/2019-01-13/results.json?api_key=q6hk5teg3qs59a2w4ubnxvqt';
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $jsonData = curl_exec($curlSession);

        $results = json_decode($jsonData);
        foreach($results as $key => $result){
            if($key=='results'){
                foreach($result as $keyval => $value){

       
                  $input['match_id'] = str_replace('sr:match:','',$value->sport_event->id); 
                  $input['scheduled'] = $value->sport_event->scheduled;
                  $input['tournament_round'] = serialize($value->sport_event->tournament_round); 
                  $input['season'] = serialize($value->sport_event->season);
                  $input['start_date'] = $value->sport_event->season->start_date;
                  $input['end_date'] = $value->sport_event->season->end_date;
                  $input['season'] = serialize($value->sport_event->season);
                  $input['venue'] = serialize($value->sport_event->venue); 
                  $input['tournament'] = serialize($value->sport_event->tournament); 
                  $input['competitors'] = serialize($value->sport_event->competitors);
                  $input['tournament_name'] = $value->sport_event->tournament->name; 
                  $input['tournament_id'] = str_replace('sr:tournament:','',$value->sport_event->tournament->id); 
                  $input['status'] = '1'; 
                  $recode = Soccer::where('match_id',$input['match_id']);
                  $recode->delete();
                  Soccer::create($input);
                  
                 /*  
                  
                  
                   */                  
                }
            }
        }
        curl_close($curlSession);
        $soccer = Soccer::where('status','1')->groupBy('tournament_name')->get();
        $matches = $data['matches'];
        return view('front.index',compact('matches','soccer'));
    }
    public function viewMore()
    {
        $now = Carbon::now();
        $data['page_title'] = "All Match";

        $data['matches'] = Match::whereStatus(1)->where('status', '!=' ,2)->where('start_date','<=', $now)->where('end_date','>', $now)->latest()->get();
        return view('front.all-match',$data);
    }

    public function matches($id)
    { 
        $title = Event::find($id);
        $data['page_title'] = "$title->name All Matches";
        $now = Carbon::now();
        $data['matches'] = Match::whereEvent_id($id)->whereStatus(1)->where('status', '!=' ,2)->where('start_date','<=', $now)->where('end_date','>', $now)->latest()->get();
        return view('front.events',$data);
    }

    public function question($id)
    {  
        $now = Carbon::now();
        $title = $data['match'] = Match::find($id);
        $data['page_title'] = "$title->name ";
        $data['question'] = BetQuestion::whereMatch_id($id)->whereStatus(1)->where('end_time','>=', $now)->get();
        return view('front.match-question',$data);
    }

    public function questionByMatch($id)
    {
        $data['ques'] = $ques =  BetQuestion::whereId($id)->first();
        $data['page_title'] = "$ques->question";
        $data['bets'] = BetOption::whereQuestion_id($id)->whereStatus(1)->get();
        return view('front.betOption',$data);
    }

    public function menu($slug)
    {
        $menu = $data['menu'] =  Menu::whereSlug($slug)->first();
        $data['page_title'] = "$menu->name";
        return view('layouts.menu',$data);
    }
    public function about()
    {
        $data['page_title'] = "About Us";
        return view('layouts.about',$data);
    }

    public function faqs()
    {
        $data['faqs'] =  Faq::all();
        $data['page_title'] = "Faqs";
        return view('layouts.faqs',$data);
    }


    public function contactUs()
    {
        $data['page_title'] = "Contact Us";
        return view('layouts.contact',$data);
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);
        $subject = "Contact Us";
        send_email($request->email,$request->name, $subject,$request->message);
        $notification =  array('message' => 'Contact Message Send.', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function clickadd($id){

        $add = Advertisment::findOrFail($id);
        $data = array();
        $data['views'] = $add->views+1;
        Advertisment::whereId($id)->update($data);
        $go = $add->link;
        return redirect($go);
    }

    public function register($reference)
    {
        $page_title = "Sign Up";
        return view('auth.register',compact('reference','page_title'));
    }


}
