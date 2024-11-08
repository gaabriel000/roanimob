<?php

use App\Enums\DocumentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255)->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('tax_id', 50);
            $table->enum('tax_type', array_column(DocumentType::cases(), 'name'));
            $table->string('document_number', 50);
            $table->date('birth_date');
            $table->uuid('address_id');
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('persons');
    }
};
