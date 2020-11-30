<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('idActivity');

            $table->string('activityName');
            $table->unsignedBigInteger('idSubarea');
            $table->unsignedSmallInteger('idPriority');
            $table->string('activityDescription');
            $table->smallInteger('days');
            $table->boolean('active')->default(TRUE);
            $table->timestamps();
            $table->foreign('idSubarea')->references('idSubarea')->on('subareas')->onDelete('cascade');
            $table->foreign('idPriority')->references('idPriority')->on('priorities')->onDelete('cascade');
        });                                                              
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
