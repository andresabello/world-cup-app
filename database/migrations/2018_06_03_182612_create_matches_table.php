<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('number');
            $table->timestamp('play_at');
            $table->boolean('knockout');
            $table->unsignedInteger('home_id');
            $table->foreign('home_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedInteger('away_id');
            $table->foreign('away_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedInteger('winner_id')->nullable();
            $table->foreign('winner_id')->references('id')->on('teams')->onDelete('cascade');
            $table->string('score', 20)->default('0-0');
            $table->string('score_et', 20)->nullable();
            $table->string('score_pt', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
