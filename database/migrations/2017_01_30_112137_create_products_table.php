<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('title', 110);
            $table->string('article', 110);
            $table->string('barcode', 110);
            $table->string('category', 110);
            $table->decimal('price', 10, 2);
            $table->enum('unit_for_sale', ['штуки', 'миллилитры']);
            $table->char('is_equal', 1);
            $table->enum('unit_for_disposal', ['штуки', 'миллилитры']);
            $table->integer('critical_balance')->unsigned();
            $table->integer('net_weight')->unsigned();
            $table->integer('gross_weight')->unsigned();
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
        Schema::dropIfExists('products');
    }
}
