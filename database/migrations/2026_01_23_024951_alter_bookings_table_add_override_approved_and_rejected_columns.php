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
            $table->dateTime('override_at')->nullable()->after('is_override');
            $table->foreignId('override_by')->nullable()->after('override_at')->constrained('users');
            $table->text('override_reason')->nullable()->after('override_by');
            $table->dateTime('approved_at')->nullable()->after('override_reason');
            $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('users');
            $table->dateTime('rejected_at')->nullable()->after('approved_by');
            $table->foreignId('rejected_by')->nullable()->after('rejected_at')->constrained('users');
            $table->text('rejected_reason')->nullable()->after('rejected_by');
            $table->index(['start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['start_time', 'end_time']);
            $table->dropColumn([
                'is_override',
                'override_at',
                'override_by',
                'override_reason',
                'approved_by',
                'approved_at',
                'rejected_at',
                'rejected_by',
                'rejected_reason'
            ]);
        });
    }
};
