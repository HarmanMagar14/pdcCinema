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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('paymongo_payment_id')->nullable()->after('date');
            $table->string('paymongo_session_id')->nullable()->after('paymongo_payment_id');
            $table->string('payment_method_type')->nullable()->after('paymongo_session_id');
            $table->string('receipt_number')->nullable()->after('payment_method_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('paymongo_payment_id');
            $table->dropColumn('paymongo_session_id');
            $table->dropColumn('payment_method_type');
            $table->dropColumn('receipt_number');
        });
    }
};
