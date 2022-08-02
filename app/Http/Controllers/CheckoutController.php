<?php

namespace App\Http\Controllers;

use App\Mail\MailNotif;
use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Exception;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user'] = auth()->user();
        $data['payment_method'] = PaymentMethod::all();
        $data['carts'] = Cart::where(['user_id' => auth()->id()])->with('product')->get();
        $cart = Cart::where(['user_id' => auth()->id()])->get();
        $subtotal = 0;
        foreach($cart as $key){
            $subtotal += ($key->product->price*$key->qty);
        }
        $data['subtotal'] = $subtotal;
        return view('user.checkout',$data);
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
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'email' => 'email|required',
            'address' => 'required',
            // 'courier' => 'required',
            'payment_method' => 'required|exists:App\Models\PaymentMethod,id'
        ]);

        $cart_data = Cart::where('user_id',auth()->id());

        if($cart_data->count() == 0)
        {
            return redirect()->route('user.checkout.index')->withErrors(['error' => "Keranjang kosong"]);
        }

        $carts = $cart_data->get();
        $total = 0;
        foreach($carts as $cart)
        {
            $total += ($cart->product->price*$cart->qty);
        }

        // $shipping_cost = 0;
        // if($request->courier == '1')
        // {
        //     $shipping_cost = 0;
        // }elseif($request->courier == '2')
        // {
        //     $shipping_cost = env('SHIPPING_COST',5000);
        // }

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'payment_method_id' => $request->payment_method,
            // 'shipping_cost' => $shipping_cost,
            'status' => 'PENDING',
            'total' => $total
        ]);
        if($transaction)
        {
            $transaction_id = $transaction->id;
            $detail = [];
            foreach($carts as $cart)
            {
                $detail[] = [
                    'transaction_id' => $transaction_id,
                    'product_id' => $cart->product_id,
                    'price' => $cart->product->price,
                    'qty' => $cart->qty,
                    'total' => $cart->product->price*$cart->qty,
                ];
            }

            TransactionDetail::insert($detail);

            $cart_data->delete();

            $admin = User::where('level_id',1)->get();
            foreach($admin as $adm){                
                Mail::to($adm->email)->send(new MailNotif('mail.new-transaction',Transaction::find($transaction_id)));
            }

            if($request->payment_method != 1)
            {
                Config::$serverKey = config('services.midtrans.serverKey');
                Config::$isProduction = config('services.midtrans.isProduction');
                Config::$isSanitized = config('services.midtrans.isSanitized');
                Config::$is3ds = config('services.midtrans.is3ds');

                $midtransPrefix = env('MIDTRANS_TRANSACTION_PREFIX','TRX-0');

                $midtrans = array(
                    'transaction_details' => array(
                        'order_id' =>  $midtransPrefix.$transaction_id,
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
        
                    $transaction->payment_url = $paymentUrl;
                    $transaction->save();
                    
                    return redirect($paymentUrl);

                } catch (Exception $e) {
                    return $e;
                }
            }
            
            
            return redirect()->route('user.profile.index')->with('success','Berhasil melakukan pemesanan');
            
        }
        
        return redirect()->route('user.profile.index')->withErrors(['error' => 'Gagal melakukan pemesanan']);


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
