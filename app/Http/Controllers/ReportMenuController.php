<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;

class ReportMenuController extends Controller
{
    
    public function index()
    {
        $configs = Config::all();

        return view('dashboard', [
            'configs' => $configs,
        ]);
    }

}
