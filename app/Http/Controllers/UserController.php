<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getSignup() {
        return view('user.signup');
    }

    public function postSignup(Request $request) {

        // validatie
        $this->validate($request, [
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4'
        ]);

        $user = new User([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
        $user->save();

        Auth::login($user);

        return redirect()->route('user.profile');
    }

    public function getSignin() {
        return view('user.signin');
    }

    public function getProfileDelete() {
        return view('user.profile_delete');
    }

    public function postSignin(Request $request) {

        // validatie
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);

        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect()->route('user.profile');
        }
        return redirect()->back();
    }

    public function postProfile(Request $request) {

        $this->validate($request, [
            'email' => 'email|required|unique:users'
        ]);

        $user = User::find(Auth::user()->id);
        $user->email = $request->input('email');
        $user->save();

        // blijf op huidige pagina
        return redirect()->route('user.profile');
    }

    // voor een user te deleten
    public function postProfileDelete(Request $request) {

        // validatie
        $this->validate($request, [
            'password' => 'required|min:4'
        ]);

        $user = User::find(Auth::user()->id);

        // source: https://stackoverflow.com/a/38519665/12308353
        // ik gebruik de 2de: Facade
        if (Hash::check($request->input('password'), $user->password)) {
            // password is correct --> account gets deleted

            // btw... Eloquent ORM is eh-mazing
            $user->delete();

            // source: https://laravel.com/docs/7.x/redirects#redirecting-controller-actions
            // Laravel is echt wel nice :), toch xd
            return redirect()->action('ProductController@getIndex');
        }

        // blijf op dezelfde pagina
        return redirect()->back();
    }

    public function getProfile() {
        // voor de zekerheid... $orders = Auth::user()->orders;

        /*
        sources:
        https://laravel.com/docs/7.x/pagination#paginating-eloquent-results &
        https://laravel.com/docs/7.x/pagination#displaying-pagination-results
        */

        $orders = Order::paginate(2);

        // lees elke order uit
        $orders->transform(function ($order, $key) {

            // unserialize() laat ons toe een serialized object terug om te zetten naar een PHP object
            // dat PHP object kunnen we dan mooi gaan tonen op de profile pagina

            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('user.profile', ['orders' => $orders]);
    }

    public function getLogout() {
        Auth::logout();
        return redirect()->back();
    }
}
