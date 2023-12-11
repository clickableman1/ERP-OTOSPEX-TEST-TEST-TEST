<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration1698688114797 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                Schema::table('invoices', function (Blueprint $table) {
                    $table->decimal('total_amount')->nullable();

                });

                Schema::table('order_details', function (Blueprint $table) {
                    $table->string('order_id')->nullable();

                });

                Schema::table('order_details', function (Blueprint $table) {
                    $table->string('part_id')->nullable();

                });

                Schema::table('order_details', function (Blueprint $table) {
                    $table->integer('quantity')->nullable();

                });

                Schema::table('order_details', function (Blueprint $table) {
                    $table->decimal('unit_price')->nullable();

                });

                Schema::table('order_details', function (Blueprint $table) {
                    $table->decimal('subtotal')->nullable();

                });

                Schema::table('purchase_orders', function (Blueprint $table) {
                    $table->string('order_id')->nullable();

                });

                Schema::table('purchase_orders', function (Blueprint $table) {
                    $table->string('supplier_id')->nullable();

                });

                Schema::table('purchase_orders', function (Blueprint $table) {
                    $table->string('invoice_id')->nullable();

                });

                Schema::table('sale_orders', function (Blueprint $table) {
                    $table->string('order_id')->nullable();

                });

                Schema::table('sale_orders', function (Blueprint $table) {
                    $table->string('invoice_id')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->string('name')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->string('description')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->string('barcode')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->string('category')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->decimal('price')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->decimal('weight')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->string('dimensions')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->integer('quantity_in_stock')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->integer('minimum_stock_level')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->string('manufacturer_id')->nullable();

                });

                Schema::table('parts', function (Blueprint $table) {
                    $table->string('supplier_id')->nullable();

                });

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('supplier_id');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('manufacturer_id');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('minimum_stock_level');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('quantity_in_stock');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('dimensions');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('weight');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('price');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('category');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('barcode');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('description');
                });

                Schema::table('parts', function(Blueprint $table) {
                    $table->dropColumn('name');
                });

                Schema::table('sale_orders', function(Blueprint $table) {
                    $table->dropColumn('invoice_id');
                });

                Schema::table('sale_orders', function(Blueprint $table) {
                    $table->dropColumn('order_id');
                });

                Schema::table('purchase_orders', function(Blueprint $table) {
                    $table->dropColumn('invoice_id');
                });

                Schema::table('purchase_orders', function(Blueprint $table) {
                    $table->dropColumn('supplier_id');
                });

                Schema::table('purchase_orders', function(Blueprint $table) {
                    $table->dropColumn('order_id');
                });

                Schema::table('order_details', function(Blueprint $table) {
                    $table->dropColumn('subtotal');
                });

                Schema::table('order_details', function(Blueprint $table) {
                    $table->dropColumn('unit_price');
                });

                Schema::table('order_details', function(Blueprint $table) {
                    $table->dropColumn('quantity');
                });

                Schema::table('order_details', function(Blueprint $table) {
                    $table->dropColumn('part_id');
                });

                Schema::table('order_details', function(Blueprint $table) {
                    $table->dropColumn('order_id');
                });

                Schema::table('invoices', function(Blueprint $table) {
                    $table->dropColumn('total_amount');
                });

                Schema::table('invoices', function (Blueprint $table) {
                    $table->string('total_amount')->nullable();

                });

    }
}
