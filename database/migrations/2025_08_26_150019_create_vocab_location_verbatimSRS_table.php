<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vocab_location_verbatimSRS', function (Blueprint $table) {
            $table->increments('verbatimSRS_id');
            $table->string('verbatimSRS_value', 50)->unique();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_location_verbatimSRS');
    }
};
