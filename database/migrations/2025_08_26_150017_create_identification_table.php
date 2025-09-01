<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('identification', function (Blueprint $table) {
            $table->string('identificationID', 100)->nullable()->primary();
            $table->string('identificationQualifier', 100)->nullable();
            $table->integer('typeStatus')->nullable();
            $table->string('identifiedBy', 255)->nullable();
            $table->date('dateIdentified')->nullable();
            $table->integer('identificationVerificationStatus')->nullable();
            $table->text('identificationRemarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identification');
    }
};
