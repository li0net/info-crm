<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashDesksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_desks', function (Blueprint $table) {
            $table->increments('cash_desk_id');
            $table->integer('organization_id')->unsigned();
            $table->string('title', 200);
            $table->enum('type', ['cash', 'noncache']);
            $table->decimal('balance', 14, 4);
            $table->text('comment');
            $table->integer('position');

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
        Schema::dropIfExists('cash_desks');
    }
}
