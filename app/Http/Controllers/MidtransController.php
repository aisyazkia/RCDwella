<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ScheduleBooked;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Str;

class MidtransController extends Controller
{
    public function test(Request $request)
    {
        $prefix = "BOOK-";
        $data = Str::contains($request->id,'BOOK-');
        if($data)
        {
            return response(str_replace($prefix,'',$request->id));
        }
    }

    public function callback()
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $notification = new Notification();

        $bookedPrefix = env('MIDTRANS_TRANSACTION_PREFIX','BOOK-00');

        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        $scheduleBookId = null;

        if(Str::contains($order_id,$bookedPrefix))
        {
            $scheduleBookId = str_replace($bookedPrefix,'',$order_id);
        }

        if($scheduleBookId == null)
        {
            return response([
                'meta' => [
                    'code' => 422,
                    'message' => 'Order Id Not Provided'
                ]
            ]);
        }
        
        $booked = ScheduleBooked::findOrFail($scheduleBookId);

        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $booked->status = "PENDING";
                } else {
                    $booked->payment_proof_status = 2;
                }
            }
        } else if ($status == 'settlement') {
            $booked->payment_proof_status = 2;
        } else if ($status == 'pending') {
            $booked->status = "PENDING";
        } else if ($status == 'deny') {
            $booked->status = "CANCEL";
        } else if ($status == 'expire') {
            $booked->status = "CANCEL";
        } else if ($status == 'cancel') {
            $booked->status = "CANCEL";
        }

        $booked->save();

        return response([
            'meta' => [
                'code' => 200,
                'message' => 'Midtrans Notification Success!'
            ]
        ]);
    }
}
