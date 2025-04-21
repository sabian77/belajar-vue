<?php

namespace App\Http\Controllers\Api;

//import model Division
use App\Models\Job;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

//import resource ProductResource
use App\Http\Resources\JobResource;

class JobController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all divisi
        $jobs = Job::latest()->paginate(5);

        //return collection of products as a resource
        return new JobResource(true, 'List Data Job', $jobs);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'deskripsi'     => 'required',
            //'employe_id'    => 'required|exists:employes,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create job
        $job = Job::create([
            'name'          => $request->name,
            'deskripsi'     => $request->deskripsi,
            //'employe_id'    => $request->employe_id,
        ]);

        return new JobResource(true, 'Data Job Berhasil Ditambahkan!', $job);
    }

    public function show($id)
    {
        $job = Job::find($id);
        
        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Data Job Tidak Ditemukan!',
            ], 404);
        }

        return new JobResource(true, 'Detail Data Job!', $job);
    }

    public function update(Request $request, $id)
    {
        // Find the job first
        $job = Job::find($id);
    
        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Data Job Tidak Ditemukan!',
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
    
        // Update job
        $job->update([
            'name'      => $request->name,
            'deskripsi' => $request->deskripsi,
        ]);
    
        return new JobResource(true, 'Data Job Berhasil Diupdate!', $job);
    }


    public function destroy($id)
{
    $job = Job::find($id);

    if (!$job) {
        return response()->json([
            'success' => false,
            'message' => 'Data Divisi Tidak Ditemukan!',
        ], 404);
    }

    $job->delete();

    return new JobResource(true, 'Data Job Berhasil Dihapus!', null);
}
}