<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
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

            $query = Transaction::with('payment','detail')->orderBy('id','desc')->get();

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                $action = '-';

                if($data->status == 'PENDING')
                {

                        $action = '<a href="'.route('admin.transaction.show',$data->id).'" class="btn btn-info mb-1">Detail</a>
                        
                        <button class="btn btn-success btn--process ms-1 mb-1" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#ModalProcess">Proses</button>

                        <button class="btn btn-danger btn--reject ms-1" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#ModalReject">Tolak</button>';

                }elseif($data->status == 'PROCESS')
                {
                    $action = '<a href="'.route('admin.transaction.show',$data->id).'" class="btn btn-info">Detail</a>
                    <button class="btn btn-success btn--delivered ms-1 mb-1" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#ModalDelivered">Kirim</button>';
                }elseif($data->status != 'PENDING' && $data->status != 'PROCESS')
                {
                    $action = '<a href="'.route('admin.transaction.show',$data->id).'" class="btn btn-info">Detail</a>';
                }

              return $action;
            })
            ->addColumn('payment_method', function($data){
                return $data->payment->name;
            })
            ->editColumn('total', function($data){
                return 'Rp'.number_format($data->total,0,',','.');
            })
            ->editColumn('shipping_cost', function($data){
                return 'Rp'.number_format($data->shipping_cost,0,',','.');
            })
            ->editColumn('created_at', function($data){
                return date('d M Y H:i',strtotime($data->created_at));
            })
            ->editColumn('status', function($data){
                $status = 'bg-secondary';
                $status_name = 'Tidak diketahui';
                if($data->status == 'PENDING')
                {
                    $status = 'bg-warning';
                    $status_name = 'Menunggu di proses';

                }elseif($data->status == 'PROCESS')
                {
                    $status = 'bg-info';
                    $status_name = 'Diproses';
                }elseif($data->status == 'DELIVERED')
                {
                    $status = 'bg-success';
                    $status_name = 'Dikirim';
                }elseif($data->status == 'RECEIVED')
                {
                    $status = 'bg-success';
                    $status_name = 'Diterima';
                }elseif($data->status == 'SUCCESS')
                {
                    $status = 'bg-success';
                    $status_name = 'Selesai';
                }elseif($data->status == 'CANCEL')
                {
                    $status = 'bg-danger';
                    $status_name = 'Dibatalkan';
                }elseif($data->status == 'REJECTED')
                {
                    $status = 'bg-danger';
                    $status_name = 'Ditolak';
                }
                return '<span class="badge '.$status.'">'.$status_name.'</span>';
            })
    
            ->rawColumns(['action','status'])
            ->make();

        }else{

            return view('admin.transaction.index');   

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
            $transaction = Transaction::find($id);
            $data['detail'] = $transaction;
            return view('admin.transaction.detail',$data);
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

    public function process(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\Transaction,id'
        ]);

        try {
            $transaction = Transaction::find($request->id);
            if($transaction->status == 'PENDING')
            {
                $transaction->update([
                    'status' => "PROCESS"
                ]);
                return redirect()->route('admin.transaction.index')->with('success','Berhasil memproses pesanan');
            }
            return redirect()->route('admin.transaction.index')->withErrors(['error' => 'Tidak dapat memproses pesanan']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.transaction.index')->withErrors(['error' => 'Gagal memproses pesanan']);
        }
    }

    public function delivered(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\Transaction,id'
        ]);

        try {
            $transaction = Transaction::find($request->id);
            if($transaction->status == 'PROCESS')
            {
                $transaction->update([
                    'status' => "DELIVERED"
                ]);
                return redirect()->route('admin.transaction.index')->with('success','Berhasil mengirim pesanan');
            }
            return redirect()->route('admin.transaction.index')->withErrors(['error' => 'Tidak dapat mengirim pesanan']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.transaction.index')->withErrors(['error' => 'Gagal mengirim pesanan']);
        }
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\Transaction,id'
        ]);

        try {
            $transaction = Transaction::find($request->id);
            if($transaction->status == 'PENDING')
            {
                $transaction->update([
                    'status' => "REJECT"
                ]);
                return redirect()->route('admin.transaction.index')->with('success','Berhasil menolak pesanan');
            }
            return redirect()->route('admin.transaction.index')->withErrors(['error' => 'Tidak dapat menolak pesanan']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.transaction.index')->withErrors(['error' => 'Gagal menolak pesanan']);
        }
    }
}
