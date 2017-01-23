<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partners', function (Blueprint $table) {
			$table->increments('partner_id');
			$table->enum('type', ['company', 'person', 'selfemployed']);
			$table->string('title', 110);
			$table->string('inn', 15);
			$table->string('kpp', 9);
			$table->string('contacts', 110);
			$table->string('phone', 25);
			$table->string('email', 70);
			$table->string('address', 210);
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
		Schema::dropIfExists('partners');
	}
}
