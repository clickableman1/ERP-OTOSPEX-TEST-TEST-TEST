<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReputationhistoryTable extends Migration
{
    public function up()
    {
        Schema::create('reputation_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->string

("action")->nullable();
            $table->string

("reputation_change")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reputation_history');
    }
}

