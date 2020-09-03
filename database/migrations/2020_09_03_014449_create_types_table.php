<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->tinyIncrements('idType');

            $table->unsignedSmallInteger('idPriority')->nullable();
            $table->unsignedBigInteger('idDepartment')->nullable();
            $table->string('nameType')->unique();
            $table->timestamps();
            $table->foreign('idPriority')->references('idPriority')->on('priorities')->onDelete('set null');
            $table->foreign('idDepartment')->references('idDepartment')->on('departments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
}
