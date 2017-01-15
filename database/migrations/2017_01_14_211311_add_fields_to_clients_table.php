<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->nullable()->after('email');
            $table->enum('importance', ['bronze', 'silver', 'gold'])->nullable()->after('category_id');
            $table->decimal('total_bought', 14, 4)->default(0)->after('online_reservation_available');
            $table->decimal('total_paid', 14, 4)->default(0)->after('total_bought');

            $table->foreign('category_id')->references('cc_id')->on('client_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_category_id_foreign');
            $table->dropColumn(['category_id',   'importance', 'total_bought', 'total_paid']);
        });
    }
}
