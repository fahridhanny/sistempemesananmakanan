<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function makanan(){
        $makanan = Menu::where('id_kategori', 1)->get();
        $data = [
            'makanan' => $makanan
        ];
        return view('pages.makanan', $data);
    }
    public function minuman(){
        $minuman = Menu::where('id_kategori', 2)->get();
        $data = [
            'minuman' => $minuman
        ];
        return view('pages.minuman', $data);
    }
    public function menu(){
        $menu = Menu::simplePaginate(5);
        $kategori = Kategori::all();
        $data = [
            'menus' => $menu,
            'kategori' => $kategori
        ];
        return view('pages.menu', $data);
    }
    public function editMenu(Request $request){
        if (!$request->id_kategori || !$request->nama_menu || !$request->harga ||
            !$request->stok) {
            alert()->error('Edit Gagal','Tidak boleh kosong');
            return redirect('/menu');
        }
        if (empty($request->file('gambar'))) {
            $menu = Menu::where('id', $request->id)->first();
            $menu->id_kategori = $request->id_kategori;
            $menu->nama_menu = $request->nama_menu;
            $menu->harga = $request->harga;
            $menu->stok = $request->stok;
            $menu->save();
        }else{
            $menu = Menu::where('id', $request->id)->first();
            $menu->id_kategori = $request->id_kategori;
            $menu->nama_menu = $request->nama_menu;
            $menu->harga = $request->harga;
            $menu->stok = $request->stok;

            $gambar = $request->gambar;
            $gambarName = $request->nama_menu.'.'.$gambar->extension();
            $gambar->move(public_path('assets/img/menu'), $gambarName);

            $menu->gambar = $gambarName;
            $menu->save();
        }
        alert()->success('Edit Berhasil','Berhasil merubah menu');
        return redirect('/menu');
    }
    public function hapusMenu($id){
        $menu = Menu::where('id', $id)->first();
        if($menu){
            $gambar_path = public_path("/assets/img/menu/".$menu->gambar);
            if (File::Exists($gambar_path)) {
                    File::delete($gambar_path);
            }else{
                alert()->error('Hapus Gagal','Gagal menghapus menu');
                return redirect('/menu');
            }
            $menu->delete();
            alert()->success('Edit Berhasil','Berhasil merubah menu');
            return redirect('/menu');       
        }else{
            alert()->error('Hapus Gagal','Gagal menghapus menu');
            return redirect('/menu');
        }

    }
    public function tambahMenu(Request $request){
        if (!$request->id_kategori || !$request->nama_menu || !$request->harga ||
            !$request->stok || !$request->gambar) {
            alert()->error('Edit Gagal','Tidak boleh kosong');
            return redirect('/menu');
        }

        $menu = new Menu();
        $menu->id_kategori = $request->id_kategori;
        $menu->nama_menu = $request->nama_menu;
        $menu->harga = $request->harga;
        $menu->stok = $request->stok;

        $gambar = $request->gambar;
        $gambarName = $request->nama_menu.'.'.$gambar->extension();
        $gambar->move(public_path('assets/img/menu'), $gambarName);

        $menu->gambar = $gambarName;
        $menu->save();

        alert()->success('Tambah Berhasil','Berhasil menambah menu');
        return redirect('/menu');   
    }
    public function searchMenu(Request $request){
        $menu = Menu::where('nama_menu', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('harga', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('stok', 'LIKE', '%'.$request->search.'%')->get();
        if (count($menu) > 0) {
            $table = "<table class='table table-bordered mt-2' id='dataTable' width='100%' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>";
                        $no = 1;
                        foreach($menu as $data){
                        $table .= "<tr>
                            <td>".$no++."</td>
                            <td>".$data->nama_menu."</td>
                            <td>"."Rp.".number_format($data->harga)."</td>
                            <td>".$data->stok."</td>
                            <td><img src='assets/img/menu/$data->gambar' alt='$data->nama_menu' height='80' width='85'></td>
                            <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editMenu-$data->id'><i class='fas fa-edit'></i></button></td>
                            <td><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#hapusMenu-$data->id'><i class='fas fa-trash'></i></button></td>
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
