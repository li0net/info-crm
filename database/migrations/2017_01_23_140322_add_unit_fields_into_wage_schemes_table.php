<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnitFieldsIntoWageSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('wage_schemes')) {
            Schema::table('wage_schemes', function ($table) {
                 $table->enum('products_unit', ['rub', 'pct']);
                 $table->enum('service_unit', ['rub', 'pct']);
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
        if (Schema::hasTable('wage_schemes')) {
            Schema::table('wage_schemes', function ($table) {
                $table->dropColumn(['products_unit', 'service_unit']);
            });
        }
    }
}
