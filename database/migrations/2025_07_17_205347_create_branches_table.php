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
       Schema::create('branches', function (Blueprint $table) {
    $table->id();
    $table->string('branch_name')->unique();
    $table->string('branch_id')->unique();
    $table->string('type')->nullable();
    $table->string('region');
    $table->string('district');
    $table->string('town');
    $table->string('area_head');
    $table->string('telephone');
    $table->string('email')->unique(); // Only email is enforced unique
    $table->text('address')->nullable();
    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->softDeletes(); // For soft deletes
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
