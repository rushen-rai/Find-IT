<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Alter the ENUM to include 'approved' and 'rejected' if missing
        DB::statement("ALTER TABLE items MODIFY COLUMN status ENUM('active', 'approved', 'rejected', 'archived') DEFAULT 'active'");
    }

    public function down()
    {
        // Revert to original ENUM
        DB::statement("ALTER TABLE items MODIFY COLUMN status ENUM('active', 'pending', 'rejected', 'archived') DEFAULT 'active'");
    }
};