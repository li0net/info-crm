<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoragetransactionTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('storage_transactions', function (Blueprint $table) {
			$table->increments('id');
			$table->dateTime('date');
			$table->enum('type', ['income', 'expenses', 'transfer', 'discharge']);
			$table->integer('client_id')->unsigned();
			$table->integer('employee_id')->unsigned();
			$table->integer('storage1_id')->unsigned();
			$table->integer('storage2_id')->unsigned();
			$table->integer('partner_id')->unsigned();
			$table->integer('account_id')->unsigned();
			$table->text('description');
			$table->boolean('is_paidfor');
			$table->text('product_items');
			$table->integer('organization_id')->unsigned();

			$table->timestamps();

			$table->foreign('organization_id')->references('organization_id')->on('organizations');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('storage_transactions');
	}
}
