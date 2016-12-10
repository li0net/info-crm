<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->integer('organization_id')->unsigned();
            $table->integer('service_id')->unsigned()->nullable();
            $table->decimal('amount', 14, 4);
            $table->string('type', 60);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('organization_id')->references('organization_id')->on('organizations');
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
        Schema::dropIfExists('transactions');
    }
}
