<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReportDataController;
use App\Http\Controllers\ReportMenuController;

//Helper Functions for Global Use

function en_to_bn_number($number) {
    $en_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $converted_number = str_replace($en_digits, $bn_digits, $number);
    return $converted_number;
}

/* Special BCS Handling Routes Starts Here */

Route::get('/', [ReportMenuController::class, 'index']);

Route::get('/geneder-wise-registered', [ReportDataController::class, 'genderWiseAllRegisteredCandidates']);
Route::get('/geneder-wise-selected', [ReportDataController::class, 'genderWiseAllSelectedCandidates']);

Route::get('/geneder-wise-passed-preli', [ReportDataController::class, 'genderWisePreliPassedCandidates']);

Route::get('/geneder-wise-registered-district-wise', [ReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWise']);
Route::get('/geneder-wise-selected-district-wise', [ReportDataController::class, 'genderWiseAllSelectedCandidatesDistrctWise']);

Route::get('/geneder-wise-registered-district-wise-div-group', [ReportDataController::class, 'genderWiseAllRegisteredCandidatesDistrctWiseDivGroup']);
Route::get('/geneder-wise-selected-district-wise-div-group', [ReportDataController::class, 'genderWiseAllSelectedCandidatesDistrctWiseDivGroup']);

Route::get('/geneder-wise-registered-division-wise', [ReportDataController::class, 'genderWiseAllRegisteredCandidatesDivisionWise']);
Route::get('/geneder-wise-selected-division-wise', [ReportDataController::class, 'genderWiseAllSelectedCandidatesDivisionWise']);

Route::get('/geneder-wise-selected-institute-wise', [ReportDataController::class, 'genderWiseAllSelectedCandidatesInstituteWise']);
Route::get('/geneder-wise-selected-others-institute-wise', [ReportDataController::class, 'genderWiseAllSelectedCandidatesOthersInstituteWise']);

Route::get('/age-wise-registered', [ReportDataController::class, 'ageWiseAllRegisteredCandidates']);
Route::get('/age-wise-selected', [ReportDataController::class, 'ageWiseAllSelectedCandidates']);

/* Special BCS Handling Routes Ends Here */