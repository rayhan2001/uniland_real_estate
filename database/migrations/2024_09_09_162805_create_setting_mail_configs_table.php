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
        Schema::create('setting_mail_configs', function (Blueprint $table) {
            $table->id();
            $table->string('mail_driver');
            $table->string('mail_host');
            $table->string('mail_port');
            $table->string('mail_username');
            $table->string('mail_password');
            $table->string('mail_encryption');
            $table->string('mail_from_address');
            $table->string('mail_from_name');
            $table->timestamps();
        });

        DB::table('setting_mail_configs')->insert([
            [
                'mail_driver' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => '587',
                'mail_username' => 'XkV6n@example.com',
                'mail_password' => 'lqkqkqkqkqkqkqkqkqkqkqkqkqkqkqkq',
                'mail_encryption' => 'tls',
                'mail_from_address' => 'XkV6n@example.com',
                'mail_from_name' => 'XkV6n@example.com',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_mail_configs');
    }
};
