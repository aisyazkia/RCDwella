<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class TreatmentController extends Controller
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

            $query = Treatment::get();

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              return '
                <a href="' . route('admin.treatment.edit', $data->id) . '" class="btn btn-sm btn-primary">
                  Ubah
                </a>
                <form class="d-inline-block" action="' . route('admin.treatment.destroy', $data->id) . '" method="POST">
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
            ->editColumn('name', function($data){
                return $data->name;
            })
    
            ->rawColumns(['action'])
            ->make();

        }else{

            return view('admin.treatment.index');   

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.treatment.create');
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
            'price' => 'numeric',
            'image' => 'required|image|mimes:jpg,png,jpeg',
        ]);

        $path = $request->file('image')->store('public/img-treatment');
        if($path)
        {
            $image = Storage::url($path);

            $sv = Treatment::create([
                'image' => $image,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);
            if($sv)
            {

                return redirect()->route('admin.treatment.index')->with('success','Berhasil menambah treatment');

            }

            return redirect()->route('admin.treatment.create')->withErrors(['error' => 'Gagal menambah treatment']);
            
        }

        return redirect()->route('admin.treatment.create')->withErrors(['error' => 'Gagal mengupload gambar']);

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
    public function edit(Treatment $treatment)
    {
        return view('admin.treatment.edit',['detail' => $treatment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treatment $treatment)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);

        $image = $treatment->image;

        if($request->file('image'))
        {
            $path = $request->file('image')->store('public/img-treatment');
            if($path){
                $image = Storage::url($path);
            }else{
                return redirect()->route('admin.treatment.create')->withErrors(['error' => 'Gagal mengupload gambar']);
            }
        }

        $sv = $treatment->update([
            'image' => $image,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        if($sv)
        {

            return redirect()->route('admin.treatment.index')->with('success','Berhasil mengubah treatment');

        }

        return redirect()->route('admin.treatment.create')->withErrors(['error' => 'Gagal mengubah treatment']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Treatment $treatment)
    {
        $treatment->delete();
        return redirect()->route('admin.treatment.index')->with('success','Berhasil menghapus treatment');
    }

    private function generateSlug($name)
    {
        $model = new Treatment;
        $cek = $model->where('name',$name);
        if($total = $cek->count())
        {
            return Str::slug($name).'-'.$total;
        }
        return Str::slug($name);
    }
}
