<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

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

}
