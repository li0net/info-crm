<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeWageSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wage_schemes', function (Blueprint $table) {
            $table->dropColumn(['service_part', 'service_unit', 'products_part', 'products_unit', 'client_discount', 'stuff_discount']);
            $table->string('scheme_name', 120)->change();
            $table->decimal('wage_rate', 12, 2)->unsigned()->change();

            $table->integer('organization_id')->unsigned();
            $table->decimal('services_percent', 5, 2)->unsigned();
            $table->text('services_custom_settings')->nullable();
            $table->decimal('products_percent', 5, 2)->unsigned();
            $table->text('products_custom_settings')->nullable();
            $table->enum('wage_rate_period', ['hour', 'day', 'month'])->nullable();
            $table->boolean('is_client_discount_counted');
            $table->boolean('is_material_cost_counted');

            $table->foreign('organization_id')->references('organization_id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wage_schemes', function (Blueprint $table) {
            $table->dropForeign('wages_schemes_organization_id_foreign');

            $table->dropColumn([
                'organization_id',
                'services_percent',
                'services_custom_settings',
                'products_percent',
                'products_custom_settings',
                'wage_rate_period',
                'is_client_discount_counted',
                'is_material_cost_counted'
            ]);

            $table->integer('service_part')->unsigned();
            $table->char('service_unit', 1);
            $table->integer('products_part')->unsigned();
            $table->char('products_unit', 1);
            $table->boolean('client_discount');
            $table->boolean('stuff_discount');

            $table->string('scheme_name', 70)->change();
            $table->integer('wage_rate')->unsigned()->change();
        });
    }
}
