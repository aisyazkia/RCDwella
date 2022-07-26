<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
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

            $query = Product::get();

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              return '
                <a href="' . route('admin.product.edit', $data->id) . '" class="btn btn-sm btn-primary">
                  Ubah
                </a>
                <form class="d-inline-block" action="' . route('admin.product.destroy', $data->id) . '" method="POST">
                <button class="btn btn-sm btn-danger" onClick="return confirm(`Yakin akan dihapus?`) ">
                  Hapus
                </button>
                  ' . method_field('delete') . csrf_field() . '
                </form>
              ';
            })
            ->editColumn('price', function($data){
                return 'Rp '.number_format($data->price,0,',','.');
            })
    
            ->rawColumns(['action'])
            ->make();

        }else{

            return view('admin.product.index');   

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
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
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);

        if($request->file('image'))
        {
            $path = $request->file('image')->store('public/img-product');
            if($path)
            {
                $image = Storage::url($path);

                $sv = Product::create([
                    'image' => $image,
                    'name' => $request->name,
                    'slug' => $this->generateSlug($request->name),
                    'description' => $request->description,
                    'price' => $request->price,
                    'stock' => $request->stock,
                ]);
                if($sv)
                {

                    return redirect()->route('admin.product.index')->with('success','Berhasil menambah produk');

                }

                return redirect()->route('admin.product.create')->withErrors(['error' => 'Gagal menambah produk']);
                
            }
        }

        return redirect()->route('admin.product.create')->withErrors(['error' => 'Gagal mengupload gambar']);

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
    public function edit(Product $product)
    {
        return view('admin.product.edit',['detail' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);

        $image = $product->image;

        if($request->file('image'))
        {
            $path = $request->file('image')->store('public/img-product');
            if($path){
                $image = Storage::url($path);
            }else{
                return redirect()->route('admin.product.create')->withErrors(['error' => 'Gagal mengupload gambar']);
            }
        }

        $slug = $request->name != $product->name? $this->generateSlug($request->name) : $product->slug;

        $sv = $product->update([
            'image' => $image,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
        if($sv)
        {

            return redirect()->route('admin.product.index')->with('success','Berhasil mengubah produk');

        }

        return redirect()->route('admin.product.create')->withErrors(['error' => 'Gagal mengubah produk']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index')->with('success','Berhasil menghapus produk');
    }

    private function generateSlug($name)
    {
        $model = new Product;
        $cek = $model->where('name',$name);
        if($total = $cek->count())
        {
            return Str::slug($name).'-'.$total;
        }
        return Str::slug($name);
    }
}
