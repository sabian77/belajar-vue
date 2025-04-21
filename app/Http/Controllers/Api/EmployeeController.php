<?php

namespace App\Http\Controllers\Api;

//import model karyawan
use App\Models\Employe;

use App\Http\Controllers\Controller;

//import resource karyawanResource
use App\Http\Resources\EmployeeResource;
//import Http request
use Illuminate\Http\Request;

//import facade Validator
use Illuminate\Support\Facades\Validator;

//import facades storage
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all karyawans
        $employe = Employe::latest()->paginate(5);

        //return collection of karyawans as a resource
        return new EmployeeResource(true, 'List Data Employee', $employe);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */

    public function show($id)
    {
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json([
                'success' => false,
                'message' => 'Data Employee Tidak Ditemukan!',
            ], 404);
        }

        return new EmployeeResource(true, 'Detail Data Employee!', $employe);   
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'nik'           => 'required|unique:employes',
            'email'         => 'required|email|unique:employes', 
            'phone'         => 'required', 
            'status'        => 'required|in:Aktif,Nonaktif',
            'address'       => 'required', 
            'division_id'   => 'required|exists:divisions,id', 
            'job_id'        => 'required|exists:employee_jobs,id', 
            'foto'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('foto');
        $image->storeAs('public/employee', $image->hashName());

        //create karyawan
        $employe = Employe::create([
            'name'          => $request->name,
            'nik'           => $request->nik,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'status'        => $request->status ?? 'Aktif',
            'address'       => $request->address,
            'division_id'   => $request->division_id,
            'job_id'        => $request->job_id,
            'foto'          => $image->hashName(),
        ]);

        //return response
        return new EmployeeResource(true, 'Data Employee Berhasil Ditambahkan!', $employe);
    }

    public function update(Request $request, $id)
    {
        // Find the employee first
        $employe = Employe::find($id);
    
        if (!$employe) {
            return response()->json([
                'success' => false,
                'message' => 'Data Employee Tidak Ditemukan!',
            ], 404);
        }
    
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'nik'           => 'required|unique:employes,nik,'.$id, // Ignore current record
            'email'         => 'required|email|unique:employes,email,'.$id, // Ignore current record
            'phone'         => 'required', 
            'status'        => 'required|in:Aktif,Nonaktif',
            'address'       => 'required', 
            'division_id'   => 'required|exists:divisions,id', 
            'job_id'        => 'required|exists:employee_jobs,id', 
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Made optional for updates
        ]);
    
        // Check validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Handle image upload
        if ($request->hasFile('foto')) {
            // Delete old image
            if ($employe->foto) {
                Storage::delete('public/employee/' . $employe->foto);
            }
    
            // Upload new image
            $image = $request->file('foto');
            $image->storeAs('public/employee', $image->hashName());
    
            // Update with new image
            $employe->update([
                'name'          => $request->name,
                'nik'           => $request->nik,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'status'        => $request->status,
                'address'       => $request->address,
                'division_id'   => $request->division_id,
                'job_id'        => $request->job_id,
                'foto'          => $image->hashName(),
            ]);
        } else {
            // Update without changing the image
            $employe->update([
                'name'          => $request->name,
                'nik'           => $request->nik,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'status'        => $request->status,
                'address'       => $request->address,
                'division_id'   => $request->division_id,
                'job_id'        => $request->job_id,
            ]);
        }
    
        return new EmployeeResource(true, 'Data Employee Berhasil Diubah!', $employe);
    }

    public function destroy($id)
{
    $employe = Employe::find($id);

    if (!$employe) {
        return response()->json([
            'success' => false,
            'message' => 'Data Employee Tidak Ditemukan!',
        ], 404);
    }

    // Delete image file if exists
    if ($employe->foto) {
        Storage::delete('public/employee/' . $employe->foto);
    }

    $employe->delete();

    return new EmployeeResource(true, 'Data Employee Berhasil Dihapus!', null);
}
}