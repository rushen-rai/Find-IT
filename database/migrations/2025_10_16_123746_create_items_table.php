<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id('item_id');

            // foreign key to users.user_id
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');

            // report info
            $table->enum('report_type', ['lost', 'found'])->default('lost');

            // item details
            $table->string('item_name', 150)->index();
            $table->text('description')->nullable();
            $table->string('category', 100)->index();
            $table->date('date_reported')->nullable();
            $table->string('photo')->nullable();

            // location info
            $table->string('location')->nullable();
            $table->string('add_location')->nullable();

            // status & admin fields
            $table->boolean('admin_approved')->default(false);
            $table->enum('status', ['active', 'approved', 'rejected', 'archived'])->default('active');

            // automated priority flag
            $table->enum('prio_flag', ['High', 'Normal'])->default('Normal')->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
