<?php

namespace App\Http\Controllers;

use App\BetInvest;
use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use App\User;
use App\Event;
use App\Match;
use App\BetQuestion;
use App\BetOption;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class DashboardController extends Controller
{
    public function __construct()
    {
        $now = Carbon::now();
        $data = Match::where('end_date','<', $now)->get();
        foreach ($data as $d) {
            $d->status = 2;
            $d->save();
        }
        $ques = BetQuestion::where('end_time','<', $now)->get();
        foreach ($ques as $d) {
            $d->status = 2;
            $d->save();
        }

    }

    public function events()
    {
        $data['page_title'] = 'Events Manage';
        $data['events'] = Event::latest()->get();
        return view('admin.pages.manage_event', $data);
    }

    public function UpdateEvents(Request $request)
    {
        $macCount = Event::where('name', $request->name)->where('id', '!=', $request->id)->count();
        if ($macCount > 0) {
            return back()->with('alert', 'Event Already Exist');
        }
        if ($request->id == 0) {
            $data['name'] = $request->name;
            $data['slug'] = str_slug($request->name);
            $data['status'] = $request->status;
            $res = Event::create($data);
            if ($res) {
                return back()->with('success', 'New Event Added Successfully!');
            } else {
                return back()->with('alert', 'Problem With Adding New Event');
            }

        } else {
            $mac = Event::findOrFail($request->id);
            $mac['name'] = $request->name;
            $mac['slug'] = str_slug($request->name);
            $mac['status'] = $request->status;
            $res = $mac->save();

            if ($res) {
                return back()->with('success', 'Event Updated Successfully!');
            } else {
                return back()->with('alert', 'Problem With Updating Event');
            }
        }
    }


    public function matches()
    {
        $now = Carbon::now();
        $data['page_title'] = 'Match Manage';
        $data['matches'] = Match::where('status','!=',2)->orderBy('start_date','asc')->paginate(25);
        return view('admin.pages.manage_match', $data);
    }
    public function searchMatches(Request $request)
    {
        $this->validate($request,
            [
                'search' => 'required',
            ]);
        $data['page_title'] = 'Search Match ';
        $data['matches'] = Match::where('name', 'like', '%' . $request->search . '%')->orWhere('start_date', 'like', '%' . $request->search . '%')->orWhere('end_date', 'like', '%' . $request->search . '%')->get();

        return view('admin.pages.search-match', $data);
    }



    public function closeMatches()
    {
        $data['page_title'] = 'Closed Matches';
        $data['matches'] = Match::orderBy('end_date', 'desc')->whereStatus(2)->paginate(25);
        return view('admin.pages.close_match', $data);
    }

    public function addMatch()
    {
        $data['page_title'] = 'Add Match';
        $data['events'] = Event::whereStatus(1)->get();
        return view('admin.pages.add-match', $data);
    }

    public function saveMatch(Request $request)
    {
        $this->validate($request, [
            'event_id' => 'required',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ],
            [
                'event_id.required' => 'Event must  be selected',
                'name.required' => 'Match must not be empty',
                'start_date.required' => 'Match start date must not be empty',
                'end_date.required' => 'Match end date must not be empty',
            ]);


        $in = Input::except('_token');
        $in['slug'] = str_slug($request->name);
        $in['start_date'] = Carbon::parse($request->start_date);
        $in['end_date'] = Carbon::parse($request->end_date);
        $in['status'] = $request->status == 'on' ? '1' : '0';
        Match::create($in);
        $notification = array('message' => 'Match Added  Succesfully', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function editMatch($id)
    {
        $data['match'] = Match::find($id);
        $data['page_title'] = 'Edit Match';
        $data['events'] = Event::whereStatus(1)->get();
        return view('admin.pages.edit-match', $data);
    }

    public function updateMatch(Request $request)
    {

        $data = Match::find($request->id);
        $this->validate($request, [
            'event_id' => 'required',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',

        ],
            [
                'event_id.required' => 'Event must  be selected',
                'name.required' => 'Match must not be empty',
                'start_date.required' => 'Match start date must not be empty',
                'end_date.required' => 'Match end date must not be empty',

            ]);

        $in = Input::except('_token');
        $in['slug'] = str_slug($request->name);
        $in['start_date'] = Carbon::parse($request->start_date);
        $in['end_date'] = Carbon::parse($request->end_date);
        $in['status'] = $request->status == 'on' ? '1' : '0';

        $data->fill($in)->save();

        $notification = array('message' => 'Match Update  Succesfully', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function addQuestion($id)
    {
        $title = $data['match_id'] = Match::find($id);
        $data['page_title'] = "$title->name";
        return view('admin.pages.add-question', $data);
    }

    public function saveQuestion(Request $request)
    {
//        return $request->all();
         $data = Match::find($request->match_id);
        if($data->end_date > Carbon::parse($request->end_time))
        {
            BetQuestion::create([
                'match_id' => $request->match_id,
                'end_time' => Carbon::parse($request->end_time),
                'question' => $request->description
            ]);
            $notification = array('message' => 'Question Added  Succesfully', 'alert-type' => 'success');
            return back()->with($notification);
        }else{
            $notification = array('message' => 'Question duration time too large \n  then Match ending date', 'alert-type' => 'error');
            return back()->with($notification);
        }

    }

    public function viewQuestion($id)
    {
        $now = Carbon::now();
        $title = $data['match_id'] = Match::find($id);
        $data['page_title'] = "$title->name";
        $data['questions'] = BetQuestion::whereMatch_id($id)->where('end_time' ,'>', $now )->paginate(20);
        return view('admin.pages.view-question', $data);
    }

    public function updateQuestion(Request $request)
    {
        $data = Match::find($request->match_id);
        if($data->end_date >  Carbon::parse($request->end_time))
        {

        $data = BetQuestion::findOrFail($request->id);
        $in = Input::except('_token');
        $in['end_time'] = Carbon::parse($request->end_time);
        $data->fill($in)->save();

        $notification = array('message' => 'Question Updated  Succesfully', 'alert-type' => 'success');
        return back()->with($notification);
        }else{
            $notification = array('message' => 'Question duration time too large \n  then Match ending date', 'alert-type' => 'error');
            return back()->with($notification);

        }
    }

    public function addOption($id)
    {
        $data['page_title'] = "Bet Option";
        $data['questions'] = BetQuestion::whereMatch_id($id)->get();
        $data['match_id'] = Match::whereId($id)->first();
        return view('admin.pages.add-option', $data);
    }

    public function storeOption(Request $request)
    {
        $this->validate($request, [
            'question_id' => 'required',
        ],
            [
                'question_id.required' => 'Question must  be selected',
            ]);

        for ($i = 0; $i < count($request->option_name); $i++) {
            BetOption::create([
                'match_id' => $request->match_id,
                'question_id' => $request->question_id,
                'status' => 1,
                'option_name' => $request->option_name[$i],
                'min_amo' => $request->min_amo[$i],
                'ratio1' => $request->ratio1[$i],
                'ratio2' => $request->ratio2[$i]
            ]);
        }

        $notification = array('message' => 'Option Added  Succesfully', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function createNewOption(Request $request)
    {
        BetOption::create([
            'match_id' => $request->match_id,
            'question_id' => $request->ques_id,
            'status' => $request->status,
            'option_name' => $request->option_name,
            'min_amo' => $request->min_amo,
            'ratio1' => $request->ratio1,
            'ratio2' => $request->ratio2
        ]);
        $notification = array('message' => 'Option Added  Succesfully', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function viewOption($id)
    {
        $ques = $data['ques'] = BetQuestion::findOrFail($id);
        $data['page_title'] = "$ques->question";
        $data['betoption'] = BetOption::whereQuestion_id($id)->paginate(20);
        return view('admin.pages.view-betoption', $data);
    }

    public function updateOption(Request $request)
    {
        $data = BetOption::find($request->id);

        $this->validate($request, [
            'option_name' => 'required',
            'ratio1' => 'required|between:0,99.99',
            'ratio2' => 'required|between:0,99.99',
        ],
            [
                'name.required' => 'Option must not be empty',
                'ratio1.required' => 'ratio1 must not be empty',
                'ratio2.required' => 'ratio must not be empty',
            ]);
        $in = Input::except('_token');
        $data->fill($in)->save();

        $notification = array('message' => 'Update  Successfully', 'alert-type' => 'success');
        return back()->with($notification);

    }

    public function viewAllOption($id)
    {
        $match= $data['match'] = Match::whereId($id)->first();
        $data['page_title'] = "$match->name";
        $data['betoption'] = BetOption::whereMatch_id($id)->paginate(20);
        return view('admin.pages.view-betoption-match', $data);
    }


    public function singleMatchByQuestion($id)
    {
        $title = $data['match_id'] = Match::find($id);
        $data['page_title'] = "$title->name";
        $data['questions'] = BetQuestion::whereMatch_id($id)->paginate(20);
        return view('admin.pages.view-question-byMatch', $data);
    }

    public function viewOptionEndTime($id)
    {
        $ques = $data['ques'] = BetQuestion::findOrFail($id);
        $data['page_title'] = "$ques->question";
        $data['betoption'] = BetOption::whereQuestion_id($id)->paginate(20);
        return view('admin.pages.view-betoption-endtime', $data);
    }

    public function makeWinner(Request $request)
    {
        $basic = GeneralSettings::first();

        $winner = BetInvest::whereBetoption_id($request->betoption_id)->whereMatch_id($request->match_id)->get();
        $losser = BetInvest::where('betoption_id', '!=', $request->betoption_id)->whereMatch_id($request->match_id)->get();
        foreach ($winner as $dd) {

            $user = User::find($dd->user_id);
            $user->balance += $dd->return_amount;
            $user->save();
            $txt = $dd->return_amount . ' ' . $basic->currency . ' credited in your account.' . '<br>' . $request->message;
            notify($user, 'Credited Your Account', $txt);

            $dd->status = 1;
            $dd->save();
        }
        foreach ($losser as $dd) {
            $dd->status = -1;
            $dd->save();
        }

        $betQ = BetQuestion::find($request->ques_id);
        $betQ->result = 1;
        $betQ->save();

        $betStatus = BetOption::find($request->betoption_id);
        $betStatus->status = 2;
        $betStatus->save();

        $betlosser = BetOption::where('id', '!=', $request->betoption_id)->whereQuestion_id($request->ques_id)->whereMatch_id($request->match_id)->get();
        foreach ($betlosser as $data) {
            $data->status = -2;
            $data->save();
        }
        return back()->with('success', 'Make winner Successfully!');
    }



    public function endDateByQuestion()
    {
        $now = Carbon::now();
        $data['page_title'] = "Awaiting Winner";
        $data['questions'] = BetQuestion::where('end_time','<', $now)->orderBy('end_time', 'desc')->paginate(20);
        return view('admin.pages.awaiting-winner', $data);
    }


}
