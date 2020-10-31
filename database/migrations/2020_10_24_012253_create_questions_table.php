<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->BigIncrements('idQuestion');
            $table->string('question');
            $table->boolean('active')->default(TRUE);
            $table->timestamps();
            $table->unsignedBigInteger('idPoll')->nullable();
            $table->foreign('idPoll')->references('idPoll')->on('polls')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
