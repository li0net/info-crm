<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSessionTimeFields extends Migration
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
                $table->dropColumn(['session_start', 'session_end', 'add_interval']);
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
                $table->dateTime('session_start');
                $table->dateTime('session_end');
                $table->string('add_interval', 5)->nullable();
            });
        }
    }
}
