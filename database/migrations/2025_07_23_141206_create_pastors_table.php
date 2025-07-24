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
       Schema::create('pastors', function (Blueprint $table) {
    $table->id();
    $table->string('fullname');
    $table->string('pastor_code'); // renamed from Pastor_id
    $table->string('title'); // fixed typo
    $table->date('dob');
    $table->string('marital_status');
    $table->string('spouse')->nullable();
    $table->string('children')->nullable();
    $table->string('telephone'); // fixed typo
    $table->date('from_date'); // renamed to avoid SQL keyword
    $table->date('to_date')->nullable(); // pastors still serving may not have a "to"
    $table->string('next_of_kin');
    $table->string('emergency_contact'); // fixed typo
     $table->string('photo')->nullable();
    $table->string('created_by')->nullable();
    $table->string('status')->default('active');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastors');

    }
};
