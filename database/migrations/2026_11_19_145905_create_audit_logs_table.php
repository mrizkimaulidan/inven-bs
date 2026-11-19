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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->default('default');
            $table->string('event');
            $table->string('description');

            $table->nullableMorphs('subject');
            $table->string('subject_label', 150)->nullable();

            $table->nullableMorphs('causer');
            $table->string('causer_name')->nullable();

            $table->json('diff')->nullable();
            $table->json('properties')->nullable();

            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('request_url')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
