<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('TblFechaPCR', function (Blueprint $table) {
            $table->text('idFechaPCR')->nullable()->primary();
            $table->date('amplificationDate')->nullable();
            $table->text('amplificationMethod')->nullable();
            $table->text('lugar_process')->nullable();
            $table->text('amplificationStaff')->nullable();
            $table->integer('num_reacciones')->nullable();
            $table->decimal('volumen_finalRx', 20, 10)->nullable();
            $table->decimal('masterMix', 20, 10)->nullable();
            $table->decimal('clh20', 20, 10)->nullable();
            $table->decimal('buffer', 20, 10)->nullable();
            $table->decimal('bsa', 20, 10)->nullable();
            $table->decimal('mgcl', 20, 10)->nullable();
            $table->decimal('dntp', 20, 10)->nullable();
            $table->decimal('primer_F', 20, 10)->nullable();
            $table->decimal('primer_R', 20, 10)->nullable();
            $table->integer('taq')->nullable();
            $table->integer('adn')->nullable();
            $table->text('equipo_PCR')->nullable();
            $table->integer('pre_c')->nullable();
            $table->integer('pretiempo')->nullable();
            $table->integer('pcr1_c')->nullable();
            $table->integer('pcr1tiempo')->nullable();
            $table->integer('pcr2_c')->nullable();
            $table->integer('pcr2tiempo')->nullable();
            $table->integer('pcr3_c')->nullable();
            $table->integer('pcr3tiempo')->nullable();
            $table->integer('post_c')->nullable();
            $table->integer('post_tiempo')->nullable();
            $table->integer('final_c')->nullable();
            $table->integer('ciclos')->nullable();
            $table->text('imagenPCRAccessionURI')->nullable();
            $table->text('imagenPCR')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TblFechaPCR');
    }
};
