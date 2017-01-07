<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUniqueConstraintInAccessPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_permissions', function (Blueprint $table) {
            $table->dropForeign('access_permissions_updated_by_foreign');
            $table->dropForeign('access_permissions_user_id_foreign');
            $table->dropUnique('access_permissions_user_id_object_unique');

            $table->unique(['user_id', 'object', 'action']);

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('updated_by')->references('user_id')->on('users');
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
            $table->dropForeign('access_permissions_user_id_foreign');
            $table->dropUnique('access_permissions_user_id_object_action_unique');

            $table->unique(['user_id', 'object']);

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('updated_by')->references('user_id')->on('users');
        });
    }
}
