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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('favorite')->default(0)->comment('0:No, 1:Yes');
            $table->enum('type', ['apartment', 'house', 'villa', 'land', 'commercial'])->nullable();
            $table->string('price');
            $table->string('price_for')->nullable();
            $table->string('location')->nullable();
            $table->string('image');
            $table->string('beds')->nullable();
            $table->string('bath')->nullable();
            $table->string('area')->nullable();
            $table->string('added_by');
            $table->longText('description')->nullable();
            $table->enum('gas', ['yes', 'no'])->default('yes');
            $table->enum('status', ['featured', 'forsale'])->default('forsale');
            $table->enum('is_deleted', ['no', 'yes'])->nullable()->default('no');
            $table->enum('visible_status', ['yes', 'no'])->default('yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
