<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ikiambio_users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('utplId')->unique()->nullable();
            $table->string('firstName');                 // NOT NULL
            $table->string('lastName');                  // NOT NULL
            $table->string('identification')->unique()->nullable();
            $table->string('username')->unique();        // NOT NULL

            // Timestamps personalizados (no usamos created_at/updated_at)
            $table->timestampTz('createdDate')->nullable();
            $table->timestampTz('modifiedDate')->nullable();

            // Campo de auditoría opcional
            $table->timestampTz('lastLogin')->nullable();

            // Índices útiles
            $table->index('lastLogin');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ikiambio_users');
    }
};
