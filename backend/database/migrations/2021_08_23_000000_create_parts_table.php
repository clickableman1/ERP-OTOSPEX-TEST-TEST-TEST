<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
{
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->string

("name")->nullable();
            $table->string

("description")->nullable();
            $table->string

("barcode")->nullable();
            $table->string

("category")->nullable();
            $table->decimal

("price")->nullable();
            $table->decimal

("weight")->nullable();
            $table->string

("dimensions")->nullable();
            $table->integer

("quantity_in_stock")->nullable();
            $table->integer

("minimum_stock_level")->nullable();
            $table->string

("manufacturer_id")->nullable();
            $table->string

("supplier_id")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parts');
    }
}

