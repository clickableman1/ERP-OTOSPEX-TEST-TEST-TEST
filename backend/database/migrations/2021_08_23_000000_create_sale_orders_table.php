<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleordersTable extends Migration
{
    public function up()
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->string

("order_id")->nullable();
            $table->string

("invoice_id")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_orders');
    }
}

