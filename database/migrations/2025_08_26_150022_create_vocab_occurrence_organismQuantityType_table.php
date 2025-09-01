<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vocab_occurrence_organismQuantityType', function (Blueprint $table) {
            $table->increments('oqtype_id');
            $table->string('oqtype_value', 30)->unique();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_occurrence_organismQuantityType');
    }
};
