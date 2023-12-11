<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->decimal

("invoice_number")->nullable();
            $table->string

("issue_date")->nullable();
            $table->string

("due_date")->nullable();
            $table->string

("user_id")->nullable();
            $table->string

("supplier_id")->nullable();
            $table->decimal

("total_amount")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}

