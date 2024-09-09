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
        Schema::create('setting_contact_infos', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('contact_address');
            $table->string('contact_mail');
            $table->timestamps();
        });

        DB::table('setting_contact_infos')->insert([
            'id' => 1,
            'phone' => '+1 246-345-0695',
            'contact_address' => '123 Main Street',
            'contact_mail' => 'contact@homex.com',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_contact_infos');
    }
};
