<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idUser');
            $table->string('name');
            $table->string('fathersLastName');
            $table->string('mothersLastName');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('extension');
            $table->unsignedTinyInteger('idRole')->index();
            $table->unsignedBigInteger('idDepartment')->nullable();
            $table->boolean('status')->default(TRUE);
            $table->boolean('active')->default(TRUE);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken()->nullable();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->foreign('idRole')->references('idRole')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
