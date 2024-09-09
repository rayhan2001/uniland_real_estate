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
        Schema::create('setting_site_infos', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->text('footer_text')->nullable();
            $table->timestamps();
        });

        DB::table('setting_site_infos')->insert([
            'id' => 1,
            'site_title' => 'Uniland Real Estate',
            'meta_description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'meta_keyword' => 'agency, business, business cms, company, consulting, corporate, creative, multipurpose, portfolio, pricing table, services, faq, marketing, management system, business website',
            'footer_text' => 'Copyright © 2022 Uniland Real Estate. All Rights Reserved.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_site_infos');
    }
};
