<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use App\Http\Services\GetCalender;

class CalenderController extends Controller
{
    public function index(GetCalender $getCalender){
        $calender = $getCalender->execute();
        $workingHours = $calender->working_hours;

        Log::debug(json_encode($calender));

        return view('calender', [
            'start_hour' => explode(':', $workingHours->start)[0],
            'end_hour' => explode(':', $workingHours->end)[0],
            'meetings' => $calender->meetings,
            'week' =>  array( "日", "月", "火", "水", "木", "金", "土")
        ]);
    }
}
