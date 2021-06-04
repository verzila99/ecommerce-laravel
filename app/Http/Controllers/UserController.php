<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UserController extends Controller
{


  public function register(Request $request): void
  {

    $validatedData = $request->validate([
      'name' => 'required|string|max:20',
      'email' => 'required|email|max:50|unique:users',
      'password' => 'required|confirmed|string|min:6',
    ]);
    $validatedData['password'] = Hash::make($validatedData['password']);

    $user = User::create($validatedData);

    Auth::login($user);

  }

  public function login(Request $request): Response|Application|RedirectResponse|ResponseFactory
  {

    $validatedData = $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    if (Auth::attempt($validatedData, $request->validate(['remember_token' => 'string|max:5']) === 'true')) {

      $request->session()->regenerate();

      return redirect()->intended();
    }

    return response('Incorrect email or password', 401)
      ->header('Content-Type', 'text/plain');

  }

  public function logout(Request $request): RedirectResponse
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->back();
  }


  public function show(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application
  {
    $user = User::find(auth()->id());

    return view('user.profile', compact('user'));
  }

  public function edit(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application
  {
    $user = User::find(auth()->id());

    return view('user.edit', compact('user'));
  }

  public function update(Request $request): RedirectResponse
  {
    $validator = Validator::make($request->except([
      $request->name === null ? 'name' : null,
      $request->email === null ? 'email' : null,
      $request->password === null ? 'password' : null]), [
      'name' => 'string|max:20',
      'email' => 'email|' . Rule::unique('users')->ignore
        (auth
        ()->id()),
      'password' => 'confirmed|min:6'
    ]);

    if ($validator->fails()) {

      return redirect()->back()->withErrors($validator)->withInput();
    }


    User::where('id', auth()->id())->update($validator->validate());

    return redirect()->route('profile')->with('status', 'Профиль обновлён!');
  }

  public function userOrders(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application
  {

      $ordersList = Order::where('user_id', auth()->user()->id )->get();
      return view('user.orders',compact('ordersList'));
  }


  public function updateRole($role): void
  {
    try {
      $this->authorize('updateRole', User::class);
    } catch (AuthorizationException $e){
      abort(403);
    }

    User::update(['role' => $role]);
  }

}
