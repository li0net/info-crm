<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAndChangeFieldsInOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            //$table->addColumn('string', 'category')->nullable()->after('secondary_phone');
            $table->string('category', 150)->nullable()->after('secondary_phone');
            $table->string('timezone', 30)->default('Europe/Moscow')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->string('timezone', 24)->default('Europe/Moscow')->change();
        });
    }
}
