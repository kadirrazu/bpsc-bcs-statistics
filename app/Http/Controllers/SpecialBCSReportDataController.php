<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;

use Barryvdh\DomPDF\Facade\Pdf;

class SpecialBCSReportDataController extends Controller
{

    public $registrationTable = ''; //reg-all
    public $preliPassedTable = '';  //reg-all-preli
    public $writtenPassedTable = '';  //reg-all-written
    public $finalResultTable = ''; //select-all

    private function setTables( $configs )
    {
        $currentBcsNumber = $configs->where('field', 'current_bcs')->first()['value'];

        $this->registrationTable = 'registrations_' . $currentBcsNumber;
        $this->preliPassedTable = 'preli_passed_' . $currentBcsNumber;
        $this->writtenPassedTable = 'written_passed_' . $currentBcsNumber;
        $this->finalResultTable = 'final_result_' . $currentBcsNumber;
    }

    
    public function genderWiseAllRegisteredCandidates()
    {
        $configs = Config::all();

        $this->setTables( $configs );
        
        $registered = DB::table( $this->registrationTable )->get();

        $total = $registered->count();
        $male = $registered->where('gender', 1)->count();
        $female = $registered->where('gender', 2)->count();
        $tgender = $registered->where('gender', 3)->count();
        
        return view('reports-special-bcs.gender-wise-registered',[
            'configs' => $configs,
            'total' => $total,
            'male' => $male,
            'female' => $female,
            'tgender' => $tgender,
        ]);
    }


    public function genderWisePreliPassedCandidates()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );
        
        $registered = DB::table( $this->registrationTable )->get();

        $preliPassed = DB::table( $this->preliPassedTable )->get();

        $totalRegistered = $registered->count();

        $totalPreliPassed = $preliPassed->count();
        
        $male = $preliPassed->where('gender', 1)->count();
        $female = $preliPassed->where('gender', 2)->count();
        $tgender = $preliPassed->where('gender', 3)->count();
        
        return view('reports-special-bcs.gender-wise-preli-passed',[
            'configs' => $configs,
            'totalRegistered' => $totalRegistered,
            'totalPreliPassed' => $totalPreliPassed,
            'male' => $male,
            'female' => $female,
            'tgender' => $tgender,
        ]);
    }


    public function genderWiseAllSelectedCandidates()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );
        
        $recommended = DB::table( $this->finalResultTable )->get();

        $total = $recommended->count();
        $male = $recommended->where('gender', 1)->count();
        $female = $recommended->where('gender', 2)->count();
        $tgender = $recommended->where('gender', 3)->count();
        
        return view('reports-special-bcs.gender-wise-recommended',[
            'configs' => $configs,
            'total' => $total,
            'male' => $male,
            'female' => $female,
            'tgender' => $tgender,
        ]);
    }


    public function genderWiseAllRegisteredCandidatesDistrctWise()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );

        $districtWise = DB::table( $this->registrationTable )
                    ->join('districts', "{$this->registrationTable}.district_code", '=', 'districts.code')
                    ->select(
                        "{$this->registrationTable}.district_code",
                        'districts.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->registrationTable}.district_code",
                        'districts.name'
                    )
                    ->orderBy('districts.code')
                    ->get();


        $districtWiseTotal = DB::table( $this->registrationTable )
                    ->join('districts', "{$this->registrationTable}.district_code", '=', 'districts.code')
                    ->select(
                        "{$this->registrationTable}.district_code",
                        'districts.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->registrationTable}.district_code",
                        'districts.name'
                    );


        $grandTotal = DB::query()
                        ->fromSub($districtWiseTotal, 't')
                        ->select(
                            DB::raw('SUM(total) as grand_total'),
                            DB::raw('SUM(total_male) as grand_male'),
                            DB::raw('SUM(total_female) as grand_female'),
                            DB::raw('SUM(total_third_gender) as grand_third_gender'),
                        )
                        ->first();
        
        return view('reports-special-bcs.gender-wise-registered-distrct-wise',[
            'configs' => $configs,
            'districtWise' => $districtWise,
            'grandTotal' => $grandTotal,
        ]);
        
    }


    public function genderWiseAllSelectedCandidatesDistrctWise()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );

        $districtWise = DB::table( $this->finalResultTable )
                    ->join('districts', "{$this->finalResultTable}.district_code", '=', 'districts.code')
                    ->select(
                        "{$this->finalResultTable}.district_code",
                        'districts.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->finalResultTable}.district_code",
                        'districts.name'
                    )
                    ->orderBy('districts.code')
                    ->get();


        $districtWiseTotal = DB::table( $this->finalResultTable )
                    ->join('districts', "{$this->finalResultTable}.district_code", '=', 'districts.code')
                    ->select(
                        "{$this->finalResultTable}.district_code",
                        'districts.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->finalResultTable}.district_code",
                        'districts.name'
                    );


        $grandTotal = DB::query()
                        ->fromSub($districtWiseTotal, 't')
                        ->select(
                            DB::raw('SUM(total) as grand_total'),
                            DB::raw('SUM(total_male) as grand_male'),
                            DB::raw('SUM(total_female) as grand_female'),
                            DB::raw('SUM(total_third_gender) as grand_third_gender'),
                        )
                        ->first();
        
        return view('reports-special-bcs.gender-wise-selected-distrct-wise',[
            'configs' => $configs,
            'districtWise' => $districtWise,
            'grandTotal' => $grandTotal,
        ]);

    }


    public function genderWiseAllRegisteredCandidatesDistrctWiseDivGroup()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );

        $districtWise = DB::table( $this->registrationTable )
                    ->join('districts', "{$this->registrationTable}.district_code", '=', 'districts.code')
                    ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                    ->select(
                        "{$this->registrationTable}.district_code",
                        'districts.name',
                        'divisions.code',
                        'divisions.name as div_name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->registrationTable}.district_code",
                        'districts.name',
                        'divisions.code',
                        'divisions.name',
                    )
                    ->orderBy('divisions.code')
                    ->orderBy('districts.code')
                    ->get();


        $districtWiseTotal = DB::table( $this->registrationTable )
                    ->join('districts', "{$this->registrationTable}.district_code", '=', 'districts.code')
                    ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                    ->select(
                        "{$this->registrationTable}.district_code",
                        'districts.name',
                        'divisions.code',
                        'divisions.name as div_name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->registrationTable}.district_code",
                        'districts.name',
                        'divisions.code',
                        'divisions.name',
                    );


        $grandTotal = DB::query()
                        ->fromSub($districtWiseTotal, 't')
                        ->select(
                            DB::raw('SUM(total) as grand_total'),
                            DB::raw('SUM(total_male) as grand_male'),
                            DB::raw('SUM(total_female) as grand_female'),
                            DB::raw('SUM(total_third_gender) as grand_third_gender'),
                        )
                        ->first();
        
        return view('reports-special-bcs.gender-wise-registered-distrct-wise-div-group',[
            'configs' => $configs,
            'districtWise' => $districtWise,
            'grandTotal' => $grandTotal,
        ]);
        
    }


    public function genderWiseAllSelectedCandidatesDistrctWiseDivGroup()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );

        $districtWise = DB::table( $this->finalResultTable )
                    ->join('districts', "{$this->finalResultTable}.district_code", '=', 'districts.code')
                    ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                    ->select(
                        "{$this->finalResultTable}.district_code",
                        'districts.name',
                        'divisions.code',
                        'divisions.name as div_name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->finalResultTable}.district_code",
                        'districts.name',
                        'divisions.code',
                        'divisions.name',
                    )
                    ->orderBy('divisions.code')
                    ->orderBy('districts.code')
                    ->get();


        $districtWiseTotal = DB::table( $this->finalResultTable )
                    ->join('districts', "{$this->finalResultTable}.district_code", '=', 'districts.code')
                    ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                    ->select(
                        "{$this->finalResultTable}.district_code",
                        'districts.name',
                        'divisions.code',
                        'divisions.name as div_name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->finalResultTable}.district_code",
                        'districts.name',
                        'divisions.code',
                        'divisions.name',
                    );


        $grandTotal = DB::query()
                        ->fromSub($districtWiseTotal, 't')
                        ->select(
                            DB::raw('SUM(total) as grand_total'),
                            DB::raw('SUM(total_male) as grand_male'),
                            DB::raw('SUM(total_female) as grand_female'),
                            DB::raw('SUM(total_third_gender) as grand_third_gender'),
                        )
                        ->first();
        
        return view('reports-special-bcs.gender-wise-selected-distrct-wise-div-group',[
            'configs' => $configs,
            'districtWise' => $districtWise,
            'grandTotal' => $grandTotal,
        ]);
        
    }


    public function genderWiseAllRegisteredCandidatesDivisionWise()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );

        $divisionWise = DB::table( $this->registrationTable )
                    ->join('districts', "{$this->registrationTable}.district_code", '=', 'districts.code')
                    ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                    ->select(
                        'divisions.code',
                        'divisions.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'divisions.code',
                        'divisions.name'
                    )
                    ->orderBy('divisions.code')
                    ->get();


        $divisionWiseTotal = DB::table( $this->registrationTable )
                    ->join('districts', "{$this->registrationTable}.district_code", '=', 'districts.code')
                    ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                    ->select(
                        'divisions.code',
                        'divisions.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->registrationTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'divisions.code',
                        'divisions.name'
                    );


        $grandTotal = DB::query()
                        ->fromSub($divisionWiseTotal, 't')
                        ->select(
                            DB::raw('SUM(total) as grand_total'),
                            DB::raw('SUM(total_male) as grand_male'),
                            DB::raw('SUM(total_female) as grand_female'),
                            DB::raw('SUM(total_third_gender) as grand_third_gender'),
                        )
                        ->first();
        
        return view('reports-special-bcs.gender-wise-registered-division-wise',[
            'configs' => $configs,
            'divisionWise' => $divisionWise,
            'grandTotal' => $grandTotal,
        ]);
        
    }


    public function genderWiseAllPreliPassedCandidatesDivisionWise()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );

        $divisionWisePreliPassed = DB::table( $this->preliPassedTable )
                                ->join('districts', "{$this->preliPassedTable}.district_code", '=', 'districts.code')
                                ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                                ->select(
                                    'divisions.code',
                                    'divisions.name',
                                    DB::raw('COUNT(*) as total'),
                                    DB::raw("SUM(CASE WHEN {$this->preliPassedTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                                    DB::raw("SUM(CASE WHEN {$this->preliPassedTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                                    DB::raw("SUM(CASE WHEN {$this->preliPassedTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                                )
                                ->groupBy(
                                    'divisions.code',
                                    'divisions.name'
                                )
                                ->orderBy('divisions.code')
                                ->get();


        $divisionWisePreliPassedTotal = DB::table( $this->preliPassedTable )
                                        ->join('districts', "{$this->preliPassedTable}.district_code", '=', 'districts.code')
                                        ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                                        ->select(
                                            'divisions.code',
                                            'divisions.name',
                                            DB::raw('COUNT(*) as total'),
                                            DB::raw("SUM(CASE WHEN {$this->preliPassedTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                                            DB::raw("SUM(CASE WHEN {$this->preliPassedTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                                            DB::raw("SUM(CASE WHEN {$this->preliPassedTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                                        )
                                        ->groupBy(
                                            'divisions.code',
                                            'divisions.name'
                                        );


        $grandTotal = DB::query()
                        ->fromSub($divisionWisePreliPassedTotal, 't')
                        ->select(
                            DB::raw('SUM(total) as grand_total'),
                            DB::raw('SUM(total_male) as grand_male'),
                            DB::raw('SUM(total_female) as grand_female'),
                            DB::raw('SUM(total_third_gender) as grand_third_gender'),
                        )
                        ->first();
        
        return view('reports-special-bcs.gender-wise-preli-passed-division-wise',[
            'configs' => $configs,
            'divisionWise' => $divisionWisePreliPassed,
            'grandTotal' => $grandTotal,
        ]);
        
    }
    

    public function genderWiseAllSelectedCandidatesDivisionWise()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );

        $divisionWise = DB::table( $this->finalResultTable )
                    ->join('districts', "{$this->finalResultTable}.district_code", '=', 'districts.code')
                    ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                    ->select(
                        'divisions.code',
                        'divisions.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'divisions.code',
                        'divisions.name'
                    )
                    ->orderBy('divisions.code')
                    ->get();


        $divisionWiseTotal = DB::table( $this->finalResultTable )
                    ->join('districts', "{$this->finalResultTable}.district_code", '=', 'districts.code')
                    ->join('divisions', 'districts.div_code', '=', 'divisions.code')
                    ->select(
                        'divisions.code',
                        'divisions.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'divisions.code',
                        'divisions.name'
                    );


        $grandTotal = DB::query()
                        ->fromSub($divisionWiseTotal, 't')
                        ->select(
                            DB::raw('SUM(total) as grand_total'),
                            DB::raw('SUM(total_male) as grand_male'),
                            DB::raw('SUM(total_female) as grand_female'),
                            DB::raw('SUM(total_third_gender) as grand_third_gender'),
                        )
                        ->first();
        
        return view('reports-special-bcs.gender-wise-selected-division-wise',[
            'configs' => $configs,
            'divisionWise' => $divisionWise,
            'grandTotal' => $grandTotal,
        ]);

    }


    public function genderWiseAllSelectedCandidatesInstituteWise()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );

        $institutesWise = DB::table( $this->finalResultTable )
                    ->join('institutes', "{$this->finalResultTable}.g_inst_code", '=', 'institutes.code')
                    ->select(
                        "{$this->finalResultTable}.g_inst_code",
                        'institutes.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->finalResultTable}.g_inst_code",
                        'institutes.name'
                    )
                    ->orderBy('total', 'DESC')
                    ->get();


        $institutesWiseTotal = DB::table( $this->finalResultTable )
                    ->join('institutes', "{$this->finalResultTable}.g_inst_code", '=', 'institutes.code')
                    ->select(
                        "{$this->finalResultTable}.g_inst_code",
                        'institutes.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        "{$this->finalResultTable}.g_inst_code",
                        'institutes.name'
                    );


        $grandTotal = DB::query()
                        ->fromSub($institutesWiseTotal, 't')
                        ->select(
                            DB::raw('SUM(total) as grand_total'),
                            DB::raw('SUM(total_male) as grand_male'),
                            DB::raw('SUM(total_female) as grand_female'),
                            DB::raw('SUM(total_third_gender) as grand_third_gender'),
                        )
                        ->first();
        
        return view('reports-special-bcs.gender-wise-selected-institute-wise',[
            'configs' => $configs,
            'institutesWise' => $institutesWise,
            'grandTotal' => $grandTotal,
        ]);

    }


    public function genderWiseAllSelectedCandidatesOthersInstituteWise()
    {
        $configs = Config::all();
        
        $this->setTables( $configs );

        $institutesWise = DB::table( $this->finalResultTable )
                    ->join('institutes', "{$this->finalResultTable}.g_inst_code", '=', 'institutes.code')
                    ->select(
                        "{$this->finalResultTable}.g_inst_code",
                        "{$this->finalResultTable}.g_inst_name",
                        'institutes.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->where('g_inst_code', 999)
                    ->groupBy(
                        "{$this->finalResultTable}.g_inst_code",
                        "{$this->finalResultTable}.g_inst_name",
                        'institutes.name'
                    )
                    ->orderBy('total', 'DESC')
                    ->get();


        $institutesWiseTotal = DB::table( $this->finalResultTable )
                    ->join('institutes', "{$this->finalResultTable}.g_inst_code", '=', 'institutes.code')
                    ->select(
                        "{$this->finalResultTable}.g_inst_code",
                        "{$this->finalResultTable}.g_inst_name",
                        'institutes.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN {$this->finalResultTable}.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->where('g_inst_code', 999)
                    ->groupBy(
                        "{$this->finalResultTable}.g_inst_code",
                        "{$this->finalResultTable}.g_inst_name",
                        'institutes.name'
                    );


        $grandTotal = DB::query()
                        ->fromSub($institutesWiseTotal, 't')
                        ->select(
                            DB::raw('SUM(total) as grand_total'),
                            DB::raw('SUM(total_male) as grand_male'),
                            DB::raw('SUM(total_female) as grand_female'),
                            DB::raw('SUM(total_third_gender) as grand_third_gender'),
                        )
                        ->first();
        
        return view('reports-special-bcs.gender-wise-selected-others-institute-wise',[
            'configs' => $configs,
            'institutesWise' => $institutesWise,
            'grandTotal' => $grandTotal,
        ]);

    }


    public function ageWiseAllRegisteredCandidates()
    {
        $configs = Config::all();

        $age_calculation_end_date = $configs->where('field', 'age_calculation_end_date')->first()['value'];
        
        $this->setTables( $configs );

        $ageWise = DB::table(DB::raw("
                        (
                            SELECT
                                *,
                                TIMESTAMPDIFF(YEAR, dob, '{$age_calculation_end_date}') AS age
                            FROM $this->registrationTable
                            WHERE dob IS NOT NULL
                        ) t
                    "))
                    ->select(
                        DB::raw("
                            CASE
                                WHEN age BETWEEN 21 AND 23 THEN '21 - 23'
                                WHEN age BETWEEN 24 AND 26 THEN '24 - 26'
                                WHEN age BETWEEN 27 AND 29 THEN '27 - 29'
                                WHEN age BETWEEN 30 AND 32 THEN '30 - 32'
                                ELSE 'Other'
                            END AS age_group
                        "),
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN gender = 1 THEN 1 ELSE 0 END) as male"),
                        DB::raw("SUM(CASE WHEN gender = 2 THEN 1 ELSE 0 END) as female"),
                        DB::raw("SUM(CASE WHEN gender = 3 THEN 1 ELSE 0 END) as third_gender")
                    )
                    ->groupBy('age_group')
                    ->orderBy('age_group')
                    ->get();
        
        return view('reports-special-bcs.age-wise-registered',[
            'configs' => $configs,
            'ageWise' => $ageWise,
        ]);
        
    }


    public function ageWisePreliPassedCandidates()
    {
        $configs = Config::all();

        $age_calculation_end_date = $configs->where('field', 'age_calculation_end_date')->first()['value'];
        
        $this->setTables( $configs );

        $ageWise = DB::table(DB::raw("
                        (
                            SELECT
                                *,
                                TIMESTAMPDIFF(YEAR, dob, '{$age_calculation_end_date}') AS age
                            FROM $this->preliPassedTable
                            WHERE dob IS NOT NULL
                        ) t
                    "))
                    ->select(
                        DB::raw("
                            CASE
                                WHEN age BETWEEN 21 AND 23 THEN '21 - 23'
                                WHEN age BETWEEN 24 AND 26 THEN '24 - 26'
                                WHEN age BETWEEN 27 AND 29 THEN '27 - 29'
                                WHEN age BETWEEN 30 AND 32 THEN '30 - 32'
                                ELSE 'Other'
                            END AS age_group
                        "),
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN gender = 1 THEN 1 ELSE 0 END) as male"),
                        DB::raw("SUM(CASE WHEN gender = 2 THEN 1 ELSE 0 END) as female"),
                        DB::raw("SUM(CASE WHEN gender = 3 THEN 1 ELSE 0 END) as third_gender")
                    )
                    ->groupBy('age_group')
                    ->orderBy('age_group')
                    ->get();
        
        return view('reports-special-bcs.age-wise-preli-passed',[
            'configs' => $configs,
            'ageWise' => $ageWise,
        ]);
        
    }


    public function ageWiseAllSelectedCandidates()
    {
        $configs = Config::all();

        $age_calculation_end_date = $configs->where('field', 'age_calculation_end_date')->first()['value'];
        
        $this->setTables( $configs );

        $ageWise = DB::table(DB::raw("
                        (
                            SELECT
                                *,
                                TIMESTAMPDIFF(YEAR, dob, '{$age_calculation_end_date}') AS age
                            FROM $this->finalResultTable
                            WHERE dob IS NOT NULL
                        ) t
                    "))
                    ->select(
                        DB::raw("
                            CASE
                                WHEN age BETWEEN 21 AND 23 THEN '21 - 23'
                                WHEN age BETWEEN 24 AND 26 THEN '24 - 26'
                                WHEN age BETWEEN 27 AND 29 THEN '27 - 29'
                                WHEN age BETWEEN 30 AND 32 THEN '30 - 32'
                                ELSE 'Other'
                            END AS age_group
                        "),
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN gender = 1 THEN 1 ELSE 0 END) as male"),
                        DB::raw("SUM(CASE WHEN gender = 2 THEN 1 ELSE 0 END) as female"),
                        DB::raw("SUM(CASE WHEN gender = 3 THEN 1 ELSE 0 END) as third_gender")
                    )
                    ->groupBy('age_group')
                    ->orderBy('age_group')
                    ->get();
        
        return view('reports-special-bcs.age-wise-selected',[
            'configs' => $configs,
            'ageWise' => $ageWise,
        ]);
        
    }


} //End of the CLASS
