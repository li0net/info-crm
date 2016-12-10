<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('name', 110);
            $table->string('email', 70)->unique();
            $table->char('password', 60);
            $table->integer('organization_id')->unsigned();
            $table->string('phone', 12)->unique();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            //->onDelete('cascade');
            //->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
