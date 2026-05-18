<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('restaurant_type');

            $table->foreignId('restaurant_type_id')
                ->nullable()
                ->after('status')
                ->constrained('restaurant_types')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropConstrainedForeignId('restaurant_type_id');

            $table->string('restaurant_type')->nullable()->after('status');
        });
    }
};
