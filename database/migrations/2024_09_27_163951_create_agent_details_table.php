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
        Schema::create('agent_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('country_id');
            $table->text('address');
            $table->string('city');
            $table->string('post_code');
            $table->string('state');
            $table->string('organization_name');
            $table->string('organization_email');
            $table->string('photo');
            $table->string('license_no');
            $table->string('license_image_front');
            $table->string('license_image_back');
            $table->string('identification_no');
            $table->string('identification_image_front');
            $table->string('identification_image_back');
            $table->unsignedBigInteger('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_details');
    }
};
