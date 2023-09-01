<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Reply;
use App\Model\Settings;
use App\Model\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $settings=Settings::first();
        $messages_sent_today=(Sms::whereDate('created_at', Carbon::today())->where('is_received',0)->withTrashed()->count())+(Reply::where('system_reply',1)->whereDate('created_at', Carbon::today())->withTrashed()->count());
        $messages_received_today=(Sms::whereDate('created_at', Carbon::today())->where('is_received',1)->withTrashed()->count())+(Reply::where('system_reply',0)->whereDate('created_at', Carbon::today())->withTrashed()->count());
        $total_sent_lifetime=(Sms::where('is_received',0)->withTrashed()->count())+(Reply::where('system_reply',1)->withTrashed()->count());
        $total_received_lifetime=(Sms::where('is_received',1)->withTrashed()->count())+(Reply::where('system_reply',0)->withTrashed()->count());


//        $messages_sent_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',0)->withTrashed()->count())+(Reply::where('system_reply',1)->whereDate('created_at', Carbon::today())->withTrashed()->count());
//        $messages_received_week=(Sms::whereDate('created_at', Carbon::today())->where('is_received',1)->withTrashed()->count())+(Reply::where('system_reply',0)->whereDate('created_at', Carbon::today())->withTrashed()->count());




        return view('back.index',compact('total_sent_lifetime','total_received_lifetime','messages_sent_today','messages_received_today',"settings"));
    }
}
