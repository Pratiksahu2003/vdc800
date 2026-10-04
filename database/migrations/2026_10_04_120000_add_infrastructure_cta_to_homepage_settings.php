<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->string('infrastructure_heading_emphasis')->nullable()->after('infrastructure_heading');
            $table->string('infrastructure_cta_text')->nullable()->after('infrastructure_description');
            $table->string('infrastructure_cta_url')->nullable()->after('infrastructure_cta_text');
        });

        DB::table('homepage_settings')->limit(1)->update([
            'infrastructure_heading' => 'Your business located everywhere your data is.',
            'infrastructure_heading_emphasis' => 'everywhere',
            'infrastructure_description' => 'Deploy workloads in carrier-neutral Nordic facilities with Tier III+ design, direct cloud on-ramps, and 24/7 NOC coverage—so your teams stay connected without compromise.',
            'infrastructure_cta_text' => 'Explore D³ colocation',
            'infrastructure_cta_url' => '/projects',
        ]);
    }

    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn([
                'infrastructure_heading_emphasis',
                'infrastructure_cta_text',
                'infrastructure_cta_url',
            ]);
        });
    }
};
