<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view('admin.register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'tel_no' => ['digits_between:12,13'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $admin = new Admin();
    $admin->name = $request->name;
    $admin->tel_no = $request->tel_no;
    $admin->email = $request->email;
    $admin->password = Hash::make($request->password);

    $admin->save();

    event(new Registered($admin));

    Auth::guard('admin')->login($admin);

    return redirect(RouteServiceProvider::ADMIN_HOME);
  }
}
