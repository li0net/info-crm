<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSalaryDataFieldToCalculatedWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calculated_wages', function (Blueprint $table) {
            $table->text('salary_data')->nullable()->after('products_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calculated_wages', function (Blueprint $table) {
            $table->dropColumn('salary_data');
        });
    }
}
