<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GetCalender;

class CalenderController extends Controller
{
    public function index(GetCalender $getCalender){
        $calender = $getCalender->execute();

        return view('calender', [
            'working_hours' => $calender->working_hours,
            'meetings' => $calender->meetings
        ]);
    }
}
