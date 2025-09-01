<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('taxon', function (Blueprint $table) {
            $table->string('taxonID', 100)->nullable()->primary();
            $table->string('scientificNameID', 100)->nullable();
            $table->string('scientificName', 255)->nullable();
            $table->text('namePublishedIn')->nullable();
            $table->integer('namePublishedInYear')->nullable();
            $table->text('higherClassification')->nullable();
            $table->string('kingdom', 100)->nullable();
            $table->string('phylum', 100)->nullable();
            $table->string('class', 100)->nullable();
            $table->string('order', 100)->nullable();
            $table->string('family', 100)->nullable();
            $table->string('genus', 100)->nullable();
            $table->string('subgenus', 100)->nullable();
            $table->string('specificEpithet', 100)->nullable();
            $table->string('intraspecificEpithet', 100)->nullable();
            $table->integer('taxonRank')->nullable();
            $table->string('verbatimTaxonRank', 50)->nullable();
            $table->text('scientificNameAuthorship')->nullable();
            $table->text('vernacularName')->nullable();
            $table->integer('taxonomicStatus')->nullable();
            $table->text('taxonRemarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxon');
    }
};
