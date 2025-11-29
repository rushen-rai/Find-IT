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
        Schema::table('claims', function (Blueprint $table) {
            // Rename the primary key to claim_id
            $table->renameColumn('id', 'claim_id');

            // Drop approved_by foreign key and column if they exist
            if (Schema::hasColumn('claims', 'approved_by')) {
                $table->dropForeign(['approved_by']);
                $table->dropColumn('approved_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            // Revert changes if rolled back
            $table->renameColumn('claim_id', 'id');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users', 'user_id')
                ->nullOnDelete();
        });
    }
};
