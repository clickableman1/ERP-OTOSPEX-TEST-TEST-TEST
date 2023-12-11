<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration1698749517786 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                Schema::create('customers', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('created_by_user')->nullable();
                    $table->unsignedBigInteger('updated_by_user')->nullable();
                    $table->timestamps();
                });

                    Schema::table('customers', function(Blueprint $table) {
                        $table->foreign('created_by_user')->references('id')->on('users');
                        $table->foreign('updated_by_user')->references('id')->on('users');
                    });

                Schema::table('customers', function (Blueprint $table) {
                    $table->string('name')->nullable();

                });

                Schema::table('customers', function (Blueprint $table) {
                    $table->string('user_id')->nullable();

                });

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {

                Schema::table('customers', function(Blueprint $table) {
                    $table->dropColumn('user_id');
                });

                Schema::table('customers', function(Blueprint $table) {
                    $table->dropColumn('name');
                });

                Schema::drop('customers');

    }
}
