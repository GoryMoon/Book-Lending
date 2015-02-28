<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

class SessionController extends Controller {
    public function store(Request $request)
    {

        if ($request->input('_token') !== Session::token()) {
            return Response::json( array(
                'status' => 'error',
                'msg' => 'token'
            ));
        }

        $remember = $request->input('remember') == null ? false: true;
        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            return Response::json( array(
                'status' => 'success'
            ));
        }

        return Response::json( array(
            'status' => 'error',
            'msg' => 'credentials'
        ));

    }

    public function destroy()
    {
        Auth::logout();
        return Redirect::route('home');
    }

}