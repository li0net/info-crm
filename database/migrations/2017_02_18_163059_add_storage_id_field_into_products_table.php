<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStorageIdFieldIntoProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('products')) {
			Schema::table('products', function ($table) {
				$table->integer('storage_id')->unsigned()->after('barcode');
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
		if (Schema::hasTable('products')) {
			Schema::table('products', function ($table) {
				$table->dropColumn(['storage_id']);
			});
		}
	}
}
