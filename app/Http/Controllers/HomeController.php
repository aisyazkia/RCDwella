<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Schedule;
use App\Models\ScheduleBookedTestimony;
use App\Models\ScheduleDetail;
use App\Models\Treatment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['treatments'] = Treatment::all();
        $data['testimony'] = ScheduleBookedTestimony::all();
        return view('home',$data);
    }

    public function schedule()
    {
        $data['schedule'] = Schedule::all();
        $data['schedule_detail'] = ScheduleDetail::select('time')->groupBy('time')->orderBy('time','asc')->get();
        return view('schedule',$data);
    }
    
    public function product()
    {
        $data['product'] = Product::all();
        return view('product',$data);
    }

    public function schedule_order()
    {
        $data['schedule'] = Schedule::all();
        $data['treatments'] = Treatment::all();
        $data['schedule_detail'] = ScheduleDetail::select('time')->groupBy('time')->orderBy('time','asc')->get();
        return view('user.schedule-order',$data);
    }
}
