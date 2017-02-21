<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixStoragetransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('storage_transactions')) {
            Schema::table('storage_transactions', function ($table) {
                $table->dropColumn('product_items');
                $table->text('transaction_items');
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
        if (Schema::hasTable('storage_transactions')) {
            Schema::table('storage_transactions', function ($table) {
                $table->text('product_items');
                $table->dropColumn('transaction_items');
            });
        }
    }
}
