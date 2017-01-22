<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAccountIdName extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('accounts')) {
			Schema::table('accounts', function ($table) {
				$table->dropColumn('cash_desk_id');
			});

			Schema::table('accounts', function ($table) {
				$table->increments('account_id')->first();
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
		if (Schema::hasTable('accounts')) {
			Schema::table('accounts', function ($table) {
				$table->dropColumn('account_id');
			});

			Schema::table('accounts', function ($table) {
				$table->increments('cash_desk_id')->first();
			});
		}
	}
}
