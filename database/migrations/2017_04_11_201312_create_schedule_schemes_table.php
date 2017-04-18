<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_schemes', function (Blueprint $table) {
            $table->increments('ss_id');
            $table->integer('employee_id')->unsigned()->unique();
            $table->date('start_date');
            $table->text('schedule');
            $table->tinyInteger('fill_weeks')->unsigned();

            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_schemes');
    }
}
