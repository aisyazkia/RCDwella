<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {

            $query = Schedule::with('detail')->get();

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              return '
                <a href="' . route('admin.schedule.edit', $data->id) . '" class="btn btn-sm btn-primary">
                  Ubah
                </a>
                <form class="d-inline-block" action="' . route('admin.schedule.destroy', $data->id) . '" method="POST">
                <button class="btn btn-sm btn-danger" onClick="return confirm(`Yakin akan dihapus?`) ">
                  Hapus
                </button>
                  ' . method_field('delete') . csrf_field() . '
                </form>
              ';
            })
            ->editColumn('day', function($data){
                return getDayIndo($data->day);
            })
            ->editColumn('time', function($data){
                return $data->detail->pluck('time')->toArray();
            })
    
            ->rawColumns(['action'])
            ->make();

        }else{

            return view('admin.schedule.index');   

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|numeric|unique:App\Models\Schedule,day',
            'time' => 'required|array',
            'time.*' => 'required|date_format:H:i'
        ]);

        $sv = Schedule::create([
            'day' => $request->day
        ]);
        if($sv)
        {
            $schedule_id = $sv->id;
            $times = [];
            foreach($request->input('time') as $time){
                $times[] = [
                    'schedule_id' => $schedule_id,
                    'time' => $time
                ];
            }
            ScheduleDetail::insert($times);

            return redirect()->route('admin.schedule.index')->with('success','Berhasil menambah jadwal praktik');

        }

        return redirect()->route('admin.schedule.create')->withErrors(['error' => 'Gagal menambah jadwal praktik']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        return view('admin.schedule.edit',['detail' => $schedule]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'day' => 'required|numeric',
            'time' => 'required|array',
            'time.*' => 'required|date_format:H:i'
        ]);

        if($request->day != $schedule->day)
        {
            $request->validate([
                'day' => 'unique:App\Models\Schedule,day'
            ]);
        }

        $sv = $schedule->update([
            'day' => $request->day
        ]);
        if($sv)
        {
            ScheduleDetail::where('schedule_id',$schedule->id)->delete();
            $times = [];
            foreach($request->input('time') as $time){
                $times[] = [
                    'schedule_id' => $schedule->id,
                    'time' => $time
                ];
            }
            ScheduleDetail::insert($times);

            return redirect()->route('admin.schedule.index')->with('success','Berhasil mengubah jadwal praktik');

        }

        return redirect()->route('admin.schedule.edit', $schedule->id)->withErrors(['error' => 'Gagal mengubah jadwal praktik']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedule.index')->with('success','Berhasil menghapus shc$schedule');
    }
}
