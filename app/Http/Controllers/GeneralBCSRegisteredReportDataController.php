<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;

class GeneralBCSRegisteredReportDataController extends Controller
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
        
        return view('reports-general-bcs.registered.gender-wise-registered',[
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
        
        return view('reports-general-bcs.registered.gender-wise-registered-distrct-wise',[
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
        
        return view('reports-general-bcs.registered.gender-wise-registered-distrct-wise-div-group',[
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
        
        return view('reports-general-bcs.registered.gender-wise-registered-division-wise',[
            'configs' => $configs,
            'divisionWise' => $divisionWise,
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
                                WHEN age BETWEEN 30 AND 32 THEN '30 - Above'
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
        
        return view('reports-general-bcs.registered.age-wise-registered',[
            'configs' => $configs,
            'ageWise' => $ageWise,
        ]);
        
    }


}
