<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'hak_akses' => ['required']
        ], [
            'name.required' => 'tidak boleh kosong',
            'email.required' => 'tidak boleh kosong',
            'password.required' => 'tidak boleh kosong',
            'hak_akses.required' => 'tidak boleh kosong',
            'name.string' => 'data harus string',
            'email.string' => 'data harus string',
            'password.string' => 'data harus string',
            'name.max' => 'maximal 255 string',
            'email.max' => 'maksimal 255 string',
            'password.min' => 'minimal 8 string',
            'email.unique' => 'email sudah terdaftar',
            'email.email' => 'format berupda email',
            'password.confirmed' => 'password tidak sama'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'hak_akses' => $data['hak_akses'],
            'status' => 'Belum Aktif',
            'terakhir_login' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
