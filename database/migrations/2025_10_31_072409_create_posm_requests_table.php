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
        Schema::create('posm_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('request_number')->unique();
            $table->string('branch');
            $table->string('requester_name');
            $table->string('contact_number', 20);
            $table->text('location_address');
            $table->enum('location_type', ['indoor', 'outdoor', 'booth', 'event']);
            $table->date('installation_date');
            $table->integer('duration_days');
            $table->json('items'); // Array of items with name, quantity, size, notes
            $table->text('special_notes')->nullable();
            $table->json('attachments')->nullable(); // Array of file paths
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posm_requests');
    }
};
