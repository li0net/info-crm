<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('users')) {
			Schema::table('users', function ($table) {
				$table->renameColumn('user_id', 'id');
				$table->integer('organization_id')->unsigned()->nullable()->change();
				$table->string('phone', 25)->nullable()->change();
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
		if (Schema::hasTable('users')) {
			Schema::table('users', function ($table) {
				$table->renameColumn('id', 'user_id');
				$table->integer('organization_id')->unsigned()->nullable(false)->change();
				$table->string('phone', 25)->nullable(false)->change();
			});
		}
	}
}
