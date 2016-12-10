<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment', function (Blueprint $table) {
            $table->increments('appointment_id');
            $table->integer('employee_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->unsignedSmallInteger('remind_by_email_in')->nullable();
            $table->unsignedSmallInteger('remind_by_sms_in')->nullable();
            $table->unsignedSmallInteger('remind_by_phone_in')->nullable();
            $table->boolean('is_confirmed')->default(0);
            $table->timestamps();

            $table->foreign('employee_id')->references('employee_id')->on('employees');
            $table->foreign('client_id')->references('client_id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment');
    }
}
