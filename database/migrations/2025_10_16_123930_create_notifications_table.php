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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // Related user
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');

            // Notification content
            $table->string('title');
            $table->text('message');
            $table->string('type')->nullable(); // e.g. 'report', 'claim', 'system'
            $table->boolean('is_read')->default(false);

            // Optional linking (e.g. to a claim or report)
            $table->foreignId('related_id')->nullable();
            $table->string('related_type')->nullable(); // 'claims', 'reports', etc.

            // Audit
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};