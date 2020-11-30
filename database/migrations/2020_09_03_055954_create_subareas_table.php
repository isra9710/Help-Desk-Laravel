<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subareas', function (Blueprint $table) {
            $table->bigIncrements('idSubarea');
            $table->string('subareaName');
            $table->unsignedBigInteger('idDepartment');
            $table->boolean('active')->default(TRUE);
            $table->timestamps();
            $table->string('subareaDescription');
            $table->foreign('idDepartment')->references('idDepartment')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subareas');
    }
}
