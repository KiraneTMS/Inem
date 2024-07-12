<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $this->middleware('auth');
        return view('home');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function store_register(Request $request){
        $password = Hash::make($request->password);

        Request()->validate([
            'name'              => 'required',
            'email'             => 'required|unique:users,email',
            'password'          => 'required|confirmed',
        ], [
            'name.required'     => 'Full Name is required !',
            'email.required'    => 'Email is required !',
            'password.required' => 'Password is required !',
            'email.unique'      => 'Email already exist !',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'level' => '2',
            'password' => $password,
        ]);

        try{
            Mail::to($request->email)->send(new VerificationMail($password,$request->email));
        }
        catch(\Exception $e){
            dd($e);
        }
        return redirect('login')->withErrors(['verified'=> 'Berhasil Registrasi, Cek Email Anda Untuk Verifikasi Email']);
    }

    public function verification(Request $request){
        $email = explode('...',$request->token)[1];
        User::where('email',$email)->update(['email_verified_at'=>date("Y-m-d H:i:s")]);
        return redirect('login')->withErrors(['verified'=> 'Akun Berhasil Di Verifikasi, Silahkan Login']);
    }
}
