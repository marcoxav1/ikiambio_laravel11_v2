<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vocab_identification_typeStatus', function (Blueprint $table) {
            $table->increments('vocab_identification_typeStatus_id');
            $table->string('typeStatus_value', 50)->unique();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_identification_typeStatus');
    }
};
