<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('organism', function (Blueprint $table) {
            $table->text('organismID')->nullable()->primary();
            $table->text('associatedOccurrences')->nullable();
            $table->text('associatedOrganisms')->nullable();
            $table->text('previousIdentifications')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organism');
    }
};
