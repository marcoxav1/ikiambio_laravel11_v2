<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vocab_occurrence_reproductiveCondition', function (Blueprint $table) {
            $table->increments('reprocond_id');
            $table->string('reprocond_value', 40)->unique();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_occurrence_reproductiveCondition');
    }
};
