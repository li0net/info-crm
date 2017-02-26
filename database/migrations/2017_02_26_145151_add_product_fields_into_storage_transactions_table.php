<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductFieldsIntoStorageTransactionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('storage_transactions')) {
			Schema::table('storage_transactions', function ($table) {
				$table->integer('code')->unsigned()->after('type');
				$table->decimal('sum', 10, 2)->after('type');
				$table->integer('discount')->unsigned()->after('type');
				$table->integer('amount')->unsigned()->after('type');
				$table->decimal('price', 10, 2)->after('type');
				$table->integer('product_id')->unsigned()->after('type');
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
		if (Schema::hasTable('storage_transactions')) {
			Schema::table('storage_transactions', function ($table) {
				$table->dropColumns(['product_id', 'price', 'amount', 'discount', 'sum', 'code']);
			});
		}
	}
}
