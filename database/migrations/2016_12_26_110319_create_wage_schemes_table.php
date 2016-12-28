<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWageSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wage_schemes', function (Blueprint $table) {
            $table->increments('scheme_id');
            $table->string('scheme_name', 70);
            $table->integer('service_part')->unsigned();
            $table->char('service_unit', 1);
            $table->integer('products_part')->unsigned();
            $table->char('products_unit', 1);
            $table->integer('wage_rate')->unsigned();
            $table->boolean('client_discount');
            $table->boolean('stuff_discount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('wage_schemes');
    }
}
