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
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthday')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('address')->nullable();
            $table->string('middle_name')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthday');
            $table->dropColumn('avatar');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('middle_name');
        });
    }
};
