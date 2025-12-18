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
        Schema::table('posm_requests', function (Blueprint $table) {
            // Add missing fields from markombranch form
            $table->string('requester_phone')->nullable()->after('requester_name');
            $table->date('deadline')->nullable()->after('requester_phone');
            $table->text('shipping_address')->nullable()->after('location_address');
            $table->string('purpose')->nullable()->after('location_type');
            $table->string('posm_type')->nullable()->after('purpose');
            $table->integer('quantity')->nullable()->after('posm_type');
            $table->string('custom_size')->nullable()->after('quantity');
            $table->text('additional_link')->nullable()->after('custom_size');
            $table->text('mandatory_elements')->nullable()->after('additional_link');
            $table->text('notes')->nullable()->after('special_notes');
            
            // Designer approval fields
            $table->string('production_status')->nullable()->after('rejection_reason');
            $table->timestamp('production_started_at')->nullable()->after('production_status');
            $table->timestamp('production_completed_at')->nullable()->after('production_started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posm_requests', function (Blueprint $table) {
            $table->dropColumn([
                'requester_phone',
                'deadline',
                'shipping_address',
                'purpose',
                'posm_type',
                'quantity',
                'custom_size',
                'additional_link',
                'mandatory_elements',
                'notes',
                'production_status',
                'production_started_at',
                'production_completed_at',
            ]);
        });
    }
};
