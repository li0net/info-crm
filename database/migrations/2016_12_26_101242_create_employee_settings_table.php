<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_settings', function (Blueprint $table) {
			$table->increments('settings_id');
			$table->integer('employee_id')->unsigned();
			$table->boolean('online_reg_notify')->nullable();
			$table->boolean('phone_reg_notify')->nullable();
			$table->boolean('online_reg_notify_del')->nullable();
			$table->boolean('client_data_notify')->nullable();
			$table->string('email_for_notify', 70)->nullable();
			$table->string('phone_for_notify', 25)->nullable();
			$table->boolean('reg_permitted')->nullable();
			$table->boolean('reg_permitted_nomaster')->nullable();
			$table->dateTime('session_start');
			$table->dateTime('session_end');
			$table->string('add_interval', 5)->nullable();
			$table->boolean('show_rating')->nullable();
			$table->boolean('is_rejected')->nullable();
			$table->boolean('is_in_occupancy')->nullable();
			$table->integer('revenue_pctg')->unsigned();
			$table->boolean('sync_with_google')->nullable();
			$table->boolean('sync_with_1c')->nullable();
			$table->integer('wage_scheme_id')->unsigned();
			$table->integer('schedule_id')->unsigned();
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
		Schema::dropIfExists('employee_settings');
	}
}
