<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOrganizationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('organizations')) {
			Schema::table('organizations', function ($table) {
				$table->dropColumn(['primary_phone', 'secondary_phone']);
				$table->string('coordinates', 36)->change();
				$table->string('phone_1', 25)->nullable();
            	$table->string('phone_2', 25)->nullable();
            	$table->string('phone_3', 25)->nullable();
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
		if (Schema::hasTable('organizations')) {
			Schema::table('organizations', function ($table) {
				$table->string('primary_phone', 25)->nullable();
            	$table->string('secondary_phone', 25)->nullable();
            	$table->string('coordinates', 30)->change();
            	$table->dropColumn(['phone_1', 'phone_2', 'phone_3']);
			});
		}
	}
}
