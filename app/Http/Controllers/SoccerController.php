<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Soccer\TournamentList;
use App\Model\Soccer\Season;
use App\Model\Soccer\SeasonCoverageInfo;
use App\Model\Soccer\Venue;
use App\Model\Soccer\SportEvent;
use App\Model\Soccer\Team;
use App\Model\Soccer\SportEventResult;
use App\Model\Soccer\MatchFun;
use App\Model\Soccer\Lineup;
use App\Model\Soccer\Referee;
use App\Model\Soccer\Statistics;
use App\Model\Soccer\SportEventCondition;
use App\Model\Soccer\MissingPlayer;
use App\Model\Soccer\TeamProfile;
use App\Model\Soccer\TeamResult;
use App\Model\Soccer\TeamSchedule;
use App\Model\Soccer\TeamStatistics;
use App\Model\Soccer\TeamVsTeam;
use App\Model\Soccer\TournamentInfo;
use App\Model\Soccer\TournamentLeader;
use App\Model\Soccer\TournamentStanding;
use App\Model\Soccer\TournamentResult;
use App\Model\Soccer\TournamentSchedule;




class SoccerController extends Controller{

//    public $api_key='q6hk5teg3qs59a2w4ubnxvqt';
    public $api_key="99sebddgk5wg6bp35t99ff95";
    public $access_level='xt';
    public $version=3;
//    public $league_group='eu';
    public $league_group='global';
    public $language_code='ko';
    public $format='json';

    public $odd_api_row_key='r4g7e8fkeetj3xp7fjw9wp76';
    public $odd_api_us_key='58k3dmv5cmjdgsx5q4u9xgej';
    public $ood_version=1;

    public function getResponse($url1,$key=null){
        if (is_null($key))
            $url=$url1."?api_key=".$this->api_key;
        else
            $url=$url1;
        echo($url);
//        exit();
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        $jsonData = curl_exec($curlSession);
        $results = json_decode($jsonData);
        curl_close($curlSession);
        return $results;
    }

    public function getTournamentList($league_group,$language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments.$this->format";

        $json_data=$this->getResponse($url);
        if (isset($json_data->tournaments)){
            $tournaments=$json_data->tournaments;
            foreach ($tournaments as $tournament){
                $tournament_id=$tournament->id;
                $this->saveTournamentList($tournament,$league_group,$language_code);
                $this->saveSeason($tournament_id,$tournament->current_season,$language_code);
                $season_id=$tournament->current_season->id;
                $this->saveSeasonCoverInfo($season_id,$tournament->season_coverage_info);
            }
        }

        echo "<pre>";
        print_r($json_data);
    }


    public function getDailySchedule($league_group, $language_code,$year,$month,$date){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/schedules/$year-$month-$date/schedule.json";
        $json_data=$this->getResponse($url);
        if (isset($json_data->sport_events)){
            $sport_events=$json_data->sport_events;
            foreach ($sport_events as $sport_event){
                $this->saveTournamentList($sport_event->tournament,$league_group,$language_code);  // Save Tournament
                $this->saveSeason($sport_event->tournament->id,$sport_event->season,$language_code);
                $this->saveVenue($sport_event->venue,$language_code);
                $this->saveTeam($sport_event->competitors,$language_code);
                $this->saveSportEvent($sport_event,$language_code);
            }
        }

        echo "<pre>";
        print_r($json_data);
    }

    public function getDailyResults($league_group, $language_code,$year,$month,$date){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/schedules/$year-$month-$date/results.json";
        $json_data=$this->getResponse($url);

        if (isset($json_data->results) && !empty($json_data->results)){
            $results=$json_data->results;
            foreach ($results as $result){
                $match_id=$result->sport_event->id;
                $sport_event=$result->sport_event;
                $this->saveTournamentList($sport_event->tournament,$league_group,$language_code);  // Save Tournament
                $this->saveSeason($sport_event->tournament->id,$sport_event->season,$language_code);
                $this->saveVenue($sport_event->venue,$language_code);
                $this->saveTeam($sport_event->competitors,$language_code);
                $this->saveSportEventResult($match_id,$result->sport_event_status);
            }
        }
        echo "<pre>";
        print_r($json_data);
    }

    public function getDeletedMatches($league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/schedules/deleted_matches.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getLiveResults($league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/schedules/live/results.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getMatchFun($match_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/matches/$match_id/funfacts.json";
        $json_data=$this->getResponse($url);

        if (isset($json_data->sport_event)){
            $sport_event=$json_data->sport_event;
            $this->saveTournamentList($sport_event->tournament,$league_group,$language_code);  // Save Tournament
            $this->saveSeason($sport_event->tournament->id,$sport_event->season,$language_code);
            $this->saveVenue($sport_event->venue,$language_code);
            $this->saveTeam($sport_event->competitors,$language_code);
            $this->saveSportEvent($sport_event,$language_code);
        }
        $this->saveMatchFuns($match_id, $json_data, $language_code);

        echo "<pre>";
        print_r($json_data);
    }

    public function getMatchLineup($match_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/matches/$match_id/lineups.json";
        $json_data=$this->getResponse($url);
        if (isset($json_data->sport_event)){
            $sport_event=$json_data->sport_event;
            $this->saveTournamentList($sport_event->tournament,$league_group,$language_code);  // Save Tournament
            $this->saveSeason($sport_event->tournament->id,$sport_event->season,$language_code);
            $this->saveVenue($sport_event->venue,$language_code);
            $this->saveTeam($sport_event->competitors,$language_code);
        }
        if (isset($json_data->lineups)){
            $this->saveLineup($match_id,$json_data->lineups,$language_code);
        }

        echo "<pre>";
        print_r($json_data);
    }

    public function getMatchProbability($match_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/matches/$match_id/probabilities.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getMatchSummary($match_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/matches/$match_id/summary.json";
        $json_data=$this->getResponse($url);
        if (isset($json_data->sport_event)){
            $sport_event=$json_data->sport_event;
            $this->saveTournamentList($sport_event->tournament,$league_group,$language_code);  // Save Tournament
            $this->saveSeason($sport_event->tournament->id,$sport_event->season,$language_code);
            $this->saveVenue($sport_event->venue,$language_code);
            $this->saveTeam($sport_event->competitors,$language_code);
        }

        if (isset($json_data->sport_event_conditions)){
            $sport_event_conditions=$json_data->sport_event_conditions;
            if (isset($json_data->sport_event_conditions->referee))
                $this->saveReferee($json_data->sport_event_conditions->referee,$language_code);
            $this->saveSportEventCondition($match_id, $sport_event_conditions->referee->id, $sport_event_conditions->venue->id,
                                            $sport_event_conditions->weather_info,$language_code);
        }
        if (isset($json_data->statistics)){
            $this->saveStaticstics($match_id,$json_data->statistics,$language_code);
        }
        if (isset($json_data->sport_event_status)){
            $this->saveSportEventResult($match_id,$json_data->sport_event_status);
        }

        echo "<pre>";
        print_r($json_data);
    }

    public function getMatchTimeline($match_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/matches/$match_id/timeline.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getMissingPlayer($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/missing_players.json";
        $json_data=$this->getResponse($url);
        if (isset($json_data->teams)){
            $this->saveMissingPlayers($tournament_id,$json_data->teams,$language_code);

        }

        echo "<pre>";
        print_r($json_data);
    }

    public function getPlayerProfile($player_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/players/$player_id/profile.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTeamProfile($team_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/teams/$team_id/profile.json";
        $json_data=$this->getResponse($url);
        $this->saveTeamProfile($json_data,$language_code);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTeamResults($team_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/teams/$team_id/results.json";
        $json_data=$this->getResponse($url);
        if (isset($json_data->results) && !empty($json_data->results)){
            $results=$json_data->results;
            foreach ($results as $result){
                $match_id=$result->sport_event->id;
                $sport_event=$result->sport_event;
                $this->saveTournamentList($sport_event->tournament,$league_group,$language_code);  // Save Tournament
                $this->saveSeason($sport_event->tournament->id,$sport_event->season,$language_code);
                if (isset($sport_event->venue))
                    $this->saveVenue($sport_event->venue,$language_code);
                $this->saveTeam($sport_event->competitors,$language_code);
                $this->saveSportEventResult($match_id,$result->sport_event_status);
            }
        }
        $this->saveTeamResult($json_data,$language_code);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTeamSchedule($team_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/teams/$team_id/schedule.json";
        $json_data=$this->getResponse($url);
        if (isset($json_data->schedule) && !empty($json_data->schedule)){
            foreach ($json_data->schedule as $schedule){
                $this->saveTournamentList($schedule->tournament,$league_group,$language_code);  // Save Tournament
                $this->saveSeason($schedule->tournament->id,$schedule->season,$language_code);
                if (isset($sport_event->venue))
                    $this->saveVenue($schedule->venue,$language_code);
                $this->saveTeam($schedule->competitors,$language_code);
            }
            $this->saveTeamSchedule($json_data,$language_code);
        }
        echo "<pre>";
        print_r($json_data);
    }

    public function getTeamStatistics($tournament_id,$team_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/teams/$team_id/statistics.json";
        $json_data=$this->getResponse($url);
        $this->saveTeamStatistics($json_data,$language_code);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTeamVsTeam($team_id1,$team_id2,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/teams/$team_id1/versus/$team_id2/matches.json";
        $json_data=$this->getResponse($url);
        $this->TeamVsTeam($json_data, $language_code);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentInfo($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/info.json";
        $json_data=$this->getResponse($url);
        $this->saveTournamentInfo($json_data, $language_code);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentLeaders($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/leaders.json";
        $json_data=$this->getResponse($url);
        $this->saveTournamentLeader($json_data,$language_code);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentLiveStandings($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/live_standings.json";
        $json_data=$this->getResponse($url);

        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentResults($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/results.json";
        $json_data=$this->getResponse($url);
        $this->saveTournamentResult($json_data,$language_code);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentSchedule($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/schedule.json";
        $json_data=$this->getResponse($url);
        $this->saveTournamentSchedule($json_data,$language_code);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentSeasons($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/seasons.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentStandings($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/standings.json";
        $json_data=$this->getResponse($url);
        $this->saveTournamentStanding($json_data, $language_code);
        echo "<pre>";
        print_r($json_data);
    }




    public function saveTournamentList($tournament,$league_group, $language_code){
        $tournament_id=$tournament->id;
        $temps=TournamentList::where([['tournament_id','=',$tournament_id],['league_group','=',$league_group],['language_code','=',$language_code]])->get();
        $TournamentList=null;
        if (!$temps->first())
        {
            $TournamentList=new TournamentList;
        }

        else
            $TournamentList=$temps->first();

        $TournamentList->tournament_id=$tournament_id;
        $TournamentList->name=$tournament->name;
        $TournamentList->sport_id=$tournament->sport->id;
        $TournamentList->sport_name=$tournament->sport->name;
        $TournamentList->category_id=$tournament->category->id;
        $TournamentList->category_name=$tournament->category->name;
        if (isset($tournament->category->country_code))
            $TournamentList->category_country_code=$tournament->category->country_code;
        $TournamentList->league_group=$league_group;
        $TournamentList->language_code=$language_code;
        $TournamentList->save();

    }

    public function saveSeason($tournament_id,$season_data,$language_code){
        $season_id=$season_data->id;
        $temps=Season::where([['season_id','=',$season_id],['tournament_id','=',$tournament_id],['language_code','=',$language_code]])->get();
        $season=null;
        if (!$temps->first())
            $season=new Season;
        else
            $season=$temps->first();
        $season->season_id=$season_id;
        $season->tournament_id=$tournament_id;
        $season->name=$season_data->name;
        $season->start_date=$season_data->start_date;
        $season->end_date=$season_data->end_date;
        $season->year=$season_data->year;
        $season->language_code=$language_code;
        $season->save();
    }

    public function saveSeasonCoverInfo($season_id,$season_cover_info_data){
        $temps=SeasonCoverageInfo::where('season_id',$season_id)->get();
        $season_cover_info=null;
        if (!$temps->first())
            $season_cover_info=new SeasonCoverageInfo;
        else
            $season_cover_info=$temps->first();
        $season_cover_info->season_id=$season_id;
        $season_cover_info->scheduled=$season_cover_info_data->scheduled;
        $season_cover_info->played=$season_cover_info_data->played;
        $season_cover_info->max_coverage_level=$season_cover_info_data->max_coverage_level;
        $season_cover_info->max_covered=$season_cover_info_data->max_covered;
        $season_cover_info->min_coverage_level=$season_cover_info_data->min_coverage_level;
        $season_cover_info->save();
    }

    public function saveVenue($venue_data,$language_code){

        $temps=Venue::where([['venue_id','=',$venue_data->id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $venue=$temps->first();
        else
            $venue=new Venue;

        $venue->venue_id=$venue_data->id;
        $venue->name=$venue_data->name;
        $venue->capacity=$venue_data->capacity;
        $venue->city_name=$venue_data->city_name;
        $venue->country_name=$venue_data->country_name;
        $venue->map_coordinate=$venue_data->map_coordinates;
        $venue->country_code=$venue_data->country_code;
        $venue->language_code=$language_code;
        $venue->save();
    }

    public function saveTeam($team_datas,$language_code){
        foreach ($team_datas as $team_data){
            $temps=Team::where([['id','=',$team_data->id],['language_code','=',$language_code]])->get();
            if ($temps->first())
                $team=$temps->first();
            else
                $team=new Team;
            $team->team_id=$team_data->id;
            $team->name=$team_data->name;
            $team->country=$team_data->country;
            $team->country_code=$team_data->country_code;
            $team->abbreviation=$team_data->abbreviation;
            $team->qualifier=$team_data->qualifier;
            $team->language_code=$language_code;
            $team->save();
        }
    }


    public function saveSportEvent($sport_data,$language_code){
        $temps=SportEvent::where([['match_id','=',$sport_data->id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $sport_event=$temps->first();
        else
            $sport_event=new SportEvent;
        $sport_event->match_id=$sport_data->id;
        $sport_event->scheduled=$sport_data->scheduled;
        $sport_event->start_time_tbd=$sport_data->start_time_tbd;
        if (isset($sport_data->status))
            $sport_event->status=$sport_data->status;
        if (isset($sport_data->tournament_round->type))
            $sport_event->tournament_round_type=$sport_data->tournament_round->type;
        if (isset($sport_data->tournament_round->name))
            $sport_event->tournament_round_name=$sport_data->tournament_round->name;
        if (isset($sport_data->tournament_round->cup_round_match_number))
            $sport_event->tournament_round_cup_round_match_number=$sport_data->tournament_round->cup_round_match_number;
        if (isset($sport_data->tournament_round->cup_round_matches))
            $sport_event->tournament_round_cup_round_matches=$sport_data->tournament_round->cup_round_matches;
        if (isset($sport_data->tournament_round->other_match_id))
            $sport_event->tournament_round_other_match_id=$sport_data->tournament_round->other_match_id;
        if (isset($sport_data->tournament_round->phase))
            $sport_event->tournament_round_phase=$sport_data->tournament_round->phase;
        $sport_event->compatitor_id1=$sport_data->competitors[0]->id;
        $sport_event->compatitor_id2=$sport_data->competitors[1]->id;
        $sport_event->tournament_id=$sport_data->tournament->id;
        $sport_event->season_id=$sport_data->season->id;
        $sport_event->language_code=$language_code;
        $sport_event->save();
    }


    public function saveSportEventResult($match_id, $sport_event_status){
        $temps=SportEventResult::where('match_id',$match_id)->get();
        if ($temps->first())
            $sport_event_result=$temps->first();
        else
            $sport_event_result=new SportEventResult;
        $sport_event_result->match_id=$match_id;
        if (isset($sport_event_status->status))
            $sport_event_result->status=$sport_event_status->status;
        if (isset($sport_event_status->match_status))
             $sport_event_result->match_status=$sport_event_status->match_status;
        if (isset($sport_event_status->home_score))
            $sport_event_result->home_score=$sport_event_status->home_score;
        if (isset($sport_event_status->away_score))
            $sport_event_result->away_score=$sport_event_status->away_score;
        if (isset($sport_event_status->winner_id))
            $sport_event_result->winner_id=$sport_event_status->winner_id;
        if (isset($sport_event_status->period_scores)){
            $sport_event_result->period_score1_home_score=$sport_event_status->period_scores[0]->home_score;
            $sport_event_result->period_score1_away_score=$sport_event_status->period_scores[0]->away_score;
            $sport_event_result->period_score1_type=$sport_event_status->period_scores[0]->type;
            $sport_event_result->period_score1_number=$sport_event_status->period_scores[0]->number;

            $sport_event_result->period_score2_home_score=$sport_event_status->period_scores[1]->home_score;
            $sport_event_result->period_score2_away_score=$sport_event_status->period_scores[1]->away_score;
            $sport_event_result->period_score2_type=$sport_event_status->period_scores[1]->type;
            $sport_event_result->period_score2_number=$sport_event_status->period_scores[1]->number;

        }

        $sport_event_result->save();
    }


    public function saveMatchFuns($match_id, $match_funs, $language_code){
        $temps=MatchFun::where([['match_id','=',$match_id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $match_fun=$temps->first();
        else
            $match_fun=new MatchFun;
        $match_fun->match_id=$match_id;
        if (isset($match_funs->facts) && !empty($match_funs->facts)){
            $facts=Array();
            $i=0;
            foreach ($match_funs->facts as $fact){
                $facts[$i]=$fact->statement;
                $i++;
            }
            $match_fun->funs=$facts;
        }

        $match_fun->language_code=$language_code;
        $match_fun->save();
    }


    public function saveLineup($match_id,$lineups,$lange_code){
        $temps=Lineup::where([['match_id','=',$match_id],['language_code','=',$lange_code]])->get();
        if ($temps->first())
            $lineup=$temps->first();
        else
            $lineup=new Lineup;
        $lineup->match_id=$match_id;
        $i=0;
        foreach ($lineups as $lineup_data){
            $temp['team']=$lineup_data->team;
            $temp['formation']=$lineup_data->formation;
            $temp['manager']['id']=$lineup_data->manager->id;
            $temp['manager']['name']=$lineup_data->manager->name;
            $temp['manager']['nationality']=$lineup_data->manager->nationality;
            $temp['manager']['country_code']=$lineup_data->manager->country_code;

            $temp['jersey']['type']=$lineup_data->jersey->type;
            $temp['jersey']['base']=$lineup_data->jersey->base;
            $temp['jersey']['sleeve']=$lineup_data->jersey->sleeve;
            $temp['jersey']['number']=$lineup_data->jersey->number;
            $temp['jersey']['squares']=$lineup_data->jersey->squares;
            $temp['jersey']['stripes']=$lineup_data->jersey->stripes;
            if (isset($lineup_data->jersey->stripes_color))
                $temp['jersey']['stripes_color']=$lineup_data->jersey->stripes_color;
            $temp['jersey']['horizontal_stripes']=$lineup_data->jersey->horizontal_stripes;
            $temp['jersey']['split']=$lineup_data->jersey->split;
            $temp['jersey']['shirt_type']=$lineup_data->jersey->shirt_type;
            $temp['jersey']['sleeve_detail']=$lineup_data->jersey->sleeve_detail;

            for ($j=0;$j<count($lineup_data->starting_lineup);$j++){
                $temp['starting_lineup'][$j]['id']=$lineup_data->starting_lineup[$j]->id;
                $temp['starting_lineup'][$j]['name']=$lineup_data->starting_lineup[$j]->name;
                $temp['starting_lineup'][$j]['type']=$lineup_data->starting_lineup[$j]->type;
                $temp['starting_lineup'][$j]['jersey_number']=$lineup_data->starting_lineup[$j]->jersey_number;
                $temp['starting_lineup'][$j]['position']=$lineup_data->starting_lineup[$j]->position;
                $temp['starting_lineup'][$j]['order']=$lineup_data->starting_lineup[$j]->order;
            }

            for ($j=0;$j<count($lineup_data->substitutes);$j++){
                $temp['substitues'][$j]['id']=$lineup_data->substitutes[$j]->id;
                $temp['substitues'][$j]['name']=$lineup_data->substitutes[$j]->name;
                $temp['substitues'][$j]['type']=$lineup_data->substitutes[$j]->type;
                $temp['substitues'][$j]['jersey_number']=$lineup_data->substitutes[$j]->jersey_number;
            }

            if ($i==0)
                $lineup->competitor1=$temp;
            else
                $lineup->competitor2=$temp;
            $i++;
        }
        $lineup->language_code=$lange_code;
        $lineup->save();
    }

    public function saveReferee($referee_data,$language_code){
        $temps=Referee::where([['referee_id','=',$referee_data->id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $referee=$temps->first();
        else
            $referee=new Referee;
        $referee->referee_id=$referee_data->id;
        $referee->name=$referee_data->name;
        $referee->nationality=$referee_data->nationality;
        $referee->country_code=$referee_data->country_code;
        $referee->language_code=$language_code;
        $referee->save();
    }

    public function saveSportEventCondition($match_id, $referee_id, $venue_id, $weather_info,$language_code){
        $temps=SportEventCondition::where([['match_id','=',$match_id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $sport_event_condition=$temps->first();
        else
            $sport_event_condition=new SportEventCondition;
        $sport_event_condition->match_id=$match_id;
        $sport_event_condition->referee_id=$referee_id;
        $sport_event_condition->venue_id=$venue_id;
        $sport_event_condition->weather_pitch=$weather_info->pitch;
        $sport_event_condition->weather_conditions=$weather_info->weather_conditions;
        $sport_event_condition->language_code=$language_code;
        $sport_event_condition->save();
    }

    public function saveStaticstics($match_id,$statistics_data,$language_code){
        $temps=Statistics::where([['match_id','=',$match_id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $statistics=$temps->first();
        else
            $statistics=new Statistics;
        $statistics->match_id=$match_id;
        $statistics->language_code=$language_code;
        $i=0;
        foreach ($statistics_data->teams as $team){
            $competitor['team_id']=$team->id;
            $competitor['statistics']['throw_ins']=$team->statistics->throw_ins;
            $competitor['statistics']['free_kicks']=$team->statistics->free_kicks;
            $competitor['statistics']['corner_kicks']=$team->statistics->corner_kicks;
            $competitor['statistics']['shots_off_target']=$team->statistics->shots_off_target;
            $competitor['statistics']['goal_kicks']=$team->statistics->goal_kicks;
            $competitor['statistics']['fouls']=$team->statistics->fouls;
            $competitor['statistics']['shots_on_target']=$team->statistics->shots_on_target;
            $competitor['statistics']['offsides']=$team->statistics->offsides;
            $competitor['statistics']['shots_saved']=$team->statistics->shots_saved;
            $competitor['statistics']['yellow_cards']=$team->statistics->yellow_cards;
            if(isset($team->statistics->injuries))
                $competitor['statistics']['injuries']=$team->statistics->injuries;
            for ($j=0;$j<count($team->players);$j++){
                $competitor['players'][$j]['id']=$team->players[$j]->id;
                $competitor['players'][$j]['name']=$team->players[$j]->name;
                $competitor['players'][$j]['substituted_in']=$team->players[$j]->substituted_in;
                $competitor['players'][$j]['substituted_out']=$team->players[$j]->substituted_out;
                $competitor['players'][$j]['goals_scored']=$team->players[$j]->goals_scored;
                $competitor['players'][$j]['assists']=$team->players[$j]->assists;
                $competitor['players'][$j]['own_goals']=$team->players[$j]->own_goals;
                $competitor['players'][$j]['yellow_cards']=$team->players[$j]->yellow_cards;
                $competitor['players'][$j]['yellow_red_cards']=$team->players[$j]->yellow_red_cards;
                $competitor['players'][$j]['red_cards']=$team->players[$j]->red_cards;
            }

            if ($i==0){
                $statistics->competitor1=$competitor;
            }
            else
                $statistics->competitor2=$competitor;
            $i++;
        }

        $statistics->save();
    }

    public function saveMissingPlayers($tournament_id,$teams,$language_code){
        $temps=MissingPlayer::where([['tournament_id','=',$tournament_id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $missing_player=$temps->first();
        else
            $missing_player=new MissingPlayer;
        $missing_player->tournament_id=$tournament_id;
        for($i=0;$i<count($teams);$i++){
            $team_list[$i]['team_id']=$teams[$i]->id;
            for ($j=0;$j<count($teams[$i]->players);$j++){
                $team_list[$i]['players'][$j]['id']=$teams[$i]->players[$j]->id;
                $team_list[$i]['players'][$j]['name']=$teams[$i]->players[$j]->name;
                $team_list[$i]['players'][$j]['status']=$teams[$i]->players[$j]->status;
                $team_list[$i]['players'][$j]['reason']=$teams[$i]->players[$j]->reason;
            }
        }
        $missing_player->players=$team_list;
        $missing_player->language_code=$language_code;
        $missing_player->save();
    }


    public function saveTeamProfile($teamProfileData,$language_code){
        $team=$teamProfileData->team;
        $team_id=$teamProfileData->team->id;
        $venue_id=$teamProfileData->venue->id;
        $jerseys=$teamProfileData->jerseys;
        $manager=$teamProfileData->manager;
        $players=$teamProfileData->players;
        $seasons=$teamProfileData->statistics->seasons;

        $temps=TeamProfile::where([['team_id','=',$team_id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $team_profile=$temps->first();
        else
            $team_profile=new TeamProfile;
        $team_profile->team_id=$team_id;
        $team_profile->venue_id=$venue_id;
        $team_profile->language_code=$language_code;
        for($i=0;$i<count($jerseys);$i++){
            $temp_jersey[$i]['type']=$jerseys[$i]->type;
            $temp_jersey[$i]['base']=$jerseys[$i]->base;
            $temp_jersey[$i]['sleeve']=$jerseys[$i]->sleeve;
            $temp_jersey[$i]['number']=$jerseys[$i]->number;
            $temp_jersey[$i]['squares']=$jerseys[$i]->squares;
            $temp_jersey[$i]['stripes']=$jerseys[$i]->stripes;
            if (isset($jerseys[$i]->stripes_color))
                $temp_jersey[$i]['stripes_color']=$jerseys[$i]->stripes_color;
            $temp_jersey[$i]['horizontal_stripes']=$jerseys[$i]->horizontal_stripes;
            $temp_jersey[$i]['split']=$jerseys[$i]->split;
            $temp_jersey[$i]['shirt_type']=$jerseys[$i]->shirt_type;
        }
        $team_profile->jerseys=$temp_jersey;
        $manager_temp['id']=$manager->id;
        $manager_temp['name']=$manager->name;
        $manager_temp['nationality']=$manager->nationality;
        $manager_temp['country_code']=$manager->country_code;
        $team_profile->manager=$manager_temp;

        for($i=0;$i<count($players);$i++){
            $temp_players[$i]['id']=$players[$i]->id;
            $temp_players[$i]['name']=$players[$i]->name;
            $temp_players[$i]['type']=$players[$i]->type;
            if (isset($players[$i]->date_of_birth))
                $temp_players[$i]['date_of_birth']=$players[$i]->date_of_birth;
            $temp_players[$i]['nationality']=$players[$i]->nationality;
            $temp_players[$i]['country_code']=$players[$i]->country_code;
            if (isset($players[$i]->height))
                $temp_players[$i]['height']=$players[$i]->height;
            if (isset($players[$i]->weight))
                $temp_players[$i]['weight']=$players[$i]->weight;
            if (isset($players[$i]->jersey_number))
                $temp_players[$i]['jersey_number']=$players[$i]->jersey_number;
            if (isset($players[$i]->preferred_foot))
                $temp_players[$i]['preferred_foot']=$players[$i]->preferred_foot;
            $temp_players[$i]['gender']=$players[$i]->gender;
        }
        $team_profile->players=$temp_players;

        for ($i=0;$i<count($seasons);$i++){
            $temp_statistics[$i]['season']['id']=$seasons[$i]->id;
            $temp_statistics[$i]['season']['name']=$seasons[$i]->name;
            $temp_statistics[$i]['season']['statistics']['matches_played']=$seasons[$i]->statistics->matches_played;
            $temp_statistics[$i]['season']['statistics']['matches_won']=$seasons[$i]->statistics->matches_won;
            $temp_statistics[$i]['season']['statistics']['matches_drawn']=$seasons[$i]->statistics->matches_drawn;
            $temp_statistics[$i]['season']['statistics']['matches_lost']=$seasons[$i]->statistics->matches_lost;
            $temp_statistics[$i]['season']['statistics']['goals_scored']=$seasons[$i]->statistics->goals_scored;
            $temp_statistics[$i]['season']['statistics']['goals_conceded']=$seasons[$i]->statistics->goals_conceded;
            $temp_statistics[$i]['season']['statistics']['group_position']=$seasons[$i]->statistics->group_position;

            $temp_statistics[$i]['tournament']['id']=$seasons[$i]->tournament->id;
            $temp_statistics[$i]['tournament']['name']=$seasons[$i]->tournament->name;

            $temp_statistics[$i]['form']['total']=$seasons[$i]->form->total;
            $temp_statistics[$i]['form']['home']=$seasons[$i]->form->home;
            $temp_statistics[$i]['form']['away']=$seasons[$i]->form->away;
        }

        $team_profile->statistics=$temp_statistics;
        $team_profile->save();
    }

    public function saveTeamResult($data,$language_code){
        $team_id=$data->team->id;
        $temps=TeamResult::where([['team_id','=',$team_id],['language_code','=',$language_code]])->get();
        if($temps->first())
            $team_result=$temps->first();
        else
            $team_result=new TeamResult;
        $team_result->team_id=$team_id;
        $team_result->language_code=$language_code;
        $results=$data->results;
        for ($i=0;$i<count($results);$i++){
            $temp_result[$i]['sport_event']['match_id']=$results[$i]->sport_event->id;
            $temp_result[$i]['sport_event']['scheduled']=$results[$i]->sport_event->scheduled;
        }
        $team_result->results=$temp_result;
        $team_result->save();
    }


    public function saveTeamSchedule($data,$language_code){
        $team_id=$data->team->id;
        $temps=TeamSchedule::where([['team_id','=',$team_id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $team_schedule=$temps->first();
        else
            $team_schedule=new TeamSchedule;
        $team_schedule->team_id=$team_id;
        $team_schedule->language_code=$language_code;

        $schedule=$data->schedule;
        for ($i=0;$i<count($schedule);$i++){
            $temp_schedule[$i]['match_id']=$schedule[$i]->id;
            $temp_schedule[$i]['scheduled']=$schedule[$i]->scheduled;
            $temp_schedule[$i]['season_id']=$schedule[$i]->season->id;
            $temp_schedule[$i]['venue_id']=$schedule[$i]->venue->id;
        }
        $team_schedule->schedule=$temp_schedule;
        $team_schedule->save();
    }


    public function saveTeamStatistics($data,$language_code)
    {

        $team_id = $data->team->id;
        $tournament_id = $data->tournament->id;
        $temps = TeamStatistics::where([['team_id', '=', $team_id], ['tournament_id', '=', $tournament_id], ['language_code', '=', $tournament_id]])->get();
        if ($temps->first())
            $teamStatistics = $temps->first();
        else
            $teamStatistics = new TeamStatistics;
        $teamStatistics->team_id = $team_id;
        $teamStatistics->tournament_id = $tournament_id;
        if (isset($data->team_season_coverage)) {
            $teamStatistics->team_season_coverage = $data->team_season_coverage;
        }

        if (isset($data->team_statistics)) {
            $teamStatistics->team_statistics = $data->team_statistics;
        }

        if (isset($data->player_statistics)) {
            $teamStatistics->player_statistics = $data->player_statistics;
        }
        if (isset($data->goaltime_statistics)) {
            $teamStatistics->goaltime_statistics = $data->goaltime_statistics;
        }
        $teamStatistics->language_code = $language_code;
        $teamStatistics->save();
    }

    public function TeamVsTeam($data, $language_code){
        $teams=$data->teams;
        $team_id1=$teams[0]->id;
        $team_id2=$teams[0]->id;
        $temps=TeamVsTeam::where([['team_id1','=',$team_id1],['team_id2','=',$team_id2],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $team_vs_team=$temps->first();
        else
            $team_vs_team= new TeamVsTeam;
        $team_vs_team->team_id1=$team_id1;
        $team_vs_team->team_id2=$team_id2;
        $team_vs_team->language_code=$language_code;

        if (isset($data->last_meetings->results)){
            $last_meetings=$data->last_meetings->results;
            for ($i=0;$i<count($last_meetings);$i++){
                $temp_last_meeting[$i]['match_id']=$last_meetings[$i]->sport_event->id;
                $temp_last_meeting[$i]['scheduled']=$last_meetings[$i]->sport_event->scheduled;
                $temp_last_meeting[$i]['tournament_id']=$last_meetings[$i]->sport_event->tournament->id;
                $temp_last_meeting[$i]['season_id']=$last_meetings[$i]->sport_event->season->id;
                if (isset($last_meetings[$i]->sport_event->venue))
                    $temp_last_meeting[$i]['venue_id']=$last_meetings[$i]->sport_event->venue->id;
                $temp_last_meeting[$i]['tournament']=$last_meetings[$i]->sport_event->tournament;
                $temp_last_meeting[$i]['sport_event_status']=$last_meetings[$i]->sport_event_status;
                $this->saveSportEventResult($last_meetings[$i]->sport_event->id,$last_meetings[$i]->sport_event_status);
            }
        }
        $team_vs_team->last_meetings=$last_meetings;
        $team_vs_team->save();
    }



    public function saveTournamentInfo($data, $language_code){
        $tournament_id=$data->tournament->id;

        $temps=TournamentInfo::where([['tournament_id','=',$tournament_id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $tournament_info=$temps->first();
        else
            $tournament_info=new TournamentInfo;
        if (isset($data->round))
            $tournament_info->round=$data->round;
        if (isset($data->season_coverage_info))
            $tournament_info->season_coverage_info=$data->season_coverage_info;
        if (isset($data->coverage_info))
            $tournament_info->coverage_info=$data->coverage_info;
        if (isset($data->groups))
            $tournament_info->groups=$data->groups;

        $tournament_info->language_code=$language_code;
        $tournament_info->save();
    }


    public function saveTournamentLeader($data,$language_code){
        $tournament_id=$data->tournament->id;
        $temps=TournamentLeader::where([['tournament_id','=',$tournament_id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $tournament_standing=$temps->first();
        else
            $tournament_standing=new TournamentLeader;
        $tournament_standing->tournament_id=$tournament_id;
        if (isset($data->season_coverage_info))
            $tournament_standing->season_coverage_info=$data->season_coverage_info;
        if (isset($data->top_points))
            $tournament_standing->top_points=$data->top_points;
        if (isset($data->top_goals))
            $tournament_standing->top_goals=$data->top_goals;
        if (isset($data->top_assists))
            $tournament_standing->top_assists=$data->top_assists;
        if (isset($data->top_cards))
            $tournament_standing->top_cards=$data->top_cards;
        if (isset($data->top_own_goals))
            $tournament_standing->top_own_goals=$data->top_own_goals;

        $tournament_standing->language_code=$language_code;
        $tournament_standing->save();
    }


    public function saveTournamentStanding($data, $language_code){
        $tournament_id=$data->tournament->id;
        $temps=TournamentStanding::where([['tournament_id','=',$tournament_id],['language_code','=',$language_code]])->get();
        if ($temps->first())
            $tournament_standing=$temps->first();
        else
            $tournament_standing=new TournamentStanding;
        $tournament_standing->tournament_id=$tournament_id;
        if (isset($data->season))
            $tournament_standing->season=$data->season;
        if (isset($data->standings))
            $tournament_standing->standings=$data->standings;

        if (isset($data->notes))
            $tournament_standing->notes=$data->notes;

        $tournament_standing->language_code=$language_code;
        $tournament_standing->save();

    }


    public function saveTournamentSchedule($data,$language_code){
        $tournament_id=$data->tournament->id;
        $temps=TournamentSchedule::where([['tournament_id','=',$tournament_id],['language_code','=',$language_code]])->get();
        if($temps->first())
            $tournament_schedule=$temps->first();
        else
            $tournament_schedule=new TournamentSchedule;
        $tournament_schedule->tournament_id=$tournament_id;
        if (isset($data->sport_events))
            $tournament_schedule->sport_events=$data->sport_events;
        $tournament_schedule->language_code=$language_code;
        $tournament_schedule->save();
    }


    public function saveTournamentResult($data,$language_code){
        $tournament_id=$data->tournament->id;
        $temps=TournamentResult::where([['tournament_id','=',$tournament_id],['language_code','=',$language_code]])->get();
        if($temps->first())
            $tournament_result=$temps->first();
        else
            $tournament_result=new TournamentResult;
        $tournament_result->tournament_id=$tournament_id;
        if (isset($data->results))
            $tournament_result->results=$data->results;
        $tournament_result->language_code=$language_code;
        $tournament_result->save();
    }
















// Odds Part ------------

    public function getOddResponse($url1,$key=null){
        if (is_null($key))
            $url=$url1."?api_key=".$this->odd_api_row_key;
        else
            $url=$url1;
        echo($url);
//        exit();
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        $jsonData = curl_exec($curlSession);
        $results = json_decode($jsonData);
        curl_close($curlSession);
        return $results;
    }




    public function ConstructBookMark($country_name, $entry_type,$stake_type,$bookmaker_id,$odds_type_id,$odds_field_id, $referrer_id){
        $url="https://dt.sportradar.com/?label.0=environment:desktop&label.1=country:".$country_name
            ."&label.2=entry:".$entry_type."&label.3=stake:".$stake_type."&bookmaker=".$bookmaker_id."&oddstypeid=".$odds_type_id
            ."&oddsfieldid=".$odds_field_id."&ref=".$referrer_id;
        $json_data=$this->getOddResponse($url,'1');
        echo "<pre>";
        print_r($json_data);

    }


    public function BookMarkLink($package,$access_level,$language_code,$odds_format){
        $url="https://api.sportradar.us/oddscomparison-".
            $package.$access_level."1/".$language_code."/".$odds_format."/bookmakers/link_patterns.json";
        $json_data=$this->getOddResponse($url);
        echo "<pre>";
        print_r($json_data);
    }


    public function getBooks($package,$access_level,$language_code,$odds_format){
        $url="https://api.sportradar.us/oddscomparison-".$package.$access_level."1/".$language_code."/$odds_format/books.json";
        $json_data=$this->getOddResponse($url);
        echo "<pre>";
        print_r($json_data);



    }





}















