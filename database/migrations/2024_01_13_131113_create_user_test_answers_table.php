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
        Schema::create('user_test_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_test_id');
            $table->unsignedBigInteger('test_answer_id');
            $table->boolean('correct')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_test_id')->references('id')->on('user_tests')->onDelete('CASCADE');
            $table->foreign('test_answer_id')->references('id')->on('test_answers')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_test_answers');
    }
};
