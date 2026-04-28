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
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('cinema_date');
            $table->unsignedBigInteger('show_time_id')->nullable()->after('release_date');
            
            $table->foreign('show_time_id')->references('id')->on('showtimes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropForeign(['show_time_id']);
            $table->dropColumn('show_time_id');
            $table->date('cinema_date')->nullable()->after('release_date');
        });
    }
};
