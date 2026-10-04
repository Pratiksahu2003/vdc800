<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_centres', function (Blueprint $table) {
            $table->text('map_link')->nullable()->after('longitude');
            $table->text('map_embed_url')->nullable()->after('map_link');
            $table->boolean('show_map')->default(true)->after('map_embed_url');
        });
    }

    public function down(): void
    {
        Schema::table('data_centres', function (Blueprint $table) {
            $table->dropColumn(['map_link', 'map_embed_url', 'show_map']);
        });
    }
};
