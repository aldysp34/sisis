<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Data;
use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Http\Library\ApiHelpers;
use Validator;

class AdminController extends Controller
{
    use ApiHelpers;

    public function index(){
        if($this->isAdmin(auth()->user()->role)){
            $data = Data::all();

            return $this->onSuccess($data, 'Success Get Data');
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    public function detail_data($id){
        if($this->isAdmin(auth()->user()->role)){
            $data = Data::findOrFail($id);

            if($data){
                return $this->onSuccess($data, 'Success Get Data');
            }
            return $this->onError(402, 'Data not Found');
        }
        return $this->onError(401, 'Unauthorized Access');
    }
    public function users(){
        if($this->isAdmin(auth()->user()->role)){
            $users = User::all();

            return $this->onSuccess($users, 'Success Get Users');
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    public function addUsers(Request $request){
        if($this->isAdmin(auth()->user()->role)){
            $validator = Validator::make($request->all(), $this->userValidatedRules());
            if ($validator->passes()) {
                // Create New User
                $newUser = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'role' => $request->input('role'),
                    'password' => Hash::make($request->input('password')),
                ]);

                return $this->onSuccess($newUser, 'Success Add New User');
            }
            return $this->onError(400, $validator->errors());
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    public function addData(Request $request){
        if($this->isAdmin(auth()->user()->role)){
            $validator = Validator::make($request->all(), $this->dataValidatedRules());
            
            if($validator->passes() ){
                /** Create New Data */
                if($file = $request->file('document')){
                    $path = 'files/';
                    $name = $file->getClientOriginalName();
                    $type = $request->file('document')->getClientMimeType();
                    $size = $request->file('document')->getSize();
                    $filePath = $request->file('document')->move($path, $name);

                    $createData = Data::create([
                        'standar' => $request->input('standar'),
                        'judul' => $request->input('judul'),
                        'kategori' => $request->input('kategori'),
                        'tahun' => $request->input('tahun'),
                        'status' => $request->input('status'),
                        'link' => $filePath,
                        'deskripsi' => $request->input('deskripsi'),
                        'validasi_status' => 0
                    ]);

                    $createDocument = Document::create([
                        'filename' => $name,
                        'type' => $type,
                        'size' => $size,
                        'folder_path' => $filePath,
                        'data_id' => $createData->id
                    ]);

                    return $this->onSuccess($createData, 'Success add new Data');

                }
                return $this->onError(400, 'Document not Uploaded yet');
            }
            return $this->onError(400, $validator->errors());
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    public function deleteUser(Request $request, $id){
        if($this->isAdmin(auth()->user()->role)){
            $allUsers = User::all();
            $user = User::findOrFail($id);
            if($user){
                $user->delete();
                
                return $this->onSuccess($allUsers, 'Success Delete User');
            }
            return $this->onError(400, 'User Not Found');
        }
        return $this->onError(401, 'Unauthorized Access');
    }
    
    public function detail_user($id){
        if($this->isAdmin(auth()->user()->role)){
            $data = User::findOrFail($id);
            if($data){
                return $this->onSuccess($data, 'Success Get User Data');
            }
            return $this->onError(400, 'User Not Found');
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    public function deleteData(Request $request, $id){
        if($this->isAdmin(auth()->user()->role)){
            $allData = Data::all();
            $data = Data::findOrFail($id);
            if($data){
                $data->delete();
                
                return $this->onSuccess($allData, 'Success Delete User');
            }
            return $this->onError(400, 'Data Not Found');
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    public function editUser(Request $request, $id){
        if($this->isAdmin(auth()->user()->role)){
            $validator = Validator::make($request->all(), $this->userValidatedRules($id));
            if ($validator->passes()) {
                // Create New User
                $user = User::findOrFail($id);
                if($user){
                    
                    $user->name = $request->input('name');
                    $user->email = $request->input('email');
                    $user->password = Hash::make($request->input('password'));
                    $user->role = $request->input('role');
                    $user->save();

                    return $this->onSuccess($user, 'Success Edit User');
                }

                return $this->onError(400, 'User Not Found');
            }
            return $this->onError(400, $validator->errors());
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    public function editData(Request $request, $id){
        if($this->isAdmin(auth()->user()->role)){
            $validator = Validator::make($request->all(), $this->dataValidatedRules());
            if ($validator->passes()) {
                // Create New User
                $data = Data::findOrFail($id);
                if($data){
                    $data->standar = $request->input('standar');
                    $data->judul = $request->input('judul');
                    $data->kategori = $request->input('kategori');
                    $data->tahun = $request->input('tahun');
                    $data->status = $request->input('status');
                    $data->deskripsi = $request->input('deskripsi');
                    if($file = $request->file('document')){
                        $path = 'files/';
                        $name = $file->getClientOriginalName();
                        $type = $request->file('document')->getClientMimeType();
                        $size = $request->file('document')->getSize();
                        $filePath = $request->file('document')->move($path, $name);
                        
                        $createDocument = Document::create([
                            'filename' => $name,
                            'type' => $type,
                            'size' => $size,
                            'folder_path' => $filePath,
                            'data_id' => $data->id
                        ]);
                        
                        $data->link = $filePath;
                    }
                    $data->save();

                    return $this->onSuccess($data, 'Success Edit');
                }

                return $this->onError(400, 'User Not Found');
            }
            return $this->onError(400, $validator->errors());
        }
        return $this->onError(401, 'Unauthorized Access');
    }
}
