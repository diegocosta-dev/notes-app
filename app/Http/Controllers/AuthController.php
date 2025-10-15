<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16',
            ],
            [
                'text_username.required' => 'Username is required.',
                'text_username.email' => 'Username must be a valid email address.',
                'text_password.required' => 'Password is required.',
                'text_password.min' => 'Password must be at least :min characters.',
                'text_password.max' => 'Password must not exceed :max characters.',
            ]
        );

        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // check if your user exists
        $user = User::where('username', $username)
                    ->where('deleted_at', null)
                    ->first();

        if (!$user)
        {
            return redirect()
                   ->back()->withInput()
                   ->with('loginError', 'Password or Username is incorrect');
        }

        // verify password
        if (!password_verify($password, $user->password))
        {
            return redirect()
                   ->back()->withInput()
                   ->with('loginError', 'Password or Username is incorrect');
        }

        // update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // login
        session(
            [
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                ]
            ]
        );

        if (session('user'))
        {
            return redirect()->to('/')->with('successLogin', 'Are you You have successfully logged in!
');
        }
    }

    public function logout(Request $request)
    {
        // Logout user from the application
        session()->forget('user');
        return redirect()->to('/login');
    }
}
