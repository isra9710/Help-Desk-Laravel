<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('idAnswer');

            $table->unsignedBigInteger('idPoll');
            $table->unsignedBigInteger('idQuestion');
            $table->string('answer');
            $table->timestamps();
            $table->foreign('idPoll')->references('idPoll')->on('polls')->onDelete('cascade');
            $table->foreign('idQuestion')->references('idQuestion')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
