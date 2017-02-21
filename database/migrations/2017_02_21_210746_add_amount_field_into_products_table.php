<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAmountFieldIntoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        if (Schema::hasTable('products')) {
            Schema::table('products', function ($table) {
                $table->integer('amount')->unsigned()->after('price');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('products')) {
            Schema::table('products', function ($table) {
                $table->dropColumn('amount');
            });
        }
    }
}
