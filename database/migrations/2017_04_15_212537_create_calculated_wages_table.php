<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculatedWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculated_wages', function (Blueprint $table) {
            $table->increments('cw_id');
            $table->integer('employee_id')->unsigned();
            $table->integer('wage_scheme_id')->unsigned();
            $table->dateTime('date_calculated');
            $table->dateTime('wage_period_start');
            $table->dateTime('wage_period_end');
            $table->text('appointments_data')->nullable();
            $table->text('products_data')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->dateTime('date_payed')->nullable();
            $table->integer('payed_by')->unsigned()->nullable();

            $table->foreign('employee_id')->references('employee_id')->on('employees');
            $table->foreign('wage_scheme_id')->references('scheme_id')->on('wage_schemes');
            $table->foreign('payed_by')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculated_wages');
    }
}
