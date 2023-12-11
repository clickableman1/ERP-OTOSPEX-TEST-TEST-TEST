<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration1698749776195 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                Schema::create('user_role', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('created_by_user')->nullable();
                    $table->unsignedBigInteger('updated_by_user')->nullable();
                    $table->timestamps();
                });

                    Schema::table('user_role', function(Blueprint $table) {
                        $table->foreign('created_by_user')->references('id')->on('users');
                        $table->foreign('updated_by_user')->references('id')->on('users');
                    });

                Schema::create('role_permission', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('created_by_user')->nullable();
                    $table->unsignedBigInteger('updated_by_user')->nullable();
                    $table->timestamps();
                });

                    Schema::table('role_permission', function(Blueprint $table) {
                        $table->foreign('created_by_user')->references('id')->on('users');
                        $table->foreign('updated_by_user')->references('id')->on('users');
                    });

                Schema::table('permissions', function (Blueprint $table) {
                    $table->string('name')->nullable();

                });

                Schema::table('permissions', function (Blueprint $table) {
                    $table->string('slug')->nullable();

                });

                Schema::table('user_role', function (Blueprint $table) {
                    $table->string('user_id')->nullable();

                });

                Schema::table('user_role', function (Blueprint $table) {
                    $table->string('role_id')->nullable();

                });

                Schema::table('role_permission', function (Blueprint $table) {
                    $table->string('role_id')->nullable();

                });

                Schema::table('role_permission', function (Blueprint $table) {
                    $table->string('permission_id')->nullable();

                });

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {

                Schema::table('role_permission', function(Blueprint $table) {
                    $table->dropColumn('permission_id');
                });

                Schema::table('role_permission', function(Blueprint $table) {
                    $table->dropColumn('role_id');
                });

                Schema::table('user_role', function(Blueprint $table) {
                    $table->dropColumn('role_id');
                });

                Schema::table('user_role', function(Blueprint $table) {
                    $table->dropColumn('user_id');
                });

                Schema::table('permissions', function(Blueprint $table) {
                    $table->dropColumn('slug');
                });

                Schema::table('permissions', function(Blueprint $table) {
                    $table->dropColumn('name');
                });

                Schema::drop('role_permission');

                Schema::drop('user_role');

    }
}
