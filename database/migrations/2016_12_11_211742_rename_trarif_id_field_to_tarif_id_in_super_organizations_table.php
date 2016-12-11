<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTrarifIdFieldToTarifIdInSuperOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('super_organizations', function (Blueprint $table) {
            $table->renameColumn('trarif_id', 'tariff_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('super_organizations', function (Blueprint $table) {
            $table->renameColumn('tariff_id', 'trarif_id');
        });
    }
}
