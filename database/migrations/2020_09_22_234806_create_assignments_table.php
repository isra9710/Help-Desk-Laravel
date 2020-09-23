<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('idAssignment');
            $table->unsignedBigInteger('idActivity')->nullable();
            $table->unsignedBigInteger('idUser')->nullable();
            $table->boolean('temporary');
            $table->timestamps();
            $table->foreign('idActivity')->references('idActivity')->on('activities')->onDelete('set null');
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
