<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Departments only apply to the EST Staff and Personal Staff categories,
     * so the column is nullable at the database level and enforced as
     * required by those categories' controllers.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('department')->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('department');
        });
    }
};
