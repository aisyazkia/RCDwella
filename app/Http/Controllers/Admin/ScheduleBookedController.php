<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MailNotif;
use App\Models\ScheduleBooked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class ScheduleBookedController extends Controller
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

            $query = ScheduleBooked::with('payment','detail')->orderBy('id','desc')->get();

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                $action = '-';

                if($data->status == 'PENDING')
                {

                    if($data->payment->name != 'COD')
                    {

                        $action_bayar = '';
                        if($data->payment_proof_status == '1')
                        {
                            $action_bayar = '<button class="btn btn-secondary btn--payment-proof mb-1" data-id="'.$data->id.'" data-paymentproof="'.url($data->payment_proof).'" data-bs-toggle="modal" data-bs-target="#ModalUploadPaymentProof">Konfirmasi Pembayaran</button>';
                        }elseif($data->payment_proof_status == '2'){
                            $action_bayar = '<button class="btn btn-success btn--approve ms-1 mb-1 me-1" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#ModalApprove">Konfirmasi</button>';
                        }

                        $action = $action_bayar
                        .'<a href="'.route('admin.schedule-booked.show',$data->id).'" class="btn btn-info mb-1">Detail</a><button class="btn btn-danger btn--reject ms-1" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#ModalReject">Tolak</button>';
                    }else{
                        $action = '<a href="'.route('admin.schedule-booked.show',$data->id).'" class="btn btn-info mb-1">Detail</a>
                        
                        <button class="btn btn-success btn--approve ms-1 mb-1" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#ModalApprove">Konfirmasi</button>

                        <button class="btn btn-danger btn--reject ms-1" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#ModalReject">Tolak</button>';
                    }
                }elseif($data->status != 'PENDING')
                {
                    $action = '<a href="'.route('admin.schedule-booked.show',$data->id).'" class="btn btn-info">Detail</a>';
                }

              return $action;
            })
            ->addColumn('payment_method', function($data){
                return $data->payment->name;
            })
            ->editColumn('total', function($data){
                return 'Rp'.number_format($data->total,0,',','.');
            })
            ->editColumn('date', function($data){
                return date('d M Y',strtotime($data->date));
            })
            ->editColumn('time', function($data){
                return date('H:i',strtotime($data->time));
            })
            ->editColumn('status', function($data){
                $status = 'bg-secondary';
                $status_name = 'Tidak diketahui';
                $action = '-';
                if($data->status == 'PENDING')
                {
                    $status = 'bg-warning';
                    $status_name = 'Menunggu Dibayar';
                    
                    if($data->payment_proof_status == '1')
                    {
                        $status = 'bg-info';
                        $status_name = 'Proses pengecekan';
                    }elseif($data->payment_proof_status == '2')
                    {
                        $status = 'bg-success';
                        $status_name = 'Dibayar';
                    }

                }elseif($data->status == 'APPROVE')
                {
                    $status = 'bg-info';
                    $status_name = 'Disetujui';
                }elseif($data->status == 'SUCCESS')
                {
                    $status = 'bg-success';
                    $status_name = 'Selesai';
                }elseif($data->status == 'REJECT')
                {
                    $status = 'bg-danger';
                    $status_name = 'Ditolak';
                }elseif($data->status == 'CANCEL')
                {
                    $status = 'bg-danger';
                    $status_name = 'Dibatalkan';
                }
                return '<span class="badge '.$status.'">'.$status_name.'</span>';
            })
    
            ->rawColumns(['action','status'])
            ->make();

        }else{

            return view('admin.schedule-booked.index');   

        }
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
        try {
            $scheduleBooked = ScheduleBooked::find($id);
            $data['detail'] = $scheduleBooked;
            return view('admin.schedule-booked.detail',$data);
        } catch (\Throwable $th) {
            abort(404);
        }
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

    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\ScheduleBooked,id'
        ]);

        try {
            $scheduleBooked = ScheduleBooked::find($request->id);
            if($scheduleBooked->status == 'PENDING')
            {
                $scheduleBooked->update([
                    'status' => "APPROVE"
                ]);
                Mail::to($scheduleBooked->email)->send(new MailNotif('mail.order-approved',$scheduleBooked));
                return redirect()->route('admin.schedule-booked.index')->with('success','Berhasil menyetujui janji');
            }
            return redirect()->route('admin.schedule-booked.index')->withErrors(['error' => 'Tidak dapat menyetujui janji']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.schedule-booked.index')->withErrors(['error' => 'Gagal menyetujui janji']);
        }
    }
    
    public function payment_confirm(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\ScheduleBooked,id'
        ]);

        try {
            $scheduleBooked = ScheduleBooked::find($request->id);
            if($scheduleBooked->status == 'PENDING')
            {
                $scheduleBooked->update([
                    'payment_proof_status' => 2
                ]);
                return redirect()->route('admin.schedule-booked.index')->with('success','Berhasil mengkonfirmasi pembayaran');
            }
            return redirect()->route('admin.schedule-booked.index')->withErrors(['error' => 'Tidak dapat mengkonfirmasi pembayaran']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.schedule-booked.index')->withErrors(['error' => 'Gagal mengkonfirmasi pembayaran']);
        }
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\ScheduleBooked,id'
        ]);

        try {
            $scheduleBooked = ScheduleBooked::find($request->id);
            if($scheduleBooked->status == 'PENDING')
            {
                $scheduleBooked->update([
                    'status' => "REJECT"
                ]);
                return redirect()->route('admin.schedule-booked.index')->with('success','Berhasil menolak janji');
            }
            return redirect()->route('admin.schedule-booked.index')->withErrors(['error' => 'Tidak dapat menolak janji']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.schedule-booked.index')->withErrors(['error' => 'Gagal menolak janji']);
        }
    }
}
