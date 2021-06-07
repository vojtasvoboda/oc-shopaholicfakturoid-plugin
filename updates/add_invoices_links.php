<?php namespace VojtaSvoboda\ShopaholicFakturoid\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddInvoicesLinks extends Migration
{
    public function up()
    {
        Schema::table('lovata_orders_shopaholic_order_fakturoid_invoices', function (Blueprint $table) {
            $table->string('fakturoid_public_html_url', 300)->nullable()->after('fakturoid_number');
            $table->string('fakturoid_pdf_url', 300)->nullable()->after('fakturoid_public_html_url');
        });
    }

    public function down()
    {
        Schema::table('lovata_orders_shopaholic_order_fakturoid_invoices', function (Blueprint $table) {
            $table->dropColumn([
                'fakturoid_public_html_url', 'fakturoid_pdf_url',
            ]);
        });
    }
}
