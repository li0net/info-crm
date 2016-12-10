<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuperOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_organizations', function (Blueprint $table) {
            $table->increments('super_organization_id');
            $table->string('name', 120);
            $table->integer('trarif_id')->unsigned();       // TODO: foreign key
            $table->timestamps();
            $table->string('shortinfo')->nullable();
            $table->mediumText('info')->nullable();
            $table->string('website', 45)->nullable();
            $table->string('primary_phone', 14)->nullable();
            $table->string('secondary_phone', 14)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('super_organizations');
    }
}
