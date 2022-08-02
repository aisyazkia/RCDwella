<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\MailNotif;
use App\Models\PaymentMethod;
use App\Models\Schedule;
use App\Models\ScheduleBooked;
use App\Models\ScheduleBookedDetail;
use App\Models\ScheduleDetail;
use App\Models\Treatment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;

class ScheduleBookedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user']  = auth()->user();
        $data['schedule'] = Schedule::all();
        $data['treatments'] = Treatment::all();
        $data['schedule_detail'] = ScheduleDetail::select('time')->groupBy('time')->orderBy('time','asc')->get();
        $data['payment_method'] = PaymentMethod::all();
        return view('user.schedule-order',$data);
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
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'email' => 'email|required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'treatment' => 'required|array',
            'treatment.*' => 'required|exists:App\Models\Treatment,id',
            'payment_method' => 'required|exists:App\Models\PaymentMethod,id'
        ]);

        if(strtotime($request->date.' '.$request->time) < strtotime(date('Y-m-d H:i')))
        {
            return redirect()->route('user.schedule-order.index')->withErrors(['error' => 'Jadwal yang dipilih tidak valid'])->withInput();
        }
        
        $cekScheduleExists = Schedule::where('day',date('w',strtotime($request->date)))->whereRelation('detail','time',$request->time)->first();
        if(!$cekScheduleExists)
        {
            return redirect()->route('user.schedule-order.index')->withErrors(['error' => 'Jadwal yang dipilih tidak terdaftar'])->withInput();
        }

        $cekExists = ScheduleBooked::where(['date' => $request->date,'time' => $request->time,])->whereRaw("status != 'REJECT' AND status != 'CANCEL'")->first();
        if($cekExists)
        {
            return redirect()->route('user.schedule-order.index')->withErrors(['error' => 'Jadwal yang dipilih tidak tersedia'])->withInput();
        }

        $total = 0;

        foreach($request->input('treatment') as $treatment){
            $treatmentRow = Treatment::find($treatment);
            $total += $treatmentRow->price;
        }

        $svSchedule = ScheduleBooked::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'date' => $request->date,
            'time' => $request->time,
            'payment_method_id' => $request->payment_method,
            'status' => 'PENDING',
            'total' => $total
        ]);

        if($svSchedule)
        {
            $schedule_booked_id = $svSchedule->id;
            $details = [];
            foreach($request->input('treatment') as $treatment){
                $treatmentRow = Treatment::find($treatment);
                $details[] = [
                    'schedule_booked_id' => $schedule_booked_id,
                    'treatment_id' => $treatmentRow->id,
                    'price' => $treatmentRow->price
                ];
            }

            $sv = ScheduleBookedDetail::insert($details);

            $admin = User::where('level_id',1)->get();
            foreach($admin as $adm){                
                Mail::to($adm->email)->send(new MailNotif('mail.new-order',ScheduleBooked::find($schedule_booked_id)));
            }

            if($request->payment_method != 1)
            {
                Config::$serverKey = config('services.midtrans.serverKey');
                Config::$isProduction = config('services.midtrans.isProduction');
                Config::$isSanitized = config('services.midtrans.isSanitized');
                Config::$is3ds = config('services.midtrans.is3ds');

                $midtransPrefix = env('MIDTRANS_BOOK_PREFIX','BOOK-TRX-0');

                $midtrans = array(
                    'transaction_details' => array(
                        'order_id' =>  $midtransPrefix.$schedule_booked_id,
                        'gross_amount' => (int)$total,
                    ),
                    'customer_details' => array(
                        'first_name'    => $request->name,
                        'email'         => $request->email,
                        'phone'         => $request->phone
                    ),
                    'enabled_payments' => array('bank_transfer'),
                    'vtweb' => array()
                );

                try {

                    $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
        
                    $svSchedule->payment_url = $paymentUrl;
                    $svSchedule->save();
                    
                    return redirect($paymentUrl);

                } catch (Exception $e) {
                    return $e;
                }
            }

            return redirect()->route('user.profile.index')->with('success','Berhasil membuat janji');
            
        }
        
        return redirect()->route('user.profile.index')->withErrors(['error' => 'Gagal membuat janji']);
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
