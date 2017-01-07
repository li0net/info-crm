<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToAccessPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_permissions', function (Blueprint $table) {
            $table->integer('updated_by')->unsigned();
            $table->enum('action', ['view', 'create', 'edit', 'delete'])->after('object_id');
            $table->text('additional_settings')->nullable()->after('access_level');
            $table->text('description')->nullable();

            $table->foreign('updated_by')->references('user_id')->on('users');
            $table->unique(['user_id', 'object']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('access_permissions', function (Blueprint $table) {
            $table->dropForeign('access_permissions_updated_by_foreign');
            $table->dropColumn('updated_by');
            $table->dropColumn('action');
            $table->dropColumn('additional_settings');
            $table->dropColumn('description');
            $table->dropUnique('access_permissions_user_id_object_unique');
        });
    }
}
