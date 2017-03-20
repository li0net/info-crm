<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyFieldIntoOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('organizations')) {
            Schema::table('organizations', function ($table) {
                $table->enum('currency', ['rur', 'usd', 'eur'])->after('timezone')->default('eur');
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
        if (Schema::hasTable('organizations')) {
            Schema::table('organizations', function ($table) {
                $table->dropColumn('currency');
            });
        }
    }
}
