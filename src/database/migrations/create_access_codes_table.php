<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_codes', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('code')->unique();
            $table->string('code_criteria');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_codes');
    }
};