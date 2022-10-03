<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Library\ApiHelpers;
use App\Models\Data;

class ValidatorController extends Controller
{
    use ApiHelpers;

    /** Data Like User */
    public function index(){
        if($this->isValidator(auth()->user()->role)){
            $data = Data::all();

            return $this->onSuccess($data, 'Success Get Data');
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    /** Read Detail Data by ID */
    public function detail_data($id){
        if($this->isValidator(auth()->user()->role)){
            $data = Data::where('id', $id)->first();

            return $this->onSuccess($data, 'Success Get Data');
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    /** Data are not validated yet */
    public function no_validasi_data(){
        if($this->isValidator(auth()->user()->role)){
            $data = Data::where('validasi_status', 0)->get();

            return $this->onSuccess($data, 'Success Get Data');
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    /** Validation Data */
    public function validasi_data($id, $status){
        if($this->isValidator(auth()->user()->role)){
            $data = Data::findOrFail($id);
            if($data){
                $data->validasi_status = $status;
                $data->save();

                if($status == 1){
                    return $this->onSuccess($data, 'Success Approving Data');
                }
                return $this->onSuccess($data, 'Success Rejecting Data');
            }
        }
        return $this->onError(401, 'Unauthorized Access');
    }
}
