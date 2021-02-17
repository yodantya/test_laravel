<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use Auth;

class PendudukController extends Controller
{
    function index(){

        return view('admin.penduduk');
    }

    function getPenduduk(){
            $data = Penduduk::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now        = date('Y-m-d H:i:s');

        Penduduk::create([
                    'nik' => "$request->nik",
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tanggalinput' => $now,
                    'userinput' => Auth::user()->name
                ]);      
                
   
        return response()->json($request->all());
    }
    
}

