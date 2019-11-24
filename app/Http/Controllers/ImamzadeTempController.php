<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImamzadeTempController extends Controller
{
    public function index_imamzadetemp()
    {
        $result = \Illuminate\Support\Facades\DB::table('imamzade_temps')
            ->join('cities', 'cities.Cid', '=', 'imamzade_temps.CID')
            ->join('provinces', 'provinces.Pid', '=', 'imamzade_temps.PID')->get();
        $return = array('imamzade_temps' => $result);
        return $return;
    }
    public function store_imamzadetemp(Request $request)
    {
        $imamzade= \App\imamzade_temp::create($request->all());
        return response()->json($imamzade , 201);
    }
}
