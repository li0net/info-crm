<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStateFieldToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('is_confirmed');
            $table->enum('state', ['created', 'confirmed', 'finished', 'failed'])->default('created')->after('remind_by_phone_in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->boolean('is_confirmed')->default(0)->after('remind_by_phone_in');
        });
    }
}
