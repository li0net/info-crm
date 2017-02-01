<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_client', function (Blueprint $table) {
            $table->integer('client_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->foreign('client_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->foreign('category_id')->references('cc_id')->on('client_categories')->onDelete('cascade');
            $table->primary(['client_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_client');
    }
}
