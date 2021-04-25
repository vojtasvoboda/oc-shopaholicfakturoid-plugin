<?php namespace VojtaSvoboda\ShopaholicFakturoid\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddPaymentFakturoidType extends Migration
{
    public function up()
    {
        Schema::table('lovata_orders_shopaholic_payment_methods', function (Blueprint $table) {
            $table->string('fakturoid_type', 10)->nullable()->after('code');
        });
    }

    public function down()
    {
        if (Schema::hasColumn('lovata_orders_shopaholic_payment_methods', 'fakturoid_type')) {
            Schema::table('lovata_orders_shopaholic_payment_methods', function (Blueprint $table) {
                $table->dropColumn('fakturoid_type');
            });
        }
    }
}
