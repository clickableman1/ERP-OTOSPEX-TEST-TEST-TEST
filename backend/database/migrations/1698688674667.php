<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration1698688674667 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                Schema::table('services', function (Blueprint $table) {
                    $table->string('name')->nullable();

                });

                Schema::table('services', function (Blueprint $table) {
                    $table->string('description')->nullable();

                });

                Schema::table('services', function (Blueprint $table) {
                    $table->decimal('price')->nullable();

                });

                Schema::table('service_orders', function (Blueprint $table) {
                    $table->string('service_id')->nullable();

                });

                Schema::table('service_orders', function (Blueprint $table) {
                    $table->string('user_id')->nullable();

                });

                Schema::table('service_orders', function (Blueprint $table) {
                    $table->string('status')->nullable();

                });

                Schema::table('service_orders', function (Blueprint $table) {
                    $table->timestamp('appointment_date')->nullable();

                });

                Schema::table('service_orders', function (Blueprint $table) {
                    $table->timestamp('order_date')->nullable();

                });

                Schema::table('vehicle_part_services', function (Blueprint $table) {
                    $table->string('service_id')->nullable();

                });

                Schema::table('vehicle_part_services', function (Blueprint $table) {
                    $table->string('part_id')->nullable();

                });

                Schema::table('notifications', function (Blueprint $table) {
                    $table->string('user_id')->nullable();

                });

                Schema::table('notifications', function (Blueprint $table) {
                    $table->string('content')->nullable();

                });

                Schema::table('notifications', function (Blueprint $table) {
                    $table->string('status')->nullable();

                });

                Schema::table('reputation_history', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable();

                    $table->foreign('user_id')->references('id')->on('users');

                });

                Schema::table('reputation_history', function (Blueprint $table) {
                    $table->string('action')->nullable();

                });

                Schema::table('reputation_history', function (Blueprint $table) {
                    $table->string('reputation_change')->nullable();

                });

                Schema::table('inventory_history', function (Blueprint $table) {
                    $table->string('part_id')->nullable();

                });

                Schema::table('inventory_history', function (Blueprint $table) {
                    $table->string('transaction_type')->nullable();

                });

                Schema::table('inventory_history', function (Blueprint $table) {
                    $table->string('transaction_date')->nullable();

                });

                Schema::table('inventory_history', function (Blueprint $table) {
                    $table->string('quantity_change')->nullable();

                });

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {

                Schema::table('inventory_history', function(Blueprint $table) {
                    $table->dropColumn('quantity_change');
                });

                Schema::table('inventory_history', function(Blueprint $table) {
                    $table->dropColumn('transaction_date');
                });

                Schema::table('inventory_history', function(Blueprint $table) {
                    $table->dropColumn('transaction_type');
                });

                Schema::table('inventory_history', function(Blueprint $table) {
                    $table->dropColumn('part_id');
                });

                Schema::table('reputation_history', function(Blueprint $table) {
                    $table->dropColumn('reputation_change');
                });

                Schema::table('reputation_history', function(Blueprint $table) {
                    $table->dropColumn('action');
                });

                Schema::table('reputation_history', function(Blueprint $table) {
                    $table->dropColumn('user_id');
                });

                Schema::table('notifications', function(Blueprint $table) {
                    $table->dropColumn('status');
                });

                Schema::table('notifications', function(Blueprint $table) {
                    $table->dropColumn('content');
                });

                Schema::table('notifications', function(Blueprint $table) {
                    $table->dropColumn('user_id');
                });

                Schema::table('vehicle_part_services', function(Blueprint $table) {
                    $table->dropColumn('part_id');
                });

                Schema::table('vehicle_part_services', function(Blueprint $table) {
                    $table->dropColumn('service_id');
                });

                Schema::table('service_orders', function(Blueprint $table) {
                    $table->dropColumn('order_date');
                });

                Schema::table('service_orders', function(Blueprint $table) {
                    $table->dropColumn('appointment_date');
                });

                Schema::table('service_orders', function(Blueprint $table) {
                    $table->dropColumn('status');
                });

                Schema::table('service_orders', function(Blueprint $table) {
                    $table->dropColumn('user_id');
                });

                Schema::table('service_orders', function(Blueprint $table) {
                    $table->dropColumn('service_id');
                });

                Schema::table('services', function(Blueprint $table) {
                    $table->dropColumn('price');
                });

                Schema::table('services', function(Blueprint $table) {
                    $table->dropColumn('description');
                });

                Schema::table('services', function(Blueprint $table) {
                    $table->dropColumn('name');
                });

    }
}
