<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vocab_record_level_ownerInstitutionCode', function (Blueprint $table) {
            $table->increments('ownerinstitutioncode_id');
            $table->string('ownerinstitutioncode_value', 150)->unique();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_record_level_ownerInstitutionCode');
    }
};
