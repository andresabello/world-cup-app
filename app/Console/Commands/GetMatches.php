<?php

namespace App\Console\Commands;

use App\Group;
use App\Match;
use App\Services\LiveScores;
use App\Team;
use Illuminate\Console\Command;

class GetMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gets matches';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param LiveScores $liveScores
     * @param Group $group
     * @param Team $team
     * @return mixed
     */
    public function handle(LiveScores $liveScores, Group $group, Team $team)
    {
        $groups = $group->get();
        $groups->each(function ($group) use($liveScores, $team){
            switch($group->name) {
                case 'Groupo A':
                    $groupNumber = 793;
                    break;
                case 'Grupo B':
                    $groupNumber = 794;
                    break;
                case 'Grupo C':
                    $groupNumber = 795;
                    break;
                case 'Grupo D':
                    $groupNumber = 796;
                    break;
                case 'Grupo E':
                    $groupNumber = 797;
                    break;
                case 'Grupo F':
                    $groupNumber = 798;
                    break;
                case 'Grupo G':
                    $groupNumber = 799;
                    break;
                case 'Grupo H':
                    $groupNumber = 800;
                    break;
                default :
                    $groupNumber = 793;
            }
            $matches = $liveScores->getPastMatches($groupNumber);
            if(isset($matches['match'])) {
                $matches = collect($matches['match']);
//                dd($matches);
                if ($matches->count()) {
                    $matches->each(function ($match) use($team){
                        $home = $match['home_name'];
                        $away = $match['away_name'];
                        $homeTeam = Team::translatedName($home);
                        $awayTeam = Team::translatedName($away);

                        if ($homeTeam instanceof Team && $awayTeam instanceof Team) {
                            $appMatch = Match::where('home_id', $homeTeam->id)->where('away_id', $awayTeam->id)->first();
//                        dd($appMatch, $homeTeam, $awayTeam, $home, $away);
                            $appMatch->score = $match['score'];

                            if ($match['status'] === 'FINISHED') {
                                $scoreArray = explode(' - ', $match['score']);
                                rsort($scoreArray);
                                if ($scoreArray[0] > $scoreArray[1]) {
                                    $appMatch->winner_id = $homeTeam->id;
                                }

                                if ($scoreArray[1] > $scoreArray[0]) {
                                    $appMatch->winner_id = $awayTeam->id;
                                }
                                $appMatch->save();
                            }

                        }else{
                            logger($home .' '.$away . 'not recognize' . json_encode([$homeTeam->get(), $awayTeam->get()]));
                        }
                    });
                }
            }
        });
    }
}
