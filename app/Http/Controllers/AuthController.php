<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
   // Menampilkan halaman login
   public function showLoginForm()
   {

    if (Auth::check()) {
        return redirect('/'); // Redirect ke dashboard jika sudah login
    }
       return view('login'); // Halaman form login

   }

   // Proses login
   public function login(Request $request)
   {
       // Validasi input
       $request->validate([
           'email' => 'required|email',
           'password' => 'required|min:8',
       ]);

       // Coba login dengan kredensial
       if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
           // Login berhasil
           return redirect()->intended('/'); // Redirect ke halaman yang diinginkan setelah login
       }

       // Jika login gagal
       return back()->with('error', 'Invalid credentials, please try again.'); // Kirim pesan error kembali ke form
   }

   // Menampilkan halaman registrasi
   public function showRegisterForm()
   {
    if (Auth::check()) {
        return redirect('/'); // Redirect ke dashboard jika sudah login
    }
       return view('register'); // Halaman form registrasi
   }

   // Proses registrasi
   public function register(Request $request)
   {
       // Validasi input
       $request->validate([
           'name' => 'required|string|min:4|max:12',
           'email' => 'required|email|unique:users,email',
           'password' => 'required|min:8',
       ]);
       // Membuat user baru
           try {
               // Membuat user baru dengan data yang sudah divalidasi dan memproses password
               User::create([
                   'name' => $request->name,
                   'email' => $request->email,
                   'password' => bcrypt($request->password), // Pastikan password di-hash
               ]);

               // Flash message untuk keberhasilan
               session()->flash('success', 'Registration successful! You can now log in.');

               return redirect()->route('register'); // Redirect ke halaman register
           } catch (\Exception $e) {
               // Jika terjadi kesalahan dalam proses penyimpanan
               session()->flash('error', 'Something went wrong, please try again.');
               return redirect()->route('register'); // Kembali ke halaman register
           }
   }

   // Logout
   public function logout(Request $request)
   {
       Auth::logout();
       $request->session()->invalidate();
        $request->session()->regenerateToken();
       return redirect()->route('login');
   }
}
