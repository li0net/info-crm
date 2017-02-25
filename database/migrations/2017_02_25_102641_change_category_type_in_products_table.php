<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCategoryTypeInProductsTable extends Migration
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
				$table->dropColumn(['category']);
				$table->integer('category_id')->unsigned()->after('storage_id');
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
				$table->string('category', 110)->after('storage_id');
				$table->dropColumn(['category_id']);
			});
		}
	}
}
