<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TournamentList;

class SoccerController extends Controller{

    public $api_key='q6hk5teg3qs59a2w4ubnxvqt';
    public $access_level='xt';
    public $version=3;
    public $league_group='eu';
    public $language_code='ko';
    public $format='json';

    public function getResponse($url){
        $url=$url."?api_key=".$this->api_key;
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

                $temps=TournamentList::where([['tournament_id','=',$tournament_id],['league_group','=',$league_group],['language_code','=',$language_code]])->get();
                $TournamentList=null;
                if (!$temps->first())
                    $TournamentList=new TournamentList;
                else
                    $TournamentList=$temps->first();

                $TournamentList->tournament_id=$tournament_id;
                $TournamentList->name=$tournament->name;
                $TournamentList->sport_id=$tournament->sport->id;
                $TournamentList->sport_name=$tournament->sport->name;
                $TournamentList->category_id=$tournament->category->id;
                $TournamentList->category_name=$tournament->category->name;
                $TournamentList->season_id=$tournament->current_season->id;
                $TournamentList->season_name=$tournament->current_season->name;
                $TournamentList->season_start_date=$tournament->current_season->start_date;
                $TournamentList->season_end_date=$tournament->current_season->end_date;
                $TournamentList->season_year=$tournament->current_season->year;
                $TournamentList->season_scheduled=$tournament->season_coverage_info->scheduled;
                $TournamentList->season_played=$tournament->season_coverage_info->played;
                $TournamentList->season_max_coverage_level=$tournament->season_coverage_info->max_coverage_level;
                $TournamentList->season_max_covered=$tournament->season_coverage_info->max_covered;
                $TournamentList->season_min_coverage_level=$tournament->season_coverage_info->min_coverage_level;
                $TournamentList->league_group=$league_group;
                $TournamentList->language_code=$language_code;
                $TournamentList->save();
            }
        }

        echo "<pre>";
        print_r($json_data);


    }


    public function getDailySchedule($league_group, $language_code,$year,$month,$date){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/schedules/$year-$month-$date/schedule.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }


    public function getDailyResults($league_group, $language_code,$year,$month,$date){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/schedules/$year-$month-$date/results.json";
        $json_data=$this->getResponse($url);
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
        echo "<pre>";
        print_r($json_data);
    }

    public function getMatchLineup($match_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/matches/$match_id/lineups.json";
        $json_data=$this->getResponse($url);
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
        echo "<pre>";
        print_r($json_data);
    }

    public function getTeamResults($team_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/teams/$team_id/results.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTeamSchedule($team_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/teams/$team_id/schedule.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTeamStatistics($tournament_id,$team_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/teams/$team_id/statistics.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTeamVsTeam($team_id1,$team_id2,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/teams/$team_id1/versus/$team_id2/matches.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentInfo($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/info.json";
        $json_data=$this->getResponse($url);
        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentLeaders($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/leaders.json";
        $json_data=$this->getResponse($url);
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
        echo "<pre>";
        print_r($json_data);
    }

    public function getTournamentSchedule($tournament_id,$league_group, $language_code){
        $url="https://api.sportradar.us/soccer-$this->access_level$this->version/$league_group/$language_code/tournaments/$tournament_id/schedule.json";
        $json_data=$this->getResponse($url);
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
        echo "<pre>";
        print_r($json_data);
    }

}















