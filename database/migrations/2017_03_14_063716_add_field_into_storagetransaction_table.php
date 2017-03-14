<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldIntoStoragetransactionTable extends Migration
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
                $table->integer('appointment_id')->unsigned()->after('code');
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
                $table->dropColumn('appointment_id');
            });
        }
    }
}
