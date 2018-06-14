<?php

namespace App\Console\Commands;

use App\Team;
use App\Services\News;
use App\News as AppNews;
use Carbon\Carbon;
use Illuminate\Console\Command;

class getNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets News and stores them in the database';

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
     * @param News $news
     * @param Team $team
     * @param AppNews $appNews
     * @return mixed
     */
    public function handle(News $news, Team $team, AppNews $appNews)
    {
        $allTeams = $team->all();
        $allTeams->each(function ($team) use($news, $appNews){
            $responseNews = collect($news->fetchEverything("{$team->name} mundial rusia 2018")['articles']);
            $responseNews->each(function ($new) use ($team, $appNews){
                    $created = $appNews->create([
                        'title' => $new['title'],
                        'description' => !empty($new['description']) ? $new['description'] : null,
                        'published_at' => Carbon::createFromTimestamp(strtotime($new['publishedAt']))->toDateTimeString(),
                        'added_on' => Carbon::now()->toDateTimeString(),
                        'source' => $new['url'],
                        'image' => $new['urlToImage'] ?? null,
                        'source_name' => $new['source']['name']
                    ]);

                $created->teams()->attach($team->id);
            });
        });
    }
}
