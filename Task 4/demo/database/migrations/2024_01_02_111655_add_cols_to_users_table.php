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
            $table->string('contact')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode', 6);
            $table->boolean('status')->comment('1:Active, 0:Inactive')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('contact');
            $table->dropColumn('address');
            $table->dropColumn('postcode');
            $table->dropColumn('status');
        });
    }
};
