<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('title');
            $table->integer('mobile');
            $table->string('vht');
            $table->string('ansvar');
            $table->string('company');
            $table->string('consultantCompany');
            $table->string('department');
            $table->uuid('managerUuid');
            $table->string('employeeType');
            $table->date('startDate');
            $table->date('endDate');
            $table->boolean('localAccount');
            $table->boolean('isEdu');
            $table->unsignedBigInteger('createdBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
