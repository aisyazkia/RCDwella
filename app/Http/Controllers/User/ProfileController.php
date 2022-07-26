<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ScheduleBooked;
use App\Models\ScheduleBookedTestimony;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user'] = auth()->user();
        $data['schedule_booked'] = ScheduleBooked::where(['user_id' => $data['user']->id])->orderBy('id','desc')->get();
        $data['transaction'] = Transaction::where('user_id',$data['user']->id)->orderBy('id','desc')->get();
        return view('user.profile',$data);
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
        $user = User::find($id);
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric'
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->route('user.profile.index')->with('success','Berhasil mengubah profil');

    }

    public function update_image(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'image' => 'required|image|mimes:png,jpg'
        ]);

        $path = $request->file('image')->store('public/img-usr');
        if($path)
        {
            $up = User::find($user->id)->update([
                'image' => Storage::url($path)
            ]);
            return redirect()->route('user.profile.index')->with('success','Berhasil mengubah foto profil');
        }

        return redirect()->route('user.profile.index')->withErrors(['error' => 'Gagal mengubah foto profil']);

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

    public function book_payment_proof(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\ScheduleBooked,id',
            'payment_proof' => 'required|image|mimes:png,jpg'
        ]);

        $scheduleBooked = ScheduleBooked::find($request->id);

        $file_path = $request->file('payment_proof')->store('public/payment-proof');

        if($file_path)
        {
            $payment_proof_path = Storage::url($file_path);
            $scheduleBooked->update([
                'payment_proof' => $payment_proof_path,
                'payment_proof_status' => 1
            ]);
            return redirect()->route('user.profile.index')->with('success','Berhasil mengupload bukti bayar');
        }

        return redirect()->route('user.profile.index')->with('success','Gagal mengupload bukti bayar');

    }

    public function booked_cancel(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\ScheduleBooked,id'
        ]);
        try {
            $scheduleBooked = ScheduleBooked::find($request->id);
            if($scheduleBooked->status == 'PENDING')
            {
                $scheduleBooked->update([
                    'status' => "CANCEL"
                ]);
                return redirect()->route('user.profile.index')->with('success','Berhasil membatalkan janji');
            }
            return redirect()->route('user.profile.index')->with('success','Tidak dapat membatalkan janji');
        } catch (\Throwable $th) {
            return redirect()->route('user.profile.index')->with('success','Gagal membatalkan janji');
        }
        
    }
    
    public function booked_done(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\ScheduleBooked,id',
            'rating' => 'required|max:5',
            'comment' => 'required'
        ]);
        try {
            $scheduleBooked = ScheduleBooked::find($request->id);
            if($scheduleBooked->status == 'APPROVE')
            {
                $scheduleBooked->update([
                    'status' => "SUCCESS"
                ]);

                ScheduleBookedTestimony::create([
                    'schedule_booked_id' => $request->id,
                    'user_id' => auth()->id(),
                    'rating' => $request->rating,
                    'comment' => $request->comment
                ]);

                return redirect()->route('user.profile.index')->with('success','Berhasil menyelesaikan janji');
            }
            return redirect()->route('user.profile.index')->withErrors(['error' => 'Tidak dapat menyelesaikan janji']);
        } catch (\Throwable $th) {
            return redirect()->route('user.profile.index')->withErrors(['error' => 'Gagal menyelesaikan janji']);
        }
        
    }

    public function booked_detail(Request $request, $id)
    {
        try {
            $scheduleBooked = ScheduleBooked::find($id);
            $data['detail'] = $scheduleBooked;
            return view('user.schedule-booked-detail',$data);
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function transaction_cancel(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\Transaction,id'
        ]);
        try {
            $transaction = Transaction::find($request->id);
            if($transaction->status == 'PENDING')
            {
                $transaction->update([
                    'status' => "CANCEL"
                ]);
                return redirect()->route('user.profile.index')->with('success','Berhasil membatalkan pesanan');
            }
            return redirect()->route('user.profile.index')->with('success','Tidak dapat membatalkan pesanan');
        } catch (\Throwable $th) {
            return redirect()->route('user.profile.index')->with('success','Gagal membatalkan pesanan');
        }
        
    }

    public function transaction_received(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\Transaction,id'
        ]);
        try {
            $transaction = Transaction::find($request->id);
            if($transaction->status == 'DELIVERED')
            {
                $transaction->update([
                    'status' => "RECEIVED"
                ]);
                return redirect()->route('user.profile.index')->with('success','Berhasil menerima pesanan');
            }
            return redirect()->route('user.profile.index')->with('success','Tidak dapat menerima pesanan');
        } catch (\Throwable $th) {
            return redirect()->route('user.profile.index')->with('success','Gagal menerima pesanan');
        }
        
    }
    
    public function transaction_done(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:App\Models\Transaction,id'
        ]);
        try {
            $transaction = Transaction::find($request->id);
            if($transaction->status == 'RECEIVED')
            {
                $transaction->update([
                    'status' => "SUCCESS"
                ]);
                return redirect()->route('user.profile.index')->with('success','Berhasil menyelesaikan pesanan');
            }
            return redirect()->route('user.profile.index')->with('success','Tidak dapat menyelesaikan pesanan');
        } catch (\Throwable $th) {
            return redirect()->route('user.profile.index')->with('success','Gagal menyelesaikan pesanan');
        }
        
    }

    public function transaction_detail(Request $request, $id)
    {
        try {
            $transaction = Transaction::find($id);
            $data['detail'] = $transaction;
            return view('user.transaction-detail',$data);
        } catch (\Throwable $th) {
            abort(404);
        }
    }
}
