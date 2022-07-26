<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $data['carts'] = Cart::where(['user_id' => auth()->id()])->with('product')->get();
        $cart = Cart::where(['user_id' => auth()->id()])->get();
        $subtotal = 0;
        foreach($cart as $key){
            $subtotal += ($key->product->price*$key->qty);
        }
        $data['subtotal'] = $subtotal;
        return view('user.cart',$data);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'id' => 'required|exists:App\Models\Product,id'
        ]);

        $findCart = Cart::where(['user_id' => $user->id,'product_id' => $request->id]);
        
        if($row = $findCart->first())
        {

            $up = $findCart->update([
                'qty' => $row->qty+1
            ]);

            return redirect()->route('user.cart.index')->with('success','Berhasil menambahkan ke keranjang');

        }

        $sv = Cart::create([
            'user_id' => $user->id,
            'product_id' => $request->id,
            'qty' => 1
        ]);

        if($sv)
        {

            return redirect()->route('user.cart.index')->with('success','Berhasil menambahkan ke keranjang');

        }

        return redirect()->back()->withErrors(['error' => 'Gagal menambahkan ke keranjang']);

    }

    public function update(Request $request,Cart $cart)
    {

        $request->validate([
            'qty' => 'required|numeric'
        ]);

        $cekProdukStock = Product::find($cart->product_id);

        if($cekProdukStock->stock < $request->qty)
        {
            return redirect()->back()->withErrors(['error' => "Jumlah melebihi stok produk yaitu $cekProdukStock->stock"]);
        }

        $cart->update([
            'qty' => $request->qty
        ]);

        return redirect()->back()->with('success','Berhasil mengubah keranjang');

    }

    public function destroy(Request $request,Cart $cart)
    {
        $cart->delete();

        return redirect()->back()->with('success','Berhasil menghapus keranjang');

    }
}
