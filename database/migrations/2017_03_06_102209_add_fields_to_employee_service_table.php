<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToEmployeeServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('employee_provides_service')) {
            Schema::table('employee_provides_service', function ($table) {
                $table->time('duration');
                $table->integer('routing_id')->unsigned();
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
        if (Schema::hasTable('employee_provides_service')) {
            Schema::table('employee_provides_service', function ($table) {
                $table->dropColumns(['routing_id', 'duration']);
            });
        }
    }
}
