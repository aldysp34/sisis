<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Library\ApiHelpers;
use App\Models\Data;
use App\Models\Document;

class UserController extends Controller
{
    use ApiHelpers;


    public function index(){
        if($this->isUser(auth()->user()->role)){
            $data = Data::where('validasi_status', 1)->get();

            return $this->onSuccess($data, 'Success Get Data');
        }

        return $this->onError(401, 'Unauthorized Access');
    }

    public function detail_data($id){
        if($this->isUser(auth()->user()->role)){
            $data = Data::where('id', $id)->get();
            if($data){
               return $this->onSuccess($data, 'Success Get Data');  
            }
            return $this->onError(404, 'Data Not Found');
        }
        return $this->onError(401, 'Unauthorized Access'); 
    }

    public function downloadDocument($id){
        $data = Data::findOrFail($id);
        if($data){
            $filePath = public_path().'/'.$data->link;
            if(file_exists($filePath)){
                return response()->file($filePath);
            }else{
                return $this->onError(404, 'Document Not Found');
            }
        }
    }
}
