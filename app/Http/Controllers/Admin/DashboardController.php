<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduleBooked;
use App\Models\Transaction;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user_count'] = User::count();
        $data['treatment_count'] = Treatment::count();
        $data['transaction_count'] = Transaction::count();
        $data['treatment_total'] = ScheduleBooked::where('status','SUCCESS')->sum('total');
        $data['product_total'] = Transaction::where('status','SUCCESS')->sum('total');

        $treatment_graph = [];

        for($m=1;$m<=12;$m++){
            $total = ScheduleBooked::whereMonth('created_at',$m)->whereYear('created_at',date('Y'))->where('status','SUCCESS')->sum('total');
            $treatment_graph[] = $total;
        }
        
        $product_graph = [];

        for($m=1;$m<=12;$m++){
            $total = Transaction::whereMonth('created_at',$m)->whereYear('created_at',date('Y'))->where('status','SUCCESS')->sum('total');
            $product_graph[] = $total;
        }

        $data['treatment_graph'] = $treatment_graph;
        $data['product_graph'] = $product_graph;
        return view('admin.dashboard',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
