<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclepartservicesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_part_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->string

("service_id")->nullable();
            $table->string

("part_id")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_part_services');
    }
}

