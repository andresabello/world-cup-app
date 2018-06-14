<?php

namespace Tests\Unit;

use App\Group;
use App\League;
use App\Services\News;
use App\Team;
use App\Tournament;
use App\Venue;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_can_parse_csv_world_cup()
    {
        $file = storage_path('app/fifa-world-cup-2018-et.csv');
        $row = 1;
        $fileData = [];

        if (($handle = fopen($file, "rw")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                $num = count($data);
                $row++;
                for ($c=0; $c < $num; $c++) {
                    $fileData[] = explode(',', $data[$c]);
                }
            }
            fclose($handle);
        }

        $league = factory(League::class)->create([
            'name' => 'Mundial',
            'prize' => 7000000,
            'teams' => 32
        ]);
        $tournament = factory(Tournament::class)->create([
            'name' => 'Mundial Rusia 2018',
            'prize' => 70000000,
            'league_id' => $league->id
        ]);
        $groupA = factory(Group::class)->create([
            'name' => 'A',
            'tournament_id' => $tournament->id
        ]);
        $rusia = factory(Team::class)->create([
            'name' => 'Rusia',
            'flag' => url('img' . 'Rusia.png'),
            'slug' => str_slug('Rusia'),
            'main_color' => '#11549d',
            'second_color' => '#ffffff',
            'third_color' => '#11549d',
            'group_id' => $groupA->id
        ]);

        factory(Venue::class)->create([
            'name' => 'Luzhniki Stadium',
            'city' => 'Moscu',
            'country' => 'Rusia',
            'capacity' => 81006
        ]);

        $groupA = factory(Group::class) ->create([
            'name' => 'Group A',
            'tournament_id' => $tournament->id
        ]);

        foreach($fileData as $index => $match){
            if($index !== 0) {

                $group = !empty($match[6]) ? Group::where('name', $match[6])->first() : null;
            }
        };

    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_can_get_news_by_team()
    {
        $newsService = new News();
        dd($newsService->fetchEverything('colombia mundial rusia 2018'));
    }


    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_can_get_news_from_futbolred()
    {
        $newsService = new News();
        dd($newsService->fetchFutbolred());
    }

}
