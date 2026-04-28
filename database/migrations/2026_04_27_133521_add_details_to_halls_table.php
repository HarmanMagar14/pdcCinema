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
        Schema::table('halls', function (Blueprint $table) {
            $table->string('screen_type', 50)->nullable()->after('capacity');
            $table->string('audio_system', 100)->nullable()->after('screen_type');
            $table->string('screen_dimensions', 50)->nullable()->after('audio_system');
            $table->enum('projection_type', ['2D', '3D', 'IMAX'])->default('2D')->after('screen_dimensions');
            $table->json('seat_layout_config')->nullable()->after('projection_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('halls', function (Blueprint $table) {
            $table->dropColumn(['screen_type', 'audio_system', 'screen_dimensions', 'projection_type', 'seat_layout_config']);
        });
    }
};
