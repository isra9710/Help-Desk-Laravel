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
            $table->unsignedBigInteger('employeeNumber')->nullable();
            $table->unsignedBigInteger('idTechnician')->nullable();
            $table->unsignedSmallInteger('idStatus')->nullable();
            $table->unsignedBigInteger('idActivity')->nullable();
            $table->date('startDate');
            $table->date('limitDate');
            $table->date('closeDate')->nullable();
            $table->string('ticketDescription')->nullable();
            $table->boolean('doubt')->nullable();
            $table->timestamps();
            $table->foreign('idStatus')->references('idStatus')->on('status')->onDelete('set null');
            $table->foreign('employeeNumber')->references('username')->on('users')->onDelete('set null');
            $table->foreign('idTechnician')->references('idUser')->on('users')->onDelete('set null');
            $table->foreign('idActivity')->references('idActivity')->on('activities')->onDelete('set null');
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
