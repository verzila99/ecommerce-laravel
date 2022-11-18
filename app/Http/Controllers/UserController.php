<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\SubscribeForNewsRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Mail\SubscriptionMail;
use App\Models\Order;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{


  public function register(RegisterUserRequest $request): Response|Application|ResponseFactory
  {
    $validatedData = $request->validated();

    $validatedData['password'] = Hash::make($validatedData['password']);

    $user = User::create($validatedData);

    Auth::login($user);

//    event(new Registered($user));

    return response('', 200);

  }


  public function verifyEmail(EmailVerificationRequest $request
  ): \Illuminate\Routing\Redirector|Application|RedirectResponse {

    $request->fulfill();

    $user = User::find(\auth()->id());

    event(new UserRegisteredEvent($user));

    return redirect('/')->with('status','Email confirmed!');
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


  public function resetPassword(Request $request): RedirectResponse
  {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
      ? back()->with(['status' => __($status)])
      : back()->withErrors(
        ['email' => __($status)]
      );
  }


  public function updatePasswordAfterReset(Request $request): RedirectResponse
  {

    $request->validate(
      ['token'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|min:8|confirmed',]
    );

    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user, $password) {
        $user->forceFill(
          [
            'password' => Hash::make($password)
          ]
        )->setRememberToken(Str::random(60));

        $user->save();

        Auth::login($user);

        event(new PasswordReset($user));
      }
    );

    return $status === Password::PASSWORD_RESET
      ? redirect()->route('profile')->with('status', __($status))
      : back()->withErrors(['email' => [__($status)]]);
  }


  public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application
  {
    $users = User::All();

    return view('admin.users', compact('users'));
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

    return redirect()->route('profile')->with('status', 'Profile updated!');
  }


  public function destroy(Request $request)
  {
    abort_if(!$this->authorize('updateRole', User::class), 403);

    $validated = $request->validate(['id' => 'required|numeric']);

    User::destroy($validated['id']);

    return redirect()->back()->with('status', 'User deleted');
  }


  public function userOrders(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application
  {
    $ordersList = Order::where('user_id', auth()->user()->id)->leftJoin('order_product', 'orders.id',
        '=', 'order_product.order_id')->leftJoin('products', 'order_product.product_id',
        '=', 'products.id')->get();


      $grouped = $ordersList->groupBy('order_id');
//dd($grouped);
    return view('user.orders', compact('grouped'));

  }


  public function updateRole(Request $request): RedirectResponse
  {
    abort_if(!$this->authorize('updateRole', User::class), 403);

    $validated = $request->validate(
      [
        'id'   => 'required|numeric',
        'role' => 'required|numeric'
      ]
    );

    User::where('id', $validated['id'])->update(['role' => $validated['role']]);

    return redirect()->back()->with('status', 'User\'s role updated!');
  }


  public function subscribeForNews(Request $request,): Response|Application|ResponseFactory
  {
    $validator = Validator::make(
      $request->all(),
      ['email' => 'required|email|unique:subscribers|max:100'],
    );

    if ($validator->fails()) {

    $errors = $validator->errors();

      return response($errors->first('email'),422);
    }

    Subscriber::createSubscription($validator['email']);

    Mail::to($validator['email'])->send(new SubscriptionMail());

    return  response('Subscribed', 200);
  }
}
