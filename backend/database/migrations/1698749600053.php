<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration1698749600053 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                Schema::table('roles', function (Blueprint $table) {
                    $table->string('name')->nullable();

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
                    $table->dropColumn('name');
                });

    }
}
