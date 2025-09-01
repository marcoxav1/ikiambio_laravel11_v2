<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('occurrence', function (Blueprint $table) {
            // Si ya existe índice/único con otro nombre, ajusta el drop en down()
            $table->unique('record_level_id', 'occurrence_record_level_unique');
        });
    }

    public function down(): void
    {
        Schema::table('occurrence', function (Blueprint $table) {
            $table->dropUnique('occurrence_record_level_unique');
        });
    }
};
