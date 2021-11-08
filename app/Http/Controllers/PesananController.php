<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use RealRashid\SweetAlert\Facades\Alert;

class PesananController extends Controller
{
    public function keranjangPesananId($id, Request $request){
    
        $menu = Menu::where('id', $id)->first();

        if ($request->jumlah == "") {
            return redirect('/makanan');
        }else{
            $cek_pesanan = Pesanan::where('status', "Dalam Keranjang")->first();

            if (empty($cek_pesanan)) {
                $pesanan = new Pesanan();
                $pesanan->no_pesanan = "ABC".date("dmY")."-".time();
                $pesanan->no_meja = "";
                $pesanan->total_harga = 0;
                $pesanan->status = "Dalam Keranjang";
                $pesanan->save();
            }

            $cek_pesanan2 = Pesanan::where('status', "Dalam Keranjang")->first();
            $cek_pesanan_detail = PesananDetail::where('id_pesanan', $cek_pesanan2->id)
                                            ->where('id_menu', $id)->first();

            if(empty($cek_pesanan_detail)){
                $pesanan_detail = new PesananDetail();
                $pesanan_detail->id_pesanan = $cek_pesanan2->id;
                $pesanan_detail->id_menu = $id;
                $pesanan_detail->jumlah = $request->jumlah;
                $pesanan_detail->jumlah_harga = $menu->harga * $request->jumlah;
                $pesanan_detail->save();
            }else{
                $cek_pesanan_detail->jumlah = $cek_pesanan_detail->jumlah + $request->jumlah;
                $cek_pesanan_detail->jumlah_harga = $cek_pesanan_detail->jumlah_harga + ($menu->harga * $request->jumlah);
                $cek_pesanan_detail->save();
            }

            $cek_pesanan2->total_harga = $cek_pesanan2->total_harga + ($menu->harga * $request->jumlah);
            $cek_pesanan2->save();

            return redirect('/keranjang/pesanan')->with('success', 'Berhasil menambahkan ke keranjang');

        }

    }
    public function keranjangPesanan(){
        $pesanan = Pesanan::where('status', 'Dalam Keranjang')->first();
        if ($pesanan) {
            $pesananDetail = PesananDetail::join('pesanans', 'pesanan_details.id_pesanan', '=', 'pesanans.id')
                                      ->join('menus', 'pesanan_details.id_menu', '=', 'menus.id')
                                      ->where('status', 'Dalam Keranjang')
                                      ->get();
            $data = [
                'pesanan' => $pesanan,
                'pesanan_detail' => $pesananDetail
            ];
            return view('pages.keranjangPesanan', $data);
        }else{
            alert()->error('ErrorAlert','Tidak ada pesanan');

            return redirect('/');
        }
    }
    public function hapusPesananDetail($id_pesanan, $id_menu){
        
        $pesananDetail = PesananDetail::where('id_pesanan', $id_pesanan)
                                      ->where('id_menu', $id_menu)
                                      ->first();
        $pesananDetail->delete();

        $jumlah_harga = PesananDetail::where('id_pesanan', $id_pesanan)->get()->sum('jumlah_harga');
        $pesanan = Pesanan::where('id', $id_pesanan)->where('status', 'Dalam Keranjang')->first();
        $pesanan->total_harga = $jumlah_harga;
        $pesanan->save();
        
        $notPesanan = PesananDetail::where('id_pesanan', $pesanan->id)->get();
        if(count($notPesanan) == 0){
            $hapusPesanan = Pesanan::where('id', $id_pesanan)->where('status', 'Dalam Keranjang')->first();
            $hapusPesanan->delete();

            alert()->error('ErrorAlert','Pesanan berhasil dihapus');
            return redirect('/makanan');    
        }
        alert()->error('ErrorAlert','Pesanan berhasil dihapus');
        return redirect('/keranjang/pesanan');
    }
    public function pesan($id, Request $request){
        $request->validate([
            'no_meja' => 'required',
            'atas_nama' => 'required'
        ],[
            'no_meja.required' => 'No. Meja tidak boleh kosong',
            'atas_nama.required' => 'Atas Nama tidak boleh kosong'
        ]);

        $pesanan_detail = PesananDetail::where('id_pesanan', $id)->get();
        
        foreach ($pesanan_detail as $item ) {
            $menu = Menu::where('id', $item->id_menu)->get();

            foreach ($menu as $value) {
                $value->stok = $value->stok - $item->jumlah;
                $value->save();
            }
        }

        $pesanan = Pesanan::where('id', $id)->where('status', 'Dalam Keranjang')->first();
        $pesanan->no_meja = $request->no_meja;
        $pesanan->atas_nama = $request->atas_nama;
        $pesanan->status = "Belum Dibayar";
        $pesanan->save();

        return redirect('/pesanan/masuk')->with('success', 'Pesanan berhasil ditambahkan');
    }
    public function pesananMasuk(){
        $pesanan = Pesanan::where('status', 'Belum Dibayar')->orderByDesc('id')->simplePaginate(5);
        if (count($pesanan) == 0) {

            alert()->error('ErrorAlert','Tidak ada pesanan masuk');

            return redirect('/');
        }else{
            $data = [
                'pesanan' => $pesanan
            ];
            return view('pages.pesananMasuk', $data);
        }
    }
    public function bayar(Request $request){
        
        if ($request->transaksi_diterima == "") {
            return redirect('/pesanan/masuk');
        }else{
            $pesanan = Pesanan::where('no_pesanan', $request->no_pesanan)->first();
            if($request->transaksi_diterima < $pesanan->total_harga){
                alert()->error('ErrorAlert','Transaksi yang dimasukkan kurang');

                return redirect('/pesanan/masuk');
            }else{
                $pesanan->transaksi_diterima = $request->transaksi_diterima;
                $pesanan->transaksi_kembali = $request->transaksi_kembali;
                $pesanan->status = "Sudah Dibayar";
                $pesanan->save();

                return redirect('/pesanan/keluar')->with('success', 'Pesanan berhasil dibayar');
            }
            
        }
    }
    public function hapusPesanan($id){

        $pesanan_detail = PesananDetail::where('id_pesanan', $id)->get();
        
        foreach ($pesanan_detail as $item ) {
            $menu = Menu::where('id', $item->id_menu)->get();

            foreach ($menu as $value) {
                $value->stok = $value->stok + $item->jumlah;
                $value->save();
            }
        }

        $pesananDetail = PesananDetail::where('id_pesanan', $id)->get();
        foreach ($pesananDetail as $key => $value) {
            $value->delete();
        }
        $pesanan = Pesanan::where('id', $id)->first();
        $pesanan->delete();

        alert()->error('ErrorAlert','Pesanan berhasil dihapus');
        return redirect('/pesanan/masuk');
    }
    public function pesananKeluar(){
        $pesanan = Pesanan::where('status', 'Sudah Dibayar')->orderByDesc('id')->simplePaginate(5);
        if (count($pesanan) == 0) {

            alert()->error('ErrorAlert','Tidak ada pesanan keluar');

            return redirect('/');
        }else{
            $data = [
                'pesanan' => $pesanan
            ];
            return view('pages.pesananKeluar', $data);
        }
    }
    public function laporanDibayar(){
        $pesanan = Pesanan::where('status', 'Sudah Dibayar')->get();
        $data = [
            'pesanan' => $pesanan
        ];
        return view('pages.laporan', $data);
    }
    public function laporanBelumDibayar(){
        $pesanan = Pesanan::where('status', 'Belum Dibayar')->get();
        $data = [
            'pesanan' => $pesanan
        ];
        return view('pages.laporan', $data);    
    }
    public function searchDibayar(Request $request){
        
        if($request->ajax()){
            $pesanan = Pesanan::where('status', '=', 'Sudah Dibayar')
                              ->where(function($query) use($request){
                                  $query->where('no_pesanan', 'LIKE', '%'.$request->search.'%')
                                        ->orWhere('no_meja', 'LIKE', '%'.$request->search.'%')
                                        ->orWhere('atas_nama', 'LIKE', '%'.$request->search.'%');
                              })
                              ->get();

            if (count($pesanan) > 0) {
               $table = "<table class='table table-bordered mt-2' id='dataTable' width='100%' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Pesanan</th>
                            <th>No Meja</th>
                            <th>Atas Nama</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Cetak</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>";
                        $no = 1;
                        foreach($pesanan as $data){
                        $table .= "<tr>
                            <td>".$no++."</td>
                            <td>".$data->no_pesanan."</td>
                            <td>".$data->no_meja."</td>
                            <td>".$data->atas_nama."</td>
                            <td>"."Rp.".number_format($data->total_harga)."</td>
                            <td><span class='badge badge-pill badge-success'>".$data->status."</span></td>
                            <td><a href='/cetak/pembayaran/$data->id' class='btn btn-info'><i class='fas fa-print'></i></a></td>
                            <td><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#hapusPesanan-$data->id'><i class='fas fa-trash'></i></button></td>
                        </tr>";
                        }
                    $table .= "</tbody>
                </table>";
            }else{
                $table = "No Result";    
            }
            return $table;

        }else{
            return response()->json([
                'search' => 'error search'
            ], 401);
        }
    }
    public function searchBelumDibayar(Request $request){

        if($request->ajax()){
            $pesanan = Pesanan::where('status', '=', 'Belum Dibayar')
                              ->where(function($query) use($request){
                                  $query->where('no_pesanan', 'LIKE', '%'.$request->search.'%')
                                        ->orWhere('no_meja', 'LIKE', '%'.$request->search.'%')
                                        ->orWhere('atas_nama', 'LIKE', '%'.$request->search.'%');
                              })
                              ->get();

            if (count($pesanan) > 0) {
               $table = "<table class='table table-bordered mt-2' id='dataTable' width='100%' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Pesanan</th>
                            <th>No Meja</th>
                            <th>Atas Nama</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>";
                        $no = 1;
                        foreach($pesanan as $data){
                        $table .= "<tr>
                            <td>".$no++."</td>
                            <td>".$data->no_pesanan."</td>
                            <td>".$data->no_meja."</td>
                            <td>".$data->atas_nama."</td>
                            <td>"."Rp.".number_format($data->total_harga)."</td>
                            <td><span class='badge badge-pill badge-danger'>".$data->status."</span></td>
                            <td><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#hapusPesanan-$data->id'><i class='fas fa-trash'></i></button></td>
                        </tr>";
                        }
                    $table .= "</tbody>
                </table>";
            }else{
                $table = "No Result";    
            }
            return $table;

        }else{
            return response()->json([
                'search' => 'error search'
            ], 401);
        }
    }
    public function cetakPembayaran($id){
        $pesanan = Pesanan::where('id', $id)->first();
        $pesananDetail = PesananDetail::join('menus', 'pesanan_details.id_menu', '=', 'menus.id')
                                ->where('id_pesanan', $id)->get();
        $data = [
            'pesananDetail' => $pesananDetail,
            'pesanan' => $pesanan
        ];
        return view('pages.cetakPembayaran', $data);
    }
}
