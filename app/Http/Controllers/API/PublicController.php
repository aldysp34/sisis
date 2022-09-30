<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Data;

class PublicController extends Controller
{
    public function index(){
        $data = Data::where('validasi_status', 1)->get(['id', 'standar', 'judul', 'kategori', 'tahun', 'status', 'deskripsi']);
    
        if(!$data){
            return response()->json([
                'status' => 404,
                'message' => 'Data Not Found'
            ]);
        }
        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'hahaha'
        ]);
    }

    public function detail_data($id){
        $data = Data::where('id', $id)->get(['id', 'standar', 'judul', 'kategori', 'tahun', 'status', 'deskripsi']);
        if(!$data){
            return response()->json([
                'status' => 404,
                'message' => 'Data Not Found'
            ]);   
        }
        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'xixiixix'
        ]);
        
    }
}
