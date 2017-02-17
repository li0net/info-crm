<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
 public function up()
	{
		if (Schema::hasTable('items')) {
			Schema::table('items', function ($table) {
				$table->dropColumn(['type']);
				$table->integer('itemtype_id')->unsigned()->after('title');
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
		if (Schema::hasTable('items')) {
			Schema::table('items', function ($table) {
				$table->enum('type', ['income', 'exp_oncost', 'sales_exp', 'staff_exp', 'admin_exp', 'taxes', 'others'])->after('title');
				$table->dropColumn(['itemtype_id']);
			});
		}
	}
}
