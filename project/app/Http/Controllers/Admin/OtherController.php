<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;

class OtherController extends Controller
{
    public function getAjax($id)
    {
        $states = State::where('country_id',$id)->get();
        if($states->count() > 0){
            return response()->json(['data' => $states]);
        }
        return response()->json(['data' => 0]);
    }

    public function updateState($country_id)
    {
        $states = State::where('country_id',$country_id)->get();
        return response()->json(['data' => $states]);
    }
}
