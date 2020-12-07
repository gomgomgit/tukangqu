<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function store(Request $request) {
        Notification::create($request->all());

        return true;
    }

    public function getNotification() {
        $notifications = Notification::all();

        return $notifications;
    }

    public function deleteNotification($id) {
        Notification::find($id)->delete();

        return true;
    }

    public function deleteAllNotification() {
        Notification::truncate();

        return true;
    }
}
