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
        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('role_id')->unsigned()->default(2)->change();
            $table->string('phone')->unique()->change();
            $table->boolean('has_access')->after('role_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('role_id')->unsigned()->default(null)->change();
            $table->string('phone')->unique(false)->change();
            $table->dropColumn(['has_access']);
        });
    }
};
