<?php

namespace App\Console\Commands;

use App\News as AppNews;
use App\Services\News;
use App\Team;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetFutbolredNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:news-futbolred';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets News from futbolred and stores them in the database';

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
     * @param \App\News $appNews
     * @param Team $team
     * @return mixed
     */
    public function handle(News $news, AppNews $appNews, Team $team)
    {
        $futbolred = $news->fetchFutbolred();
        $team = $team->where('name', 'Colombia')->first();
        $news = collect($futbolred['channel']['item']);
        $news->each(function ($new) use ($appNews, $team){
            $created = $appNews->create([
                'title' => $new['title'],
                'description' => !empty($new['description']) ? $new['description'] : null,
                'published_at' => Carbon::createFromFormat('D, j M Y H:i:s O', $new['pubDate'])->toDateTimeString(),
                'added_on' => Carbon::now()->toDateTimeString(),
                '   source' => $new['link'],
                'image' => isset($new['enclosure']) ? $new['enclosure']['@attributes']['url'] : null,
                'source_name' => 'Futbolred'
            ]);
            $created->teams()->attach($team->id);
        });

    }
}
