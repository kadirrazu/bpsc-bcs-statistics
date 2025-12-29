<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReportMenuController;
use App\Http\Controllers\SpecialBCSReportDataController;
use App\Http\Controllers\GeneralBCSRegisteredReportDataController;
use App\Http\Controllers\GeneralBCSPreliReportDataController;
use App\Http\Controllers\GeneralBCSWrittenReportDataController;
use App\Http\Controllers\GeneralBCSRecommendedReportDataController;

//Helper Functions for Global Use

function en_to_bn_number($number) {
    $en_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $converted_number = str_replace($en_digits, $bn_digits, $number);
    return $converted_number;
}


Route::get('/', [ReportMenuController::class, 'index']);


/* Special BCS Handling Routes Starts Here */

Route::get('/sp-bcs-gender-wise-registered', [SpecialBCSReportDataController::class, 'genderWiseAllRegisteredCandidates']);
Route::get('/sp-bcs-gender-wise-selected', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidates']);

Route::get('/sp-bcs-gender-wise-passed-preli', [SpecialBCSReportDataController::class, 'genderWisePreliPassedCandidates']);

Route::get('/sp-bcs-gender-wise-registered-district-wise', [SpecialBCSReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWise']);
Route::get('/sp-bcs-gender-wise-selected-district-wise', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesDistrctWise']);

Route::get('/sp-bcs-gender-wise-registered-district-wise-div-group', [SpecialBCSReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWiseDivGroup']);
Route::get('/sp-bcs-gender-wise-selected-district-wise-div-group', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesDistrctWiseDivGroup']);

Route::get('/sp-bcs-gender-wise-registered-division-wise', [SpecialBCSReportDataController::class, 'genderWiseAllRegisteredCandidatesDivisionWise']);
Route::get('/sp-bcs-gender-wise-preli-passed-division-wise', [SpecialBCSReportDataController::class, 'genderWiseAllPreliPassedCandidatesDivisionWise']);
Route::get('/sp-bcs-gender-wise-selected-division-wise', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesDivisionWise']);

Route::get('/sp-bcs-gender-wise-selected-institute-wise', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesInstituteWise']);
Route::get('/sp-bcs-gender-wise-selected-others-institute-wise', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesOthersInstituteWise']);

Route::get('/sp-bcs-age-wise-registered', [SpecialBCSReportDataController::class, 'ageWiseAllRegisteredCandidates']);
Route::get('/sp-bcs-age-wise-preli-passed', [SpecialBCSReportDataController::class, 'ageWisePreliPassedCandidates']);
Route::get('/sp-bcs-age-wise-selected', [SpecialBCSReportDataController::class, 'ageWiseAllSelectedCandidates']);

/* Special BCS Handling Routes Ends Here */

/* General BCS Handling Routes Starts Here */

//Registerd Candidates Dealing
Route::get('/1-1-gen-bcs-gender-wise-registered', [GeneralBCSRegisteredReportDataController::class, 'genderWiseAllRegisteredCandidates']);
Route::get('/1-2-gen-bcs-gender-wise-registered-district-wise', [GeneralBCSRegisteredReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWise']);
Route::get('/1-3-gen-bcs-gender-wise-registered-district-wise-div-group', [GeneralBCSRegisteredReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWiseDivGroup']);
Route::get('/1-4-gen-bcs-gender-wise-registered-div-wise', [GeneralBCSRegisteredReportDataController::class, 'genderWiseAllRegisteredCandidatesDivisionWise']);
Route::get('/1-5-gen-bcs-age-wise-registered', [GeneralBCSRegisteredReportDataController::class, 'ageWiseAllRegisteredCandidates']);


//Preli Passed Candidates Dealing
Route::get('/2-1-gen-bcs-gender-wise-preli-passed', [GeneralBCSPreliReportDataController::class, 'genderWiseAllRegisteredCandidates']);
Route::get('/2-2-gen-bcs-gender-wise-preli-passed-district-wise', [GeneralBCSPreliReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWise']);
Route::get('/2-3-gen-bcs-gender-wise-preli-passed-district-wise-div-group', [GeneralBCSPreliReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWiseDivGroup']);
Route::get('/2-4-gen-bcs-gender-wise-preli-passed-div-wise', [GeneralBCSPreliReportDataController::class, 'genderWiseAllRegisteredCandidatesDivisionWise']);
Route::get('/2-5-gen-bcs-age-wise-preli-passed', [GeneralBCSPreliReportDataController::class, 'ageWiseAllRegisteredCandidates']);

//Written Passed Candidates Dealing
Route::get('/3-1-gen-bcs-gender-wise-written-passed', [GeneralBCSWrittenReportDataController::class, 'genderWiseAllRegisteredCandidates']);
Route::get('/3-2-gen-bcs-gender-wise-written-passed-district-wise', [GeneralBCSWrittenReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWise']);
Route::get('/3-3-gen-bcs-gender-wise-written-passed-district-wise-div-group', [GeneralBCSWrittenReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWiseDivGroup']);
Route::get('/3-4-gen-bcs-gender-wise-written-passed-div-wise', [GeneralBCSWrittenReportDataController::class, 'genderWiseAllRegisteredCandidatesDivisionWise']);
Route::get('/3-5-gen-bcs-age-wise-written-passed', [GeneralBCSWrittenReportDataController::class, 'ageWiseAllRegisteredCandidates']);

//Finally Recommended Candidates Dealing
Route::get('/4-1-gen-bcs-gender-wise-recommended', [GeneralBCSRecommendedReportDataController::class, 'genderWiseAllRegisteredCandidates']);
Route::get('/4-2-gen-bcs-gender-wise-recommended-district-wise', [GeneralBCSRecommendedReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWise']);
Route::get('/4-3-gen-bcs-gender-wise-recommended-district-wise-div-group', [GeneralBCSRecommendedReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWiseDivGroup']);
Route::get('/4-4-gen-bcs-gender-wise-recommended-div-wise', [GeneralBCSRecommendedReportDataController::class, 'genderWiseAllRegisteredCandidatesDivisionWise']);
Route::get('/4-5-gen-bcs-age-wise-recommended', [GeneralBCSRecommendedReportDataController::class, 'ageWiseAllRegisteredCandidates']);

Route::get('/4-6-gen-bcs-gender-wise-recommended-subject-wise', [GeneralBCSRecommendedReportDataController::class, 'genderWiseAllRecommendedCandidatesSubjectWise']);
Route::get('/4-7-gen-bcs-gender-wise-recommended-subject-wise-others', [GeneralBCSRecommendedReportDataController::class, 'genderWiseAllRecommendedCandidatesSubjectWiseOthers']);
Route::get('/4-8-gen-bcs-gender-wise-recommended-general-cadre-wise-div-group', [GeneralBCSRecommendedReportDataController::class, 'genderWiseAllRecommendedCandidatesGeneralCadreWiseDivGroup']);

/* General BCS Handling Routes Ends Here */