<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('idTicket');

            $table->unsignedTinyInteger('idType')->nullable();
            $table->unsignedSmallInteger('idStatus')->nullable();
            $table->unsignedBigInteger('idUser')->nullable();
            $table->date('startDate');
            $table->date('limitDate');
            $table->string('firstPhoto');
            $table->string('secondPhoto');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->foreign('idType')->references('idType')->on('types')->onDelete('set null');
            $table->foreign('idStatus')->references('idStatus')->on('status')->onDelete('set null');
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
        Schema::dropIfExists('tickets');
    }
}
