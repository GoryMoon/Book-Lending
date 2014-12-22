<?php

class SessionController extends BaseController {
    public function store()
    {

        if (Input::get('_token') !== Session::token()) {
            return Response::json( array(
                'status' => 'error',
                'msg' => 'token'
            ));
        }

        $remember = Input::get('remember') == null ? false: true;
        if (Auth::attempt(Input::only('email', 'password'), $remember)) {
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