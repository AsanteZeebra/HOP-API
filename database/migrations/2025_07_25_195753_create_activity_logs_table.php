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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('username');         // Who performed the action
            $table->string('action');           // e.g. created, updated, deleted
            $table->string('table_name');       // e.g. branches, members
            $table->string('record_id')->nullable();   // ID of the affected record
            $table->text('description')->nullable();   // Optional message
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
