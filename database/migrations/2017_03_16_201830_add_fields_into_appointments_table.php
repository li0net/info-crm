<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsIntoAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function ($table) {
                $table->decimal('service_sum', 10, 2)->after('note')->nullable();
                $table->decimal('service_discount', 10, 2)->after('note')->nullable();
                $table->decimal('service_price', 10, 2)->after('note')->nullable();
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
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function ($table) {
                $table->dropColumn('service_price', 'service_discount', 'service_sum');
            });
        }
    }
}
