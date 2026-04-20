<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        $notification = $user->unreadNotifications->where('id', $id)->first();
       if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }
}
