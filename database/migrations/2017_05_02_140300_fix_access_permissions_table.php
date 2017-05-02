<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixAccessPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('access_permissions')) {

            Schema::table('access_permissions', function(Blueprint $table){
                $sql = 'ALTER TABLE `access_permissions` CHANGE COLUMN `action` `action` ENUM(\'view\', \'create\', \'edit\', \'delete\');';
                DB::connection()->getPdo()->exec($sql);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('access_permissions')) {
            Schema::table('access_permissions', function(Blueprint $table){
                $sql = 'ALTER TABLE `access_permissions` CHANGE COLUMN `action` `action` ENUM(\'view\', \'create\', \'update\', \'delete\');';
                DB::connection()->getPdo()->exec($sql);
            });
        }
    }
}
