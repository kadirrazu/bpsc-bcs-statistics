<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;

use Barryvdh\DomPDF\Facade\Pdf;

class ReportDataController extends Controller
{
    
    public function genderWiseAllRegisteredCandidates()
    {
        $configs = Config::all();
        
        $registered = DB::table('registrations48')->get();

        $total = $registered->count();
        $male = $registered->where('gender', 1)->count();
        $female = $registered->where('gender', 2)->count();
        $tgender = $registered->where('gender', 3)->count();
        
        return view('reports.gender-wise-registered',[
            'configs' => $configs,
            'total' => $total,
            'male' => $male,
            'female' => $female,
            'tgender' => $tgender,
        ]);
    }

    public function genderWiseAllRegisteredCandidatesPdf()
    {
        $configs = Config::all();
        
        $registered = DB::table('registrations48')->get();

        $total = $registered->count();
        $male = $registered->where('gender', 1)->count();
        $female = $registered->where('gender', 2)->count();
        $tgender = $registered->where('gender', 3)->count();

        $pdf = Pdf::loadView('reports.gender-wise-registered',[
            'configs' => $configs,
            'total' => $total,
            'male' => $male,
            'female' => $female,
            'tgender' => $tgender,
        ]);

        return $pdf->download('Gender-Wise-All-Registered-Candidates.pdf');

    }

    
    public function genderWiseAllSelectedCandidates()
    {
        $configs = Config::all();
        
        $recommended = DB::table('results48')->get();

        $total = $recommended->count();
        $male = $recommended->where('gender', 1)->count();
        $female = $recommended->where('gender', 2)->count();
        $tgender = $recommended->where('gender', 3)->count();
        
        return view('reports.gender-wise-recommended',[
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

        $districtWise = DB::table('registrations48')
                    ->join('districts', 'registrations48.district_code', '=', 'districts.code')
                    ->select(
                        'registrations48.district_code',
                        'districts.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'registrations48.district_code',
                        'districts.name'
                    )
                    ->orderBy('districts.code')
                    ->get();


        $districtWiseTotal = DB::table('registrations48')
                    ->join('districts', 'registrations48.district_code', '=', 'districts.code')
                    ->select(
                        'registrations48.district_code',
                        'districts.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'registrations48.district_code',
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
        
        return view('reports.gender-wise-registered-distrct-wise',[
            'configs' => $configs,
            'districtWise' => $districtWise,
            'grandTotal' => $grandTotal,
        ]);
        
    }

    public function genderWiseAllSelectedCandidatesDistrctWise()
    {
        $configs = Config::all();

        $districtWise = DB::table('results48')
                    ->join('districts', 'results48.district_code', '=', 'districts.code')
                    ->select(
                        'results48.district_code',
                        'districts.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'results48.district_code',
                        'districts.name'
                    )
                    ->orderBy('districts.code')
                    ->get();


        $districtWiseTotal = DB::table('results48')
                    ->join('districts', 'results48.district_code', '=', 'districts.code')
                    ->select(
                        'results48.district_code',
                        'districts.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'results48.district_code',
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
        
        return view('reports.gender-wise-selected-distrct-wise',[
            'configs' => $configs,
            'districtWise' => $districtWise,
            'grandTotal' => $grandTotal,
        ]);

    }


    public function genderWiseAllRegisteredCandidatesDistrctWiseDivGroup()
    {
        $configs = Config::all();

        $districtWise = DB::table('registrations48')
                    ->join('districts', 'registrations48.district_code', '=', 'districts.code')
                    ->join('divisions', 'registrations48.division_code', '=', 'divisions.code')
                    ->select(
                        'registrations48.district_code',
                        'districts.name',
                        'registrations48.division_code',
                        'divisions.name as div_name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'registrations48.district_code',
                        'districts.name',
                        'registrations48.division_code',
                        'divisions.name',
                    )
                    ->orderBy('divisions.code')
                    ->orderBy('districts.code')
                    ->get();


        $districtWiseTotal = DB::table('registrations48')
                    ->join('districts', 'registrations48.district_code', '=', 'districts.code')
                    ->join('divisions', 'registrations48.division_code', '=', 'divisions.code')
                    ->select(
                        'registrations48.district_code',
                        'districts.name',
                        'registrations48.division_code',
                        'divisions.name as div_name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'registrations48.district_code',
                        'districts.name',
                        'registrations48.division_code',
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
        
        return view('reports.gender-wise-registered-distrct-wise-div-group',[
            'configs' => $configs,
            'districtWise' => $districtWise,
            'grandTotal' => $grandTotal,
        ]);
        
    }


    public function genderWiseAllSelectedCandidatesDistrctWiseDivGroup()
    {
        $configs = Config::all();

        $districtWise = DB::table('results48')
                    ->join('districts', 'results48.district_code', '=', 'districts.code')
                    ->join('divisions', 'results48.division_code', '=', 'divisions.code')
                    ->select(
                        'results48.district_code',
                        'districts.name',
                        'results48.division_code',
                        'divisions.name as div_name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'results48.district_code',
                        'districts.name',
                        'results48.division_code',
                        'divisions.name',
                    )
                    ->orderBy('divisions.code')
                    ->orderBy('districts.code')
                    ->get();


        $districtWiseTotal = DB::table('results48')
                    ->join('districts', 'results48.district_code', '=', 'districts.code')
                    ->join('divisions', 'results48.division_code', '=', 'divisions.code')
                    ->select(
                        'results48.district_code',
                        'districts.name',
                        'results48.division_code',
                        'divisions.name as div_name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'results48.district_code',
                        'districts.name',
                        'results48.division_code',
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
        
        return view('reports.gender-wise-selected-distrct-wise-div-group',[
            'configs' => $configs,
            'districtWise' => $districtWise,
            'grandTotal' => $grandTotal,
        ]);
        
    }


    public function genderWiseAllRegisteredCandidatesDivisionWise()
    {
        $configs = Config::all();

        $divisionWise = DB::table('registrations48')
                    ->join('divisions', 'registrations48.division_code', '=', 'divisions.code')
                    ->select(
                        'registrations48.division_code',
                        'divisions.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'registrations48.division_code',
                        'divisions.name'
                    )
                    ->orderBy('divisions.code')
                    ->get();


        $divisionWiseTotal = DB::table('registrations48')
                    ->join('divisions', 'registrations48.division_code', '=', 'divisions.code')
                    ->select(
                        'registrations48.division_code',
                        'divisions.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN registrations48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'registrations48.division_code',
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
        
        return view('reports.gender-wise-registered-division-wise',[
            'configs' => $configs,
            'divisionWise' => $divisionWise,
            'grandTotal' => $grandTotal,
        ]);
        
    }
    

    public function genderWiseAllSelectedCandidatesDivisionWise()
    {
        $configs = Config::all();

        $divisionWise = DB::table('results48')
                    ->join('divisions', 'results48.division_code', '=', 'divisions.code')
                    ->select(
                        'results48.division_code',
                        'divisions.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'results48.division_code',
                        'divisions.name'
                    )
                    ->orderBy('divisions.code')
                    ->get();


        $divisionWiseTotal = DB::table('results48')
                    ->join('divisions', 'results48.division_code', '=', 'divisions.code')
                    ->select(
                        'results48.division_code',
                        'divisions.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'results48.division_code',
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
        
        return view('reports.gender-wise-selected-division-wise',[
            'configs' => $configs,
            'divisionWise' => $divisionWise,
            'grandTotal' => $grandTotal,
        ]);

    }

    public function genderWiseAllSelectedCandidatesInstituteWise()
    {
        $configs = Config::all();

        $institutesWise = DB::table('results48')
                    ->join('institutes', 'results48.g_inst_code', '=', 'institutes.code')
                    ->select(
                        'results48.g_inst_code',
                        'institutes.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'results48.g_inst_code',
                        'institutes.name'
                    )
                    ->orderBy('total', 'DESC')
                    ->get();


        $institutesWiseTotal = DB::table('results48')
                    ->join('institutes', 'results48.g_inst_code', '=', 'institutes.code')
                    ->select(
                        'results48.g_inst_code',
                        'institutes.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->groupBy(
                        'results48.g_inst_code',
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
        
        return view('reports.gender-wise-selected-institute-wise',[
            'configs' => $configs,
            'institutesWise' => $institutesWise,
            'grandTotal' => $grandTotal,
        ]);

    }

    public function genderWiseAllSelectedCandidatesOthersInstituteWise()
    {
        $configs = Config::all();

        $institutesWise = DB::table('results48')
                    ->join('institutes', 'results48.g_inst_code', '=', 'institutes.code')
                    ->select(
                        'results48.g_inst_code',
                        'results48.g_inst_name',
                        'institutes.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->where('g_inst_code', 999)
                    ->groupBy(
                        'results48.g_inst_code',
                        'results48.g_inst_name',
                        'institutes.name'
                    )
                    ->orderBy('total', 'DESC')
                    ->get();


        $institutesWiseTotal = DB::table('results48')
                    ->join('institutes', 'results48.g_inst_code', '=', 'institutes.code')
                    ->select(
                        'results48.g_inst_code',
                        'results48.g_inst_name',
                        'institutes.name',
                        DB::raw('COUNT(*) as total'),
                        DB::raw("SUM(CASE WHEN results48.gender = 1 THEN 1 ELSE 0 END) as total_male"),
                        DB::raw("SUM(CASE WHEN results48.gender = 2 THEN 1 ELSE 0 END) as total_female"),
                        DB::raw("SUM(CASE WHEN results48.gender = 3 THEN 1 ELSE 0 END) as total_third_gender")
                    )
                    ->where('g_inst_code', 999)
                    ->groupBy(
                        'results48.g_inst_code',
                        'results48.g_inst_name',
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
        
        return view('reports.gender-wise-selected-others-institute-wise',[
            'configs' => $configs,
            'institutesWise' => $institutesWise,
            'grandTotal' => $grandTotal,
        ]);

    }

    public function ageWiseAllRegisteredCandidates()
    {
        $configs = Config::all();

        $ageWise = DB::table(DB::raw("
                        (
                            SELECT
                                *,
                                TIMESTAMPDIFF(YEAR, dob, '2025-05-01') AS age
                            FROM registrations48
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
        
        return view('reports.age-wise-registered',[
            'configs' => $configs,
            'ageWise' => $ageWise,
        ]);
        
    }


    public function ageWiseAllSelectedCandidates()
    {
        $configs = Config::all();

        $ageWise = DB::table(DB::raw("
                        (
                            SELECT
                                *,
                                TIMESTAMPDIFF(YEAR, dob, '2025-05-01') AS age
                            FROM results48
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
        
        return view('reports.age-wise-selected',[
            'configs' => $configs,
            'ageWise' => $ageWise,
        ]);
        
    }

}
