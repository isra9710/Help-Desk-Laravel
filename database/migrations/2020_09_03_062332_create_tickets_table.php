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

            $table->unsignedBigInteger('idStaff')->nullable();
            $table->unsignedBigInteger('idTechnician')->nullable();
            $table->unsignedSmallInteger('idStatus')->nullable();
            $table->date('startDate');
            $table->date('limitDate');
            $table->string('firstPhoto');
            $table->string('secondPhoto');
            $table->boolean('doubt')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->foreign('idStatus')->references('idStatus')->on('status')->onDelete('set null');
            $table->foreign('idStaff')->references('idUser')->on('users')->onDelete('set null');
            $table->foreign('idTechnician')->references('idUser')->on('users')->onDelete('set null');
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
