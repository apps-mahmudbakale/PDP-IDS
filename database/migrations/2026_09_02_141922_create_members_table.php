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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('surname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('position');
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('state')->nullable();
            $table->string('pscode')->nullable();
            $table->string('image')->nullable();
            $table->enum('category', ['NWC', 'NEC', 'DEP', 'STAFF'])->default('STAFF');
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
