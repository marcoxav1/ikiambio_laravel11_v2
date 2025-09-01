<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('occurrence', function (Blueprint $table) {
            $table->increments('id_occ_bd');
            $table->text('occurrenceID')->nullable()->unique();
            $table->integer('record_level_id')->nullable();
            $table->text('catalogNumber')->nullable()->unique();
            $table->text('recordNumber')->nullable();
            $table->text('recordedBy')->nullable();
            $table->integer('individualCount')->nullable();
            $table->decimal('organismQuantity', 20, 10)->nullable();
            $table->integer('organismQuantityType');
            $table->integer('sex');
            $table->integer('lifeStage');
            $table->integer('reproductiveCondition');
            $table->text('behavior')->nullable();
            $table->text('substrate')->nullable();
            $table->integer('establishmentMeans');
            $table->text('preparations')->nullable();
            $table->integer('disposition');
            $table->text('associatedMedia')->nullable();
            $table->text('associatedSequences')->nullable();
            $table->text('associatedTaxa')->nullable();
            $table->text('otherCatalogNumbers')->nullable();
            $table->text('occurrenceRemarks')->nullable();
            $table->text('organismID')->nullable();
            $table->text('locationID')->nullable();
            $table->text('taxonID')->nullable();
            $table->text('identificationID')->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occurrence');
    }
};
