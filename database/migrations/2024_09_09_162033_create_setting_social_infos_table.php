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
        Schema::create('setting_social_infos', function (Blueprint $table) {
            $table->id();
            $table->string('facebook_url');
            $table->string('twitter_url');
            $table->string('linkedin_url');
            $table->string('youtube_url');
            $table->string('skype_id');
            $table->string('whatsapp_no');
            $table->timestamps();
        });

        DB::table('setting_social_infos')->insert([
            'facebook_url' => 'https://www.facebook.com/1',
            'twitter_url' => 'https://twitter.com/1',
            'linkedin_url' => 'https://www.linkedin.com/1',
            'youtube_url' => 'https://www.youtube.com/1',
            'skype_id' => '1',
            'whatsapp_no' => '1',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_social_infos');
    }
};
