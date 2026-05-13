<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurant_images', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('image_type');
        });

        DB::table('restaurant_images')
            ->where('image_type', 'gallery')
            ->orderBy('restaurant_id')
            ->orderBy('id')
            ->get()
            ->groupBy('restaurant_id')
            ->each(function ($images) {
                foreach ($images->values() as $index => $image) {
                    DB::table('restaurant_images')
                        ->where('id', $image->id)
                        ->update(['sort_order' => $index + 1]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('restaurant_images', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};

