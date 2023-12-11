<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration1698671637519 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                Schema::create('roles', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('created_by_user')->nullable();
                    $table->unsignedBigInteger('updated_by_user')->nullable();
                    $table->timestamps();
                });

                    Schema::table('roles', function(Blueprint $table) {
                        $table->foreign('created_by_user')->references('id')->on('users');
                        $table->foreign('updated_by_user')->references('id')->on('users');
                    });

                Schema::table('roles', function (Blueprint $table) {
                    $table->string('role_name')->nullable();

                });

                Schema::table('roles', function (Blueprint $table) {
                    $table->string('slug')->nullable();

                });

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {

                Schema::table('roles', function(Blueprint $table) {
                    $table->dropColumn('slug');
                });

                Schema::table('roles', function(Blueprint $table) {
                    $table->dropColumn('role_name');
                });

                Schema::drop('roles');

    }
}
