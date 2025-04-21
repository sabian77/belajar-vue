<?php

namespace App\Http\Controllers\Api;

//import model Division
use App\Models\Division;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

//import resource ProductResource
use App\Http\Resources\DivisiResource;

class DivisiController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all divisi
        $divisi = Division::latest()->paginate(5);

        //return collection of products as a resource
        return new DivisiResource(true, 'List Data Divisi', $divisi);
    }

    public function show($id)
    {
        $divisi = Division::find($id);

        if (!$divisi) {
            return response()->json([
                'success' => false,
                'message' => 'Data Divisi Tidak Ditemukan!',
            ], 404);
        }

        return new DivisiResource(true, 'Detail Data Divisi!', $divisi);   
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'deskripsi' => 'required',
        ]);

           //check if validation fails
           if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //create product
        $divisi = Division::create([
            'name'         => $request->name,
            'deskripsi'   => $request->deskripsi,
        ]);

        //return response
        return new DivisiResource(true, 'Data Divisi Berhasil Ditambahkan!', $divisi);
    }
    public function update(Request $request, $id)
    {
        // Find the division first
        $divisi = Division::find($id);
    
        if (!$divisi) {
            return response()->json([
                'success' => false,
                'message' => 'Data Divisi Tidak Ditemukan!',
            ], 404);
        }
    
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'deskripsi' => 'required',
        ]);
    
        // Check validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Update division
        $divisi->update([
            'name'      => $request->name,
            'deskripsi' => $request->deskripsi,
        ]);
    
        return new DivisiResource(true, 'Data Divisi Berhasil Diubah!', $divisi);
    }

    public function destroy($id)
    {

        //find product by ID
        $divisi = Division::find($id);



        //delete product
        $divisi->delete();

        //return response
        return new DivisiResource(true, 'Data Divisi Berhasil Dihapus!', null);
    }
}

