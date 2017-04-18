<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_service_id_foreign');
            $table->dropColumn('service_id');

            $table->integer('product_id')->unsigned()->nullable()->after('employee_id');
            $table->integer('appointment_id')->unsigned()->nullable()->after('product_id');

            //$table->index('product_id');
            //$table->index('appointment_id');

            $table->foreign('product_id')->references('product_id')->on('products');
            $table->foreign('appointment_id')->references('appointment_id')->on('appointments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //$table->dropIndex('transactions_product_id_index');
            //$table->dropIndex('transactions_appointment_id_index');
            $table->dropForeign('transactions_product_id_foreign');
            $table->dropForeign('transactions_appointment_id_foreign');

            $table->dropColumns(['product_id', 'appointment_id']);

            $table->integer('service_id')->unsigned()->after('employee_id');
            $table->foreign('service_id')->references('service_id')->on('services');
        });
    }
}
