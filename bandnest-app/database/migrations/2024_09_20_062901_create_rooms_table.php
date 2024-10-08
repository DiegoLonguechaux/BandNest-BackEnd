<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('structure_id')->constrained('structures');
            $table->string('name');
            $table->decimal('size')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price_per_hour')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('zip_code');
            $table->foreignId('country_id')->constrained('countries');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
