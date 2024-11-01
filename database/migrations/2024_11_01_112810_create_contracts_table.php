<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GuaranteeType;
use App\Enums\PaymentDateType;
use App\Enums\ContractStatus;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('rent_amount', 10, 2);
            $table->enum('guarantee_type', array_column(GuaranteeType::cases(), 'name'));
            $table->date('payment_date');
            $table->enum('payment_date_type', array_column(PaymentDateType::cases(), 'name'));
            $table->enum('status', array_column(ContractStatus::cases(), 'name'));
            $table->uuid('owner_id');
            $table->uuid('tenant_id');
            $table->uuid('property_id');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('persons')->onDelete('restrict');
            $table->foreign('tenant_id')->references('id')->on('persons')->onDelete('restrict');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('restrict');
        });

        Schema::table('contracts', function(Blueprint $table) {
            $table->uuid('parent_contract_id')->nullble();
            $table->foreign('parent_contract_id')->references('id')->on('contracts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contracts');
    }
};
