<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('service_id');
            $table->integer('service_category_id', false, true);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('price_min', 12, 2);
            $table->decimal('price_max', 12, 2);
            $table->time('duration');
            $table->timestamps();

            $table->foreign('service_category_id')->references('service_category_id')->on('service_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
