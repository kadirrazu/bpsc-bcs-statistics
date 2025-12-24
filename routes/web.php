<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SpecialBCSReportDataController;
use App\Http\Controllers\GeneralBCSReportDataController;
use App\Http\Controllers\ReportMenuController;

//Helper Functions for Global Use

function en_to_bn_number($number) {
    $en_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $converted_number = str_replace($en_digits, $bn_digits, $number);
    return $converted_number;
}


Route::get('/', [ReportMenuController::class, 'index']);


/* Special BCS Handling Routes Starts Here */

Route::get('/sp-bcs-geneder-wise-registered', [SpecialBCSReportDataController::class, 'genderWiseAllRegisteredCandidates']);
Route::get('/sp-bcs-geneder-wise-selected', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidates']);

Route::get('/sp-bcs-geneder-wise-passed-preli', [SpecialBCSReportDataController::class, 'genderWisePreliPassedCandidates']);

Route::get('/sp-bcs-geneder-wise-registered-district-wise', [SpecialBCSReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWise']);
Route::get('/sp-bcs-geneder-wise-selected-district-wise', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesDistrctWise']);

Route::get('/sp-bcs-geneder-wise-registered-district-wise-div-group', [SpecialBCSReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWiseDivGroup']);
Route::get('/sp-bcs-geneder-wise-selected-district-wise-div-group', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesDistrctWiseDivGroup']);

Route::get('/sp-bcs-geneder-wise-registered-division-wise', [SpecialBCSReportDataController::class, 'genderWiseAllRegisteredCandidatesDivisionWise']);
Route::get('/sp-bcs-geneder-wise-preli-passed-division-wise', [SpecialBCSReportDataController::class, 'genderWiseAllPreliPassedCandidatesDivisionWise']);
Route::get('/sp-bcs-geneder-wise-selected-division-wise', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesDivisionWise']);

Route::get('/sp-bcs-geneder-wise-selected-institute-wise', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesInstituteWise']);
Route::get('/sp-bcs-geneder-wise-selected-others-institute-wise', [SpecialBCSReportDataController::class, 'genderWiseAllSelectedCandidatesOthersInstituteWise']);

Route::get('/sp-bcs-age-wise-registered', [SpecialBCSReportDataController::class, 'ageWiseAllRegisteredCandidates']);
Route::get('/sp-bcs-age-wise-preli-passed', [SpecialBCSReportDataController::class, 'ageWisePreliPassedCandidates']);
Route::get('/sp-bcs-age-wise-selected', [SpecialBCSReportDataController::class, 'ageWiseAllSelectedCandidates']);

/* Special BCS Handling Routes Ends Here */

/* General BCS Handling Routes Starts Here */

Route::get('/gen-bcs-geneder-wise-registered', [GeneralBCSReportDataController::class, 'genderWiseAllRegisteredCandidates']);

/* General BCS Handling Routes Ends Here */