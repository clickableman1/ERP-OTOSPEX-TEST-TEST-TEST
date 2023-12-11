<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryhistoryTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->string

("part_id")->nullable();
            $table->string

("transaction_type")->nullable();
            $table->string

("transaction_date")->nullable();
            $table->string

("quantity_change")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_history');
    }
}

