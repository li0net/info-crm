<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoragesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('storages', function (Blueprint $table) {
			$table->increments('storage_id');
			$table->string('title', 110);
			$table->boolean('type')->nullable;
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
		Schema::dropIfExists('storages');
	}
}
