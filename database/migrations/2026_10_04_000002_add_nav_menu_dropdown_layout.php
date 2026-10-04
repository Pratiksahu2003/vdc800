<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nav_menu_items', function (Blueprint $table) {
            $table->string('dropdown_layout')->nullable()->after('zone'); // split | columns
            $table->boolean('is_sidebar_tab')->default(false)->after('dropdown_layout');
            $table->string('sidebar_key')->nullable()->after('is_sidebar_tab');
            $table->string('promo_title')->nullable()->after('open_in_new_tab');
            $table->string('promo_cta_label')->nullable()->after('promo_title');
            $table->string('promo_route_name')->nullable()->after('promo_cta_label');
            $table->json('promo_route_params')->nullable()->after('promo_route_name');
        });
    }

    public function down(): void
    {
        Schema::table('nav_menu_items', function (Blueprint $table) {
            $table->dropColumn([
                'dropdown_layout',
                'is_sidebar_tab',
                'sidebar_key',
                'promo_title',
                'promo_cta_label',
                'promo_route_name',
                'promo_route_params',
            ]);
        });
    }
};
