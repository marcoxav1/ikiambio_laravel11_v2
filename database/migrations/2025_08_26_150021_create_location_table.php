<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('location', function (Blueprint $table) {
            $table->text('locationID')->nullable()->primary();
            $table->text('id_INEC')->nullable();
            $table->text('higherGeographyID')->nullable();
            $table->integer('continent');
            $table->text('waterBody')->nullable();
            $table->text('islandGroup')->nullable();
            $table->text('island')->nullable();
            $table->text('country')->nullable();
            $table->string('countryCode', 2)->nullable();
            $table->text('stateProvince')->nullable();
            $table->text('county')->nullable();
            $table->text('municipality')->nullable();
            $table->text('locality')->nullable();
            $table->text('verbatimLocality')->nullable();
            $table->text('verbatimElevation')->nullable();
            $table->text('verbatimDepth')->nullable();
            $table->text('locationRemarks')->nullable();
            $table->decimal('decimalLatitude', 20, 10)->nullable();
            $table->decimal('decimalLongitude', 20, 10)->nullable();
            $table->text('geodeticDatum')->nullable();
            $table->text('verbatimLatitude')->nullable();
            $table->text('verbatimLongitude')->nullable();
            $table->text('verbatimCoordinateSystem')->nullable();
            $table->integer('verbatimSRS');
            $table->text('georeferencedBy')->nullable();
            $table->date('georeferencedDate')->nullable();
            $table->integer('georeferenceVerificationStatus');
            $table->text('georeferenceRemarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('location');
    }
};
