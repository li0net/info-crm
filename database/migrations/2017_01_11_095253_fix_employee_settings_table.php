<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixEmployeeSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('employee_settings')) {
			Schema::table('employee_settings', function ($table) {
				// $table->dateTime('session_start')->default('')->change();
				// $table->dateTime('session_end')->default('')->change();
				$table->string('avatar_image_name', 70)->nullable();
				$table->integer('revenue_pctg')->unsigned()->nullable()->change();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('employee_settings')) {
			Schema::table('employee_settings', function ($table) {
				// $table->dateTime('session_start')->default(null)->change();
				// $table->dateTime('session_end')->default(null)->change();
				$table->dropColumn('avatar_image_name');
				$table->integer('revenue_pctg')->unsigned()->nullable(false)->change();
			});
		}
	}
}
