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
      Schema::create('members', function (Blueprint $table) {
    $table->id();
    $table->string('fullname');
    $table->string('member_id')->unique();
    $table->date('dob')->nullable(); // Changed to date
    $table->string('age');
    $table->string('alter_call');
    $table->string('gender');
    $table->string('marital_status');
    $table->string('occupation');
    $table->string('telephone'); // Changed from integer to string
    $table->string('spouse');
    $table->integer('children')->nullable(); // Made nullable
    $table->string('city');
    $table->string('region');
    $table->string('house_address');
    $table->string('postal');
    $table->string('position');
    $table->string('department');
    $table->string('photo')->nullable();
    $table->string('branch_name');
    $table->string('status')->default('active'); // Added status field
    $table->string('branch_id')->nullable(); // Removed unique
    $table->string('created_by')->nullable(); // Added created_by field
    $table->string('updated_by')->nullable(); // Added updated_by field
    $table->string('deleted_by')->nullable(); // Added deleted_by field
    $table->softDeletes(); // Added soft deletes
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
