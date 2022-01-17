<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

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
    $this->validate_admin($request);

    $admin = new Admin();
    $admin->name = $request->name;
    $admin->tel_no = $request->tel_no;
    $admin->email = $request->email;
    $admin->password = Hash::make($request->password);

    $admin->save();

    event(new Registered($admin));

    Auth::guard('admin')->login($admin);

    Log::debug('Registered and logged in.');

    return redirect(RouteServiceProvider::ADMIN_HOME);
  }

  public function validate_admin (Request $request) {
    $rule = [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ];

    $validator = Validator::make($request->all(), $rule);

    $validator->sometimes('tel_no', 'digit_between:12,13', function ($input) {
      return empty($input->tel_no);
    });
  }
}
