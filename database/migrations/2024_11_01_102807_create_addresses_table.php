<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\State;
use App\Enums\Country;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number', 10)->nullable();
            $table->boolean('is_no_number')->default(false);
            $table->string('complement', 255)->nullable();
            $table->string('neighborhood', 255)->nullable();
            $table->string('postal_code', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->enum('state', array_column(State::cases(), 'name'));
            $table->enum('country', array_column(Country::cases(), 'name'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
