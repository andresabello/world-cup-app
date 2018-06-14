<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeasonLeagueToTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->unsignedInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');

            $table->unsignedInteger('league_id')->nullable();
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropForeign(['season_id']);
            $table->dropForeign(['league_id']);
            $table->dropColumn('season_id');
            $table->dropColumn('league_id');
        });
    }
}
