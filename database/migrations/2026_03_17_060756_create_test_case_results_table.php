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
        Schema::create('test_case_results', function (Blueprint $table) {
            $table->id();
            $table->string('test_case_id');
            $table->string('test_name');
            $table->text('expected_result');
            $table->text('actual_result');
            $table->string('status');
            $table->string('executed_by');
            $table->timestamp('executed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_case_results');
    }
};
