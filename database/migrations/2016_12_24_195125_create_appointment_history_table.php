<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appointment_id')->unsigned();
            $table->integer('employee_id')->nullable()->unsigned();
            $table->integer('client_id')->nullable()->unsigned();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->unsignedSmallInteger('remind_by_email_in')->nullable();
            $table->unsignedSmallInteger('remind_by_sms_in')->nullable();
            $table->unsignedSmallInteger('remind_by_phone_in')->nullable();
            $table->boolean('is_confirmed')->nullable();
            $table->boolean('is_employee_important')->nullable();
            $table->timestamp('updated_at');
            $table->integer('updated_by')->unsigned();      // не ставлю FK, т.к. юзер может быть удален

            $table->foreign('appointment_id')->references('appointment_id')->on('appointments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_history');
    }
}
