<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->string

("name")->nullable();
            $table->string

("location")->nullable();
            $table->string

("email")->nullable();
            $table->string

("country_of_origin")->nullable();
            $table->string

("phone")->nullable();
            $table->integer

("year_established")->nullable();
            $table->string

("website")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}

