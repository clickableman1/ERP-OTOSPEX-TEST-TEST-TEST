<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceordersTable extends Migration
{
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->string

("service_id")->nullable();
            $table->string

("user_id")->nullable();
            $table->string

("status")->nullable();
            $table->timestamp

("appointment_date")->nullable();
            $table->timestamp

("order_date")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_orders');
    }
}

