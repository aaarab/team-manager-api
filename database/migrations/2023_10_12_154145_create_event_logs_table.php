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
        Schema::create('event_logs', function (Blueprint $table) {
            $table->id();
            $table->morphs('object');
            $table->string('action', '45');
            $table->json('attributes')->nullable();
            $table->json('original')->nullable();
            $table->json('changes')->nullable();
            $table->string('request_method');
            $table->string('request_path');
            $table->nullableMorphs('causer') ;
            $table->datetime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_logs');
    }
};
