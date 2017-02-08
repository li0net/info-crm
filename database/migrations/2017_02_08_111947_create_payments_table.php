<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function (Blueprint $table) {
			$table->increments('payment_id');
			$table->dateTime('date');
			$table->integer('item_id')->unsigned();
			$table->integer('account_id')->unsigned();
			$table->integer('author_id')->unsigned();
			$table->enum('beneficiary_type', ['partner', 'client', 'employee']);
			$table->string('beneficiary_title', 110);
			$table->decimal('sum', 10, 2);
			$table->text('description');
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
		Schema::dropIfExists('payments');
	}
}
