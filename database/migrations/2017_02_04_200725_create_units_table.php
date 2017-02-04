<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('units', function (Blueprint $table) {
			$table->increments('unit_id');
			$table->string('title', 110);
			$table->string('short_title', 110);
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
		Schema::dropIfExists('units');
	}
}
