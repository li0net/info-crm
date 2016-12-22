<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServiceIdFieldToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->integer('service_id')->unsigned()->nullable()->after('client_id');
            $table->integer('client_id')->unsigned()->nullable()->change();
            $table->string('note')->nullable()->after('end');
            $table->boolean('is_employee_important')->default(0)->after('is_confirmed');

            $table->foreign('service_id')->references('service_id')->on('services');
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
            $table->dropForeign('appointments_service_id_foreign');
            $table->dropColumn('service_id');
            $table->integer('client_id')->unsigned()->nullable(false)->change();
            $table->dropColumn('note');
            $table->dropColumn('is_employee_important');
        });
    }
}
