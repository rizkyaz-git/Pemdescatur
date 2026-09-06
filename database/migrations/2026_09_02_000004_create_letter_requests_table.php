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
        Schema::create('letter_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('template_id')->constrained('letter_templates')->onDelete('cascade');
            $table->string('ticket_number')->unique(); // Nomor tiket otomatis
            $table->json('form_data'); // Data dari form user
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('result_file_path')->nullable(); // Path ke file PDF hasil
            $table->text('admin_notes')->nullable(); // Catatan dari admin
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            $table->index('ticket_number');
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_requests');
    }
};
