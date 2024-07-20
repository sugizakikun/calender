<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GetCalender;

class CalenderController extends Controller
{
    public function index(GetCalender $getCalender){
        $calender = $getCalender->execute();
        $workingHours = $calender->working_hours;

        return view('calender', [
            'start_hour' => explode(':', $workingHours->start)[0],
            'end_hour' => explode(':', $workingHours->end)[0],
            'meetings' => $calender->meetings,
            'week' =>  array( "日", "月", "火", "水", "木", "金", "土")
        ]);
    }
}
