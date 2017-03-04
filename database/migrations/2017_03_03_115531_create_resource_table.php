<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resources', function (Blueprint $table) {
			$table->increments('resource_id');
			$table->string('name', 110);
			$table->integer('amount')->unsigned();
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
		Schema::dropIfExists('resources');
	}
}
