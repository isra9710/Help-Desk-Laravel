<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substitutions', function (Blueprint $table) {
            $table->bigIncrements('idSubstitution');
            $table->unsignedBigInteger('idNot')->nullable();
            $table->unsignedBigInteger('idYes')->nullable();
            $table->timestamps();
            $table->foreign('idNot')->references('idUser')->on('users')->onDelete('set null');
            $table->foreign('idYes')->references('idUser')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('substitutions');
    }
}
