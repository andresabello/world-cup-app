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
        $groups->each(function ($group) use ($liveScores, $team) {
            switch ($group->name) {
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
            if (isset($matches['match'])) {
                $matches = collect($matches['match']);
//                dd($matches);
                if ($matches->count()) {
                    $matches->each(function ($match) use ($team) {
                        $home = $match['home_name'];
                        $away = $match['away_name'];

                        $homeTeam = Team::translatedName($home);
                        $awayTeam = Team::translatedName($away);

                        if ($homeTeam instanceof Team && $awayTeam instanceof Team && $homeTeam !== $awayTeam) {

                            $appMatch = Match::where(function ($query) use ($awayTeam, $homeTeam) {
                                $query->where('home_id', $homeTeam->id)
                                    ->where('away_id', $awayTeam->id);
                            })->orWhere(function($query) use($awayTeam, $homeTeam){
                                $query->where('home_id', $awayTeam->id)
                                    ->where('away_id', $homeTeam->id);
                            })->first();

                            if ($homeTeam->id !== $appMatch->home_id) {
                                $appMatch->home_id = $awayTeam->id;
                                $appMatch->away_id = $homeTeam->id;
                                $appMatch->save();
                            }
//                            dd($appMatch);
                            if ($appMatch->home_name === 'Espana' || $appMatch->away_team === 'Espana') {
                                dd($appMatch, $match);
                            }

                            if ($appMatch) {

                                $appMatch->score = $match['score'] ?? '0 - 0';

                                if ($match['status'] === 'FINISHED') {
                                    $scoreArray = explode(' - ', $match['score']);
//                                    dd($scoreArray);
//                                    rsort($scoreArray);

                                    if ($scoreArray[0] > $scoreArray[1]) {
                                        $appMatch->winner_id = $homeTeam->id;
                                    }

                                    if ($scoreArray[1] > $scoreArray[0]) {
                                        $appMatch->winner_id = $awayTeam->id;
                                    }
                                    $appMatch->finished = 1;
                                    $appMatch->save();
                                }
                            }
                        }
                        logger(json_encode([
                                'home_team' => $homeTeam->name ?? 'nada',
                                'away_team' => $awayTeam->name ?? 'nada',
                                'api_home' => $home,
                                'api_away' => $away,
                                'score' => $match
                            ]));
                    });
                }
            }
        });
    }
}
