<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('record_level', function (Blueprint $table) {
            $table->increments('record_level_id');
            $table->integer('type');
            $table->timestamp('modified')->nullable();
            $table->string('language', 2)->nullable();
            $table->integer('license');
            $table->integer('rightsHolder');
            $table->integer('accessRights');
            $table->text('bibliographicCitation')->nullable();
            $table->text('references')->nullable();
            $table->integer('institutionID');
            $table->integer('collectionID');
            $table->string('datasetID', 100)->nullable();
            $table->integer('institutionCode');
            $table->integer('collectionCode');
            $table->string('datasetName', 255)->nullable();
            $table->integer('ownerInstitutionCode');
            $table->integer('basisOfRecord');
            $table->text('informationWithheld')->nullable();
            $table->text('dataGeneralizations')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('record_level');
    }
};
