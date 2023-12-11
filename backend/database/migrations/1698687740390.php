<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration1698687740390 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                Schema::table('settings', function (Blueprint $table) {
                    $table->string('user_id')->nullable();

                });

                Schema::table('settings', function (Blueprint $table) {
                    $table->string('language_id')->nullable();

                });

                Schema::table('settings', function (Blueprint $table) {
                    $table->string('currency')->nullable();

                });

                Schema::table('orders', function (Blueprint $table) {
                    $table->string('user_id')->nullable();

                });

                Schema::table('orders', function (Blueprint $table) {
                    $table->string('order_type')->nullable();

                });

                Schema::table('orders', function (Blueprint $table) {
                    $table->string('status')->nullable();

                });

                Schema::table('orders', function (Blueprint $table) {
                    $table->decimal('total_amount')->nullable();

                });

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {

                Schema::table('orders', function(Blueprint $table) {
                    $table->dropColumn('total_amount');
                });

                Schema::table('orders', function(Blueprint $table) {
                    $table->dropColumn('status');
                });

                Schema::table('orders', function(Blueprint $table) {
                    $table->dropColumn('order_type');
                });

                Schema::table('orders', function(Blueprint $table) {
                    $table->dropColumn('user_id');
                });

                Schema::table('settings', function(Blueprint $table) {
                    $table->dropColumn('currency');
                });

                Schema::table('settings', function(Blueprint $table) {
                    $table->dropColumn('language_id');
                });

                Schema::table('settings', function(Blueprint $table) {
                    $table->dropColumn('user_id');
                });

    }
}
