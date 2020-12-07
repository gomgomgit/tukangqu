<?php

namespace App\Http\Controllers;

use App\Models\ContractProject;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class SurveyNotificationController extends Controller
{

    public function surveynotify()
    {
        $now = Carbon::now();

        $schedules = ContractProject::where('process', 'scheduled')
                ->where('survey_date', $now->format('yy-m-d'))
                ->whereTime('survey_time', '=',  $now->addHour()->format('H:i').':00')
                ->get();

        foreach ($schedules as $schedule) {
            
            $options = array(
                            'cluster' => env('PUSHER_APP_CLUSTER'),
                            'encrypted' => true
                            );
            $pusher = new Pusher(
                                env('PUSHER_APP_KEY'),
                                env('PUSHER_APP_SECRET'),
                                env('PUSHER_APP_ID'), 
                                $options
                            );
    
            $data['title'] = 'Survei 1 Jam Lagi!';
            $data['message'] = 'Survei jam ' . Carbon::createFromFormat('H:i:s', $schedule->survey_time)->format('H:i') . ' oleh ' . $schedule->surveyer->name;
            
            Notification::create([
                'title' => $data['title'],
                'message' => $data['message'],
            ]);

            $pusher->trigger('survey-notify-channel', 'App\\Events\\SurveyNotify', $data);

        }

    }

    public function surveydaynotify()
    {
        $now = Carbon::now();

        $schedules = ContractProject::where('process', 'scheduled')
                ->where('survey_date', $now->format('yy-m-d'))
                ->get();

        // foreach ($schedules as $schedule) {
            
            $options = array(
                            'cluster' => env('PUSHER_APP_CLUSTER'),
                            'encrypted' => true
                            );
            $pusher = new Pusher(
                                env('PUSHER_APP_KEY'),
                                env('PUSHER_APP_SECRET'),
                                env('PUSHER_APP_ID'), 
                                $options
                            );
    
            $data['title'] = $schedules->count() . ' Jadwal Survei Hari ini';
            $data['message'] = 'Cek jadwal survei sekarang';

            Notification::create([
                'title' => $data['title'],
                'message' => $data['message'],
            ]);

            $pusher->trigger('survey-notify-channel', 'App\\Events\\SurveyNotify', $data);

        // }

    }
}
