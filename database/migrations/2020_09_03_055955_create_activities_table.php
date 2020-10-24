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
            $table->unsignedBigInteger('idSubarea')->nullable();
            $table->unsignedSmallInteger('idPriority')->nullable();
            $table->string('activityDescription')->nullable();
            $table->smallInteger('days')->nulllable();
            $table->boolean('active')->default('1');
            $table->timestamps();
            $table->foreign('idSubarea')->references('idSubarea')->on('subareas')->onDelete('set null');
            $table->foreign('idPriority')->references('idPriority')->on('priorities')->onDelete('set null');
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
