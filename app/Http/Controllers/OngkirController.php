<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Courier;
use App\Models\Province;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class OngkirController extends Controller
{
    // public function index(Request $request){
    //     if($request->origin && $request->destination && $request->weight && $request->courier){
    //         $origin = 115; //Default dari depok
    //         $destination = $request->city_destination; //Id Kota //kabupaten tujuan
    //         $weight = 500; // berat barang dalam gram sample 100
    //         $courier = 'jne';  // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
    //     }
    //     else{
    //         $origin = 115;
    //         $destination = '';
    //         $weight = 500;
    //         $courier = 'jne';
    //     }

    //     $response = Http::asForm()->withHeaders([
    //         'key' => '457ddfca8b980dc70aa6304068efec11'
    //     ])->post('https://api.rajaongkir.com/starter/cost',[
    //         'origin' => $origin, 
    //         'destination' => $destination, 
    //         'weight' => $weight, 
    //         'courier' => $courier
    //     ]);

    //     $cekongkir = $response['rajaongkir']['results'][0];
    //     $provinsi = Province::all();
    //     return view('ongkir', compact('provinsi', 'cekongkir'));
    // }
    
    // public function ajax($id){
    //     $cities = City::where('province_id', $id)->pluck('titlle', 'city_id');
    //     return json_encode($cities);

    // }
    public function index(){
        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::pluck('title', 'province_id');
        return view('ongkir', compact('couriers', 'provinces'));
    }

    public function getCities($id){
        $city = City::where('province_id', $id)->pluck('title', 'city_id');
        return json_encode($city);
    }

    public function submit(Request $request){
        $cost =  RajaOngkir::ongkosKirim([
            'origin' => 115, //Default dari depok
            'destination' => $request->city_destination, //Id Kota //kabupaten tujuan
            'weight' => 100, // berat barang dalam gram sample 100
            'courier' => 'jne', // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        // dd($cost);

        return $cost[0]['costs'][1]['cost'][0]['value'];


        // $cekongkir = $cost[0]['costs'][2]['cost'][0]['value'];
        // return view('ongkir', compact('cekongkir'));


    }
}
