<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::table('company_settings')->exists()) {
            return;
        }

        DB::table('company_settings')->update([
            'logo' => 'Logo/logo.png',
            'footer_logo' => 'Logo/logo.png',
            'favicon' => 'Logo/favicon.ico',
        ]);
    }

    public function down(): void
    {
        //
    }
};
