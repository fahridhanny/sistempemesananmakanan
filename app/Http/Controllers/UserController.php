<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user(){
        $user = User::simplePaginate(5);
        $data = [
            'users' => $user
        ];
        return view('pages.user', $data);
    }
    public function editUser(Request $request){
        if (!$request->name || !$request->email || !$request->hak_akses || !$request->status) {
            alert()->error('Edit Gagal','Tidak Boleh Kosong');
            return redirect('/user');
        }
        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->hak_akses = $request->hak_akses;
        $user->status = $request->status;
        $user->save();
        alert()->success('Edit Berhasil','Berhasil mengubah user');
        return redirect('/user');
    }
    public function hapusUser($id){
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            alert()->success('Hapus Berhasil','Berhasil menghapus user');
            return redirect('/user');
        }else{
            alert()->error('Hapus Gagal','Gagal menghapus user');
            return redirect('/user');
        }
    }
    public function tambahUser(Request $request){
        if (!$request->name || !$request->email || !$request->hak_akses || !$request->status
            || !$request->password || !$request->confirm_password) {
            alert()->error('Tambah Gagal','Tidak Boleh Kosong');
            return redirect('/user');
        }
        if($request->password == $request->confirm_password){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->hak_akses = $request->hak_akses;
            $user->status = $request->status;
            $user->password = Hash::make($request->password);
            $user->save();
            alert()->success('Tambah Berhasil','Berhasil menambahkan user');
            return redirect('/user');  
        }else{
            alert()->error('Tambah Gagal','Gagal menambahkan user');
            return redirect('/user');
        }
    }
    public function searchUser(Request $request){
        $user = User::where('name', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('email', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('hak_akses', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('status', 'LIKE', '%'.$request->search.'%')->get();
        if (count($user) > 0) {
            $table = "<table class='table table-bordered mt-2' id='dataTable' width='100%' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Hak Akses</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>";
                        $no = 1;
                        foreach($user as $data){
                        $table .= "<tr>
                            <td>".$no++."</td>
                            <td>".$data->name."</td>
                            <td>".$data->email."</td>
                            <td>".$data->hak_akses."</td>
                            <td>".$data->status."</td>
                            <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editUser-$data->id'><i class='fas fa-edit'></i></button></td>
                            <td><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#hapusUser-$data->id'><i class='fas fa-trash'></i></button></td>
                                </tr>";
                        }
                    $table .= "</tbody>
                </table>";
        }else{
            $table = "Not Result";
        }

        return $table;
    }
}
