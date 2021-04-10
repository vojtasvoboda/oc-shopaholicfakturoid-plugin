<?php namespace VojtaSvoboda\ShopaholicFakturoid\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('lovata_orders_shopaholic_order_fakturoid_invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id', 'invoice_order_id')->references('id')->on('lovata_orders_shopaholic_orders');
            $table->integer('fakturoid_id')->unsigned();
            $table->string('fakturoid_number', 20);
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by', 'invoice_backend_user_id')->references('id')->on('backend_users');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lovata_orders_shopaholic_order_fakturoid_invoices');
    }
}
