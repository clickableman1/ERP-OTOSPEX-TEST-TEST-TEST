<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolepermissionTable extends Migration
{
    public function up()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->string

("role_id")->nullable();
            $table->string

("permission_id")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_permission');
    }
}

