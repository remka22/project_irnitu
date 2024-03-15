<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public static function login(Request $request)
    {
        $field = [
            'login' => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($field)) {
            return redirect('/student');
            $user = Auth::user();
            // switch ($user->type) {
            //     case "student":
            //         return redirect('/student');
            //         break;
            //     case "teacher":
            //         return redirect('/teacher');
            //         break;
            //     case "direct":
            //         return redirect('/direct');
            //         break;
            //     case "center":
            //         return redirect('/center');
            //         break;
            //     case "rop":
            //         return redirect('/rop');
            //         break;
            // }
        }
        return redirect(route('login'));
    }


    public static function logout()
    {
        Auth::logout();
    }
}
