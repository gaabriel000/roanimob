<?php

use App\Enums\BillStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('due_date');
            $table->decimal('paid_amount', 10, 2);
            $table->enum('status', array_column(BillStatus::cases(), 'name'));
            $table->uuid('charge_id');
            $table->timestamps();

            $table->foreign('charge_id')->references('id')->on('charges')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
