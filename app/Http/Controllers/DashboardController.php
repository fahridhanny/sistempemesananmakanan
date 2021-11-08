<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    public function index(){
        return view('pages.dashboard');
    }
}
