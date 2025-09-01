<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vocab_tblprimers_primerDirection', function (Blueprint $table) {
            $table->increments('id_primerdirection');
            $table->string('primerdirection_value', 20)->unique();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_tblprimers_primerDirection');
    }
};
