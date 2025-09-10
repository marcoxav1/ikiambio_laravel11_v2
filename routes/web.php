<?php

use Illuminate\Support\Facades\Route;
/* use App\Http\Controllers\Web\IkiambioUserController as IkiambioUserWeb; */

// Home
Route::get('/', fn () => view('home'))->name('home');

use App\Http\Controllers\Web\IkiambioUserController; 
Route::resource('ikiambio-users', IkiambioUserController::class)
    ->parameters(['ikiambio-users' => 'ikiambioUser']);

use App\Http\Controllers\Web\RecordLevelController;
Route::resource('record-level', RecordLevelController::class)
    ->parameters(['record-level' => 'recordLevel']);    

use App\Http\Controllers\Web\OccurrenceController;

Route::get('occurrence/create-wizard', [OccurrenceController::class, 'createWizard'])
    ->name('occurrence.create-wizard');
/* Route::get('occurrence/create_wizard', [OccurrenceController::class, 'createWizard']);  */

// DESPUÉS el resource
Route::resource('occurrence', OccurrenceController::class)
    ->parameters(['occurrence' => 'occurrence'])
    ->whereNumber('occurrence'); 


use App\Http\Controllers\Web\LocationWebController;
Route::resource('location', LocationWebController::class)->names('location');

use App\Http\Controllers\Web\OrganismWebController;
Route::resource('organism', OrganismWebController::class)
    ->names('organism'); // genera organism.index, organism.show, etc.

use App\Http\Controllers\Web\TaxonWebController;
Route::resource('taxon', TaxonWebController::class)->names('taxon');

use App\Http\Controllers\Web\IdentificationWebController;
Route::resource('identification', IdentificationWebController::class)
    ->parameters(['identification' => 'identification'])
    ->names('identification');  // identification.index, identification.show, ...


// ===================== RECORD LEVEL =====================
use App\Http\Controllers\Web\RecordLevel\TypeController;
use App\Http\Controllers\Web\RecordLevel\LicenseController;
use App\Http\Controllers\Web\RecordLevel\RightsHolderController;
use App\Http\Controllers\Web\RecordLevel\AccessRightsController;
use App\Http\Controllers\Web\RecordLevel\InstitutionIdController;
use App\Http\Controllers\Web\RecordLevel\CollectionIdController;
use App\Http\Controllers\Web\RecordLevel\InstitutionCodeController;
use App\Http\Controllers\Web\RecordLevel\CollectionCodeController;
use App\Http\Controllers\Web\RecordLevel\OwnerInstitutionCodeController;
use App\Http\Controllers\Web\RecordLevel\BasisOfRecordController;

/* ---- 1) Rutas compatibles con scaffold (base = nombre tabla en kebab) ---- */
Route::resource('vocab-record-level-type', TypeController::class)
    ->names('vocab-record-level-type')
    ->parameters(['vocab-record-level-type' => 'type']);

Route::resource('vocab-record-level-license', LicenseController::class)
    ->names('vocab-record-level-license')
    ->parameters(['vocab-record-level-license' => 'license']);

Route::resource('vocab-record-level-rights-holder', RightsHolderController::class)
    ->names('vocab-record-level-rights-holder')
    ->parameters(['vocab-record-level-rights-holder' => 'rightsHolder']);

Route::resource('vocab-record-level-access-rights', AccessRightsController::class)
    ->names('vocab-record-level-access-rights')
    ->parameters(['vocab-record-level-access-rights' => 'accessRights']);

Route::resource('vocab-record-level-institution-id', InstitutionIdController::class)
    ->names('vocab-record-level-institution-id')
    ->parameters(['vocab-record-level-institution-id' => 'institutionId']);

Route::resource('vocab-record-level-collection-id', CollectionIdController::class)
    ->names('vocab-record-level-collection-id')
    ->parameters(['vocab-record-level-collection-id' => 'collectionId']);

Route::resource('vocab-record-level-institution-code', InstitutionCodeController::class)
    ->names('vocab-record-level-institution-code')
    ->parameters(['vocab-record-level-institution-code' => 'institutionCode']);

Route::resource('vocab-record-level-collection-code', CollectionCodeController::class)
    ->names('vocab-record-level-collection-code')
    ->parameters(['vocab-record-level-collection-code' => 'collectionCode']);

Route::resource('vocab-record-level-owner-institution-code', OwnerInstitutionCodeController::class)
    ->names('vocab-record-level-owner-institution-code')
    ->parameters(['vocab-record-level-owner-institution-code' => 'ownerInstitutionCode']);

Route::resource('vocab-record-level-basis-of-record', BasisOfRecordController::class)
    ->names('vocab-record-level-basis-of-record')
    ->parameters(['vocab-record-level-basis-of-record' => 'basisOfRecord']);

// ======================= OCCURRENCE ======================
use App\Http\Controllers\Web\Occurrence\OrganismQuantityTypeController;
use App\Http\Controllers\Web\Occurrence\SexController;
use App\Http\Controllers\Web\Occurrence\LifeStageController;
use App\Http\Controllers\Web\Occurrence\ReproductiveConditionController;
use App\Http\Controllers\Web\Occurrence\EstablishmentMeansController;
use App\Http\Controllers\Web\Occurrence\DispositionController;

/* ---- 1) Compatibles con scaffold (base = nombre tabla en kebab) ---- */
Route::resource('vocab-occurrence-organism-quantity-type', OrganismQuantityTypeController::class)
    ->names('vocab-occurrence-organism-quantity-type')
    ->parameters(['vocab-occurrence-organism-quantity-type' => 'organismQuantityType']);

Route::resource('vocab-occurrence-sex', SexController::class)
    ->names('vocab-occurrence-sex')
    ->parameters(['vocab-occurrence-sex' => 'sex']);

Route::resource('vocab-occurrence-life-stage', LifeStageController::class)
    ->names('vocab-occurrence-life-stage')
    ->parameters(['vocab-occurrence-life-stage' => 'lifeStage']);

Route::resource('vocab-occurrence-reproductive-condition', ReproductiveConditionController::class)
    ->names('vocab-occurrence-reproductive-condition')
    ->parameters(['vocab-occurrence-reproductive-condition' => 'reproductiveCondition']);

Route::resource('vocab-occurrence-establishment-means', EstablishmentMeansController::class)
    ->names('vocab-occurrence-establishment-means')
    ->parameters(['vocab-occurrence-establishment-means' => 'establishmentMeans']);

Route::resource('vocab-occurrence-disposition', DispositionController::class)
    ->names('vocab-occurrence-disposition')
    ->parameters(['vocab-occurrence-disposition' => 'disposition']);


    // ======================== TAXON ========================
use App\Http\Controllers\Web\Taxon\TaxonRankController;
use App\Http\Controllers\Web\Taxon\TaxonomicStatusController;

Route::resource('vocab-taxon-taxon-rank', TaxonRankController::class)
    ->names('vocab-taxon-taxon-rank')
    ->parameters(['vocab-taxon-taxon-rank' => 'taxonRank']);

Route::resource('vocab-taxon-taxonomic-status', TaxonomicStatusController::class)
    ->names('vocab-taxon-taxonomic-status')
    ->parameters(['vocab-taxon-taxonomic-status' => 'taxonomicStatus']);


// ==================== IDENTIFICATION ===================
use App\Http\Controllers\Web\Identification\TypeStatusController;
use App\Http\Controllers\Web\Identification\VerificationStatusController;

Route::resource('vocab-identification-type-status', TypeStatusController::class)
    ->names('vocab-identification-type-status')
    ->parameters(['vocab-identification-type-status' => 'typeStatus']);

Route::resource('vocab-identification-verification-status', VerificationStatusController::class)
    ->names('vocab-identification-verification-status')
    ->parameters(['vocab-identification-verification-status' => 'verificationStatus']);


// ======================= LOCATION ======================
use App\Http\Controllers\Web\Location\ContinentController;
use App\Http\Controllers\Web\Location\VerbatimSrsController;
use App\Http\Controllers\Web\Location\GeorefStatusController;

Route::resource('vocab-location-continent', ContinentController::class)
    ->names('vocab-location-continent')
    ->parameters(['vocab-location-continent' => 'continent']);

Route::resource('vocab-location-verbatim-srs', VerbatimSrsController::class)
    ->names('vocab-location-verbatim-srs')
    ->parameters(['vocab-location-verbatim-srs' => 'verbatimSrs']);

Route::resource('vocab-location-georef-status', GeorefStatusController::class)
    ->names('vocab-location-georef-status')
    ->parameters(['vocab-location-georef-status' => 'georefStatus']);


// ===================== TBLPRIMERS ======================
use App\Http\Controllers\Web\Tblprimers\PrimerDirectionController;

Route::resource('vocab-tblprimers-primer-direction', PrimerDirectionController::class)
    ->names('vocab-tblprimers-primer-direction')
    ->parameters(['vocab-tblprimers-primer-direction' => 'primerDirection']);


// ===================== USAR AJAX ======================

use App\Http\Controllers\Ajax\OrganismController as AjaxOrganismController;
Route::get('/ajax/organisms/search', [AjaxOrganismController::class, 'search'])->name('ajax.organisms.search');    
Route::post('/ajax/organisms', [AjaxOrganismController::class, 'store'])->name('ajax.organisms.store');

use App\Http\Controllers\Ajax\RecordLevelController as AjaxRecordLevelController;
Route::get('/ajax/record-levels/search', [AjaxRecordLevelController::class, 'search'])->name('ajax.record-levels.search');
Route::post('/ajax/record-levels', [AjaxRecordLevelController::class, 'store'])->name('ajax.record-levels.store');

use App\Http\Controllers\Ajax\LocationController as AjaxLocationController;
Route::get('/ajax/locations/search', [AjaxLocationController::class, 'search'])->name('ajax.locations.search');
Route::post('/ajax/locations', [AjaxLocationController::class, 'store'])->name('ajax.locations.store');

use App\Http\Controllers\Ajax\TaxonController as AjaxTaxonController;
Route::post('/ajax/taxa', [AjaxTaxonController::class, 'store'])->name('ajax.taxa.store');
Route::get('/ajax/taxa/search', [AjaxTaxonController::class, 'search'])->name('ajax.taxa.search');

use App\Http\Controllers\Ajax\IdentificationController as AjaxIdentificationController;
Route::post('/ajax/identifications', [AjaxIdentificationController::class, 'store'])->name('ajax.identifications.store');
Route::get('/ajax/identifications/search', [AjaxIdentificationController::class, 'search'])->name('ajax.identifications.search');
    

