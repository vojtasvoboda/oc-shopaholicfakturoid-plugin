<?php namespace VojtaSvoboda\ShopaholicFakturoid\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddUserFakturoidId extends Migration
{
    public function up()
    {
        Schema::table('lovata_buddies_users', function (Blueprint $table) {
            $table->integer('fakturoid_id')->unsigned()->nullable()->after('id');
        });
    }

    public function down()
    {
        if (Schema::hasColumn('lovata_buddies_users', 'fakturoid_id')) {
            Schema::table('lovata_buddies_users', function (Blueprint $table) {
                $table->dropColumn('fakturoid_id');
            });
        }
    }
}
