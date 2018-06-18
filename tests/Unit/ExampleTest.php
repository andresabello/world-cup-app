<?php

namespace Tests\Unit;

use App\Console\Commands\getMatches;
use App\Group;
use App\League;
use App\Player;
use App\Services\LiveScores;
use App\Services\News;
use App\Squad;
use App\Team;
use App\Tournament;
use App\Venue;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
//    use DatabaseTransactions;

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

        if (($handle = fopen($file, "rw")) !== false) {
            while (($data = fgetcsv($handle, 1000, "\n")) !== false) {
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
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

        $groupA = factory(Group::class)->create([
            'name' => 'Group A',
            'tournament_id' => $tournament->id
        ]);

        foreach ($fileData as $index => $match) {
            if ($index !== 0) {

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

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_can_get_match_data_from()
    {
        $scores = new LiveScores(new Client());
        dd(json_decode($scores->getLeagues()), true);
        dd($scores->getPastMatches());
    }


    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_can_get_matches()
    {
        $matches = new getMatches();
        dd($matches->handle(new LiveScores(new Client()), new Group()));
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_can_get_fixtures()
    {
        $matches = new LiveScores(new Client());;
        dd($matches->getFixtures(800));
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_can_crawl_squads()
    {


        $client = new \Goutte\Client();
        $links = [];
        $crawler = $client->request('GET', 'https://www.fifa.com/worldcup/teams/');
        $crawler->filter('.fi-teams-list > .col-sm-4 > .fi-team-card')->each(function ($node) use (&$links) {
            $link = 'https://www.fifa.com' . $node->attr('href');
            $text = trim($node->text());
            $links[$text] = $link;
        });
        $remaining = array_slice($links, 13);
        $remaining = array_slice($remaining, 15);

        $phantom = \JonnyW\PhantomJs\Client::getInstance();
        $phantom->getEngine()->setPath(base_path('bin/phantomjs'));
//        $phantom->isLazy();

        foreach ($remaining as $key => $link) {
            $team = Team::translatedName($key);
            $tournament = Tournament::where('name', 'Mundial Rusia 2018')->first();
            $team->tournaments()->attach($tournament->id);
            $request = $phantom->getMessageFactory()->createCaptureRequest($link, 'GET');
            $request->setDelay(5);
//            $request->setTimeout(5000);
            $response = $phantom->getMessageFactory()->createResponse();
            $phantom->send($request, $response);
            if ($response->getStatus() === 200) {
                $teamHtml = $response->getContent();
                $crawler = new Crawler();
                $crawler->addHtmlContent($teamHtml);
                $crawler->filter('.fi-team > .fi-team__members > .fi-p')->each(function ($node) use ($team) {
                    $imageUrl = null;
                    $playerHtml = $node->html();
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($playerHtml);
                    $crawler->filter('.fi-p__picture > .fi-clip-svg')->each(function ($node) use (&$imageUrl) {
                        preg_match('/(?<=href=\").+(?=\")/', $node->html(), $match);
                        if (isset($match[0])) {
                            $imageUrl = explode('" ', $match[0]);
                            $imageUrl = $imageUrl[0];
                        }
                    });


                    $crawler->filter('.fi-p__info > .fi-p--link')->each(function ($node) use (&$jerseyNumber) {
                        $jerseyNumber = trim($node->text());
                    });

                    $crawler->filter('.fi-p__info > .fi-p__info--role')->each(function ($node) use (&$position) {
                        $position = trim($node->text());
                    });


                    $crawler->filter('.fi-p__info > .fi-p__info--age')->each(function ($node) use (&$age) {
                        $age = trim(str_replace('Age:', '', $node->text()));
                    });


                    $crawler->filter('.fi-p__info > .fi-p__n')->each(function ($node) use (&$player) {
                        //TODO link for more information
                        preg_match('/(?<=title=\").+(?=\")/', $node->html(), $match);
                        if (isset($match[0])) {
                            $player = ucwords(strtolower($match[0]));
                        }
                    });

                    $playerModel = Player::create([
                        'name' => $player,
                        'age' => $age,
                        'position' => $position,
                    ]);

                    $squad = Squad::create([
                        'team_id' => $team->id,
                        'player_id' => $playerModel->id,
                        'position' => $position,
                        'number' => intval($jerseyNumber)
                    ]);

                    $finalImageUrl = storage_path("players/{$playerModel->id}.jpg");
                    \Intervention\Image\Facades\Image::make($imageUrl)->save($finalImageUrl);
                    $playerModel->photo = $finalImageUrl;
                    $playerModel->save();

                });
            }
        }
    }

    protected function teams()
    {
        return [
            'russia'
        ];
    }

}
