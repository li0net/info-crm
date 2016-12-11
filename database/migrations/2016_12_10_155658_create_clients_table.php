<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('client_id');
            $table->integer('organization_id')->unsigned();
            $table->string('name', 120);
            $table->string('phone', 25)->nullable();
            $table->string('email', 70)->nullable()->unique();
            $table->char('password', 60)->nullable();
            $table->boolean('gender')->nullable();
            $table->unsignedTinyInteger('discount')->default(0);
            $table->date('birthday')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('do_not_send_sms')->default(0);
            $table->boolean('birthday_sms')->default(0);
            $table->boolean('online_reservation_avaliable')->default(1);
            $table->timestamps();

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
        Schema::dropIfExists('clients');
    }
}
