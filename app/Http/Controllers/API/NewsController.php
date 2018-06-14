<?php

namespace App\Http\Controllers\API;

use App\News;
use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param News $news
     * @param Team $teamApp
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, News $news, Team $teamApp)
    {
        $team = $request->query('team', null);
        $team = $teamApp->where('slug', str_slug($team))->first();
        if ($team) {
            $news = $news->with(['teams'])->whereHas('teams', function ($teams) use($team){
                $teams->where('id', $team->id);
            })->get();
        }else {
            $news = $news->with(['teams'])->get();
        }

        return response()->json(compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        $news = $news->with(['teams'])->get();
        return response()->json(compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
