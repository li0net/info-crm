<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lang', 2)->default('en')->after('organization_id');
            $table->string('city', 50)->nullable()->after('lang');
            $table->boolean('send_news_inf_emails')->default(1)->after('remember_token');
            $table->boolean('send_marketing_offer_emails')->default(1)->after('send_news_inf_emails');
            $table->boolean('send_system_inf_emails')->default(1)->after('send_marketing_offer_emails');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'send_system_inf_emails',
                'send_marketing_offer_emails',
                'send_news_inf_emails',
                'city',
                'lang'
            ]);
        });
    }
}
