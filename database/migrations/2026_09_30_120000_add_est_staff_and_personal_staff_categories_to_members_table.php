<?php

use App\Enums\MemberCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->enum('category', MemberCategory::values())
                ->default(MemberCategory::STAFF->value)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Move members out of the new categories first: narrowing an enum while
        // rows hold those values fails in strict mode.
        DB::table('members')
            ->whereIn('category', [MemberCategory::EST_STAFF->value, MemberCategory::PERSONAL_STAFF->value])
            ->update(['category' => MemberCategory::STAFF->value]);

        Schema::table('members', function (Blueprint $table) {
            $table->enum('category', ['NWC', 'NEC', 'DEP', 'STAFF'])
                ->default(MemberCategory::STAFF->value)
                ->change();
        });
    }
};
