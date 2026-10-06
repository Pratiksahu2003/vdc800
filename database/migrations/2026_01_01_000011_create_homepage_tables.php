<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_heading')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_background_image')->nullable();
            $table->string('hero_cta_text')->nullable();
            $table->string('hero_cta_url')->nullable();
            $table->string('hero_secondary_cta_text')->nullable();
            $table->string('hero_secondary_cta_url')->nullable();
            $table->string('intro_heading')->nullable();
            $table->text('intro_description')->nullable();
            $table->string('intro_image')->nullable();
            $table->string('sustainability_heading')->nullable();
            $table->text('sustainability_description')->nullable();
            $table->string('sustainability_image')->nullable();
            $table->string('sustainability_cta_text')->nullable();
            $table->string('sustainability_cta_url')->nullable();
            $table->string('infrastructure_heading')->nullable();
            $table->text('infrastructure_description')->nullable();
            $table->string('infrastructure_image')->nullable();
            $table->string('final_cta_heading')->nullable();
            $table->text('final_cta_description')->nullable();
            $table->string('final_cta_button_text')->nullable();
            $table->string('final_cta_button_url')->nullable();
            $table->timestamps();
        });

        Schema::create('homepage_benefits', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('homepage_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('label');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_statistics');
        Schema::dropIfExists('homepage_benefits');
        Schema::dropIfExists('homepage_settings');
    }
};
