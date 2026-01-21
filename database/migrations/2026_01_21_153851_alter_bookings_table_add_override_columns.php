<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('is_override')->default(false)->after('status');
            $table->text('override_reason')->nullable()->after('is_override');
            $table->foreignId('approved_by')->nullable()->after('override_reason')->constrained('users');
            $table->index(['start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropIndex(['start_time', 'end_time']);
            $table->dropColumn(['is_override', 'override_reason', 'approved_by']);
        });
    }
};
