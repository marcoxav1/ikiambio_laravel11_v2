<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vocab_record_level_type', function (Blueprint $table) {
            $table->increments('type_id');
            $table->string('type_value', 20)->unique();
            $table->text('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_record_level_type');
    }
};
