<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('organization_id');
            $table->integer('super_organization_id')->unsigned();
            $table->string('name', 80)->index();
            $table->string('email', 70)->unique();
            $table->string('primary_phone', 14)->nullable();
            $table->string('secondary_phone', 14)->nullable();
            $table->string('shortinfo')->nullable();
            $table->string('country', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('timezone', 24)->default('Europe/Moscow');
            $table->mediumText('info')->nullable();
            $table->string('address')->nullable();
            $table->integer('post_index')->nullable();
            $table->string('coordinates', 30)->nullable();
            $table->string('website', 45)->nullable();
            $table->string('work_hours')->nullable();
            $table->timestamps();

            $table->foreign('super_organization_id')->references('super_organization_id')->on('super_organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oragnizations');
    }
}
