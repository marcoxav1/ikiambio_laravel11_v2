<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('TblRegistrosLaboratorio', function (Blueprint $table) {
            $table->text('idRegistrosLaboratorio')->nullable()->primary();
            $table->text('idFechaPCR')->nullable();
            $table->text('idExtracciones')->nullable();
            $table->decimal('vol_ADN_PCR', 20, 10)->nullable();
            $table->boolean('amplificationSuccess')->nullable();
            $table->text('amplificationSuccessDetails')->nullable();
            $table->text('sampleDesignation')->nullable();
            $table->text('idPrimerF')->nullable();
            $table->text('idPrimerR')->nullable();
            $table->text('tecnologia_secuenciacion')->nullable();
            $table->text('consensusSequence')->nullable();
            $table->date('fechaSecuenciacion')->nullable();
            $table->text('sequencingStaff')->nullable();
            $table->text('ordenSecuenciacion')->nullable();
            $table->text('geneticAccessionNumber')->nullable();
            $table->text('geneticAccessionURI')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TblRegistrosLaboratorio');
    }
};
