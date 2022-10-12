<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Data;
use Illuminate\Support\Facades\DB;

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
            'message' => 'Success Get Data'
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
            'message' => 'Success Get Detail Data'
        ]);
    }

    public function getCountData(){
        $data = Data::all();
        $kategori = array();

        foreach($data as $x){
            if($data->validasi_status == 1){
                if(array_key_exists($x->kategori, $kategori)){
                    $kategori[$x->kategori]++;
                }else{
                    $kategori[$x->kategori] = 1;
                }
            }
        }
        
        if(count($kategori) > 0){
            return response()->json([
                'status' => 200,
                'data' => $kategori,
                'message' => 'Success get Count Data'
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No data in database'
        ]);
    }

    
}
