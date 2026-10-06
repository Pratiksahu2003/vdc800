<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_centres', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->integer('sort_order')->default(0)->after('cta_button_url');
            $table->enum('status', ['draft', 'published'])->default('published')->after('sort_order');
            $table->boolean('is_featured')->default(false)->after('status');
        });

        if (Schema::hasTable('data_centres')) {
            foreach (DB::table('data_centres')->get() as $row) {
                DB::table('data_centres')->where('id', $row->id)->update([
                    'slug' => Str::slug($row->name ?: 'data-centre-'.$row->id),
                    'status' => 'published',
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('data_centres', function (Blueprint $table) {
            $table->dropColumn(['slug', 'sort_order', 'status', 'is_featured']);
        });
    }
};
