<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('payments')) {
            Schema::table('payments', function ($table) {
                $table->dropColumn(['beneficiary_title']);
                $table->integer('beneficiary_id')->unsigned()->after('account_id');
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
        if (Schema::hasTable('payments')) {
            Schema::table('payments', function ($table) {
                $table->string('beneficiary_title', 110);
                $table->dropColumn(['beneficiary_id']);
            });
        }
    }
}
