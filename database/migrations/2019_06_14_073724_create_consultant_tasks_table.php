<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultantTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultant_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('account_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('name');
            $table->text('description');
            $table->date('startDate');
            $table->date('endDate');
            $table->boolean('completed')->default(0);
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
        Schema::dropIfExists('consultant_tasks');
    }
}
