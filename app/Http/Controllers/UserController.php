<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Mail\SubscriptionMail;
use App\Models\Order;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{


  public function register(RegisterUserRequest $request): void
  {

    $validatedData = $request->validated();

    $validatedData['password'] = Hash::make($validatedData['password']);

    $user = User::create($validatedData);

    Auth::login($user);

    event( new UserRegisteredEvent($user));

  }


  public function login(Request $request): Response|Application|RedirectResponse|ResponseFactory
  {

    $validatedData = $request->validate(['email' => 'required|email', 'password' => 'required',]);

    if (Auth::attempt($validatedData, $request->validate(['remember_token' => 'string|max:5']) === 'true')) {

      $request->session()->regenerate();

      return redirect()->intended();
    }

    return response('Incorrect email or password', 401)->header('Content-Type', 'text/plain');

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
    $validator = UpdateProductRequest::updateProductRequest($request);

    User::where('id', auth()->id())->update($validator->validate());

    return redirect()->route('profile')->with('status', 'Профиль обновлён!');
  }


  public function userOrders(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application
  {

    $ordersList = Order::where('user_id', auth()->user()->id)->get();

    return view('user.orders', compact('ordersList'));
  }


  public function updateRole($role): void
  {

    abort_if(!$this->authorize('updateRole', User::class), 403);

    User::update(['role' => $role]);
  }


  public function subscribeForNews(Request $request,): Response|Application|ResponseFactory
  {

    $email = $request->validate(['email' => 'required|email']);

    Subscriber::createSubscription($email['email']);

    Mail::to($email['email'])->send(new SubscriptionMail());

    return response('Подписка оформлена', 200);

  }
}
