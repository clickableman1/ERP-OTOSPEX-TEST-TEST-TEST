<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration1698687627292 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                Schema::table('suppliers', function (Blueprint $table) {
                    $table->string('name')->nullable();

                });

                Schema::table('suppliers', function (Blueprint $table) {
                    $table->string('location')->nullable();

                });

                Schema::table('suppliers', function (Blueprint $table) {
                    $table->string('email')->nullable();

                });

                Schema::table('suppliers', function (Blueprint $table) {
                    $table->string('country_of_origin')->nullable();

                });

                Schema::table('suppliers', function (Blueprint $table) {
                    $table->string('phone')->nullable();

                });

                Schema::table('suppliers', function (Blueprint $table) {
                    $table->integer('year_established')->nullable();

                });

                Schema::table('suppliers', function (Blueprint $table) {
                    $table->string('website')->nullable();

                });

                Schema::table('invoices', function (Blueprint $table) {
                    $table->string('total_amount')->nullable();

                });

                Schema::table('invoices', function (Blueprint $table) {
                    $table->decimal('invoice_number')->nullable();

                });

                Schema::table('invoices', function (Blueprint $table) {
                    $table->string('issue_date')->nullable();

                });

                Schema::table('invoices', function (Blueprint $table) {
                    $table->string('due_date')->nullable();

                });

                Schema::table('invoices', function (Blueprint $table) {
                    $table->string('user_id')->nullable();

                });

                Schema::table('invoices', function (Blueprint $table) {
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

                Schema::table('invoices', function(Blueprint $table) {
                    $table->dropColumn('supplier_id');
                });

                Schema::table('invoices', function(Blueprint $table) {
                    $table->dropColumn('user_id');
                });

                Schema::table('invoices', function(Blueprint $table) {
                    $table->dropColumn('due_date');
                });

                Schema::table('invoices', function(Blueprint $table) {
                    $table->dropColumn('issue_date');
                });

                Schema::table('invoices', function(Blueprint $table) {
                    $table->dropColumn('invoice_number');
                });

                Schema::table('invoices', function(Blueprint $table) {
                    $table->dropColumn('total_amount');
                });

                Schema::table('suppliers', function(Blueprint $table) {
                    $table->dropColumn('website');
                });

                Schema::table('suppliers', function(Blueprint $table) {
                    $table->dropColumn('year_established');
                });

                Schema::table('suppliers', function(Blueprint $table) {
                    $table->dropColumn('phone');
                });

                Schema::table('suppliers', function(Blueprint $table) {
                    $table->dropColumn('country_of_origin');
                });

                Schema::table('suppliers', function(Blueprint $table) {
                    $table->dropColumn('email');
                });

                Schema::table('suppliers', function(Blueprint $table) {
                    $table->dropColumn('location');
                });

                Schema::table('suppliers', function(Blueprint $table) {
                    $table->dropColumn('name');
                });

    }
}
