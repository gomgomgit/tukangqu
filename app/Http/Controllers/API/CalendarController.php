<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContractProject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function eventCalendar() {
        $contractProject = ContractProject::whereNotNull('survey_date')->get(['survey_date', 'survey_time', 'surveyer_id']);

        $survey_calendar = collect($contractProject)->map(function($contractProject, $key){
            $collect = (object)$contractProject;

            $survey = Carbon::create($collect->survey_date . ' ' . $collect->survey_time)->format('c');
            return [
                'category' => 'survey',
                'title' => 'Jadwal Survei',
                'start' => $survey,
                'end' => $survey,
                'icon' => 'circle',
                'survey_name' => $collect->surveyer->name,
                'survey_number' => $collect->surveyer->phone_number,
                'survey_time' => $collect->survey_time,
                'description'=> '<p><b>Surveyer :</b> '.$collect->surveyer->name. '</p><p><b>Jam :</b> '.$collect->survey_time.'</p>',
                'className'=>'fc-bg-blue',
                'icon' =>"medkit",
                'allDay'=>false
            ];
        });
        return $survey_calendar;
    }
}
