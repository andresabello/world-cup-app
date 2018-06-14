<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('minute');
            $table->integer('offset')->nullable();
            $table->boolean('penalty')->nullable();
            $table->boolean('own_goal')->nullable();

            $table->unsignedInteger('player_id');
            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->unsignedInteger('assist_id')->nullable();
            $table->foreign('assist_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');


            $table->unsignedInteger('match_id')->nullable();
            $table->foreign('match_id')
                ->references('id')
                ->on('matches')
                ->onDelete('cascade');

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
        Schema::dropIfExists('goals');
    }
}
