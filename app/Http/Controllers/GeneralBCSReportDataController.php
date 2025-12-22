<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;

class GeneralBCSReportDataController extends Controller
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
        
        return view('reports-general-bcs.gender-wise-registered',[
            'configs' => $configs,
            'total' => $total,
            'male' => $male,
            'female' => $female,
            'tgender' => $tgender,
        ]);
    }


}
