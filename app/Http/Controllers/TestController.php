<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class TestController extends Controller
{
    public function log() {
        activity()->log('Look mum, I logged something');
    }

    public function checklog() {
        $lastActivity = Activity::all()->last();
        dd($lastActivity);
    }
}
