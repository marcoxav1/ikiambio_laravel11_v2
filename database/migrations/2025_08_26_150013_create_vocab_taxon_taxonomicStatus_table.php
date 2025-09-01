<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vocab_taxon_taxonomicStatus', function (Blueprint $table) {
            $table->increments('taxonomicStatus_id');
            $table->string('taxonomicStatus_value', 50)->unique();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_taxon_taxonomicStatus');
    }
};
