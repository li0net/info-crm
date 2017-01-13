<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSessionTimeFieldsPart2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('employee_settings')) {
            Schema::table('employee_settings', function ($table) {
                $table->string('session_start', 10)->nullable();
                $table->string('session_end', 10)->nullable();
                $table->string('add_interval', 10)->nullable();
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
        if (Schema::hasTable('employee_settings')) {
            Schema::table('employee_settings', function ($table) {
                $table->dropColumn(['session_start', 'session_start', 'add_interval']);
            });
        }
    }
}
