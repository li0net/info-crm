<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesAttachedServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
    {
        Schema::create('resources_attached_service', function (Blueprint $table) {
            $table->integer('resource_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->integer('amount')->unsigned();

            $table->foreign('resource_id')->references('resource_id')->on('resources')->onDelete('cascade');
            $table->foreign('service_id')->references('service_id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources_attached_service');
    }
}
