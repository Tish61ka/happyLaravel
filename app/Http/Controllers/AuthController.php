<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        $passOne = $request->input('password');
        $passTwo = $request->input('confirmed_password');
        if ($passOne !== $passTwo) {
            return response()->json([
                'message' => 'Пароли не совпадают',
                'code' => 401
            ]);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'token' => null,
        ]);
        $user->token = Str::random(32);
        $user->save();
        return response()->json([
            'user_token' => $user->token
        ]);
    }
    public function logout(Request $request)
    {
        $token = $request->input('token');
        $user = User::where('token', $token)->first();
        $user->update([
            'token' => null
        ]);
        return response()->json([
            'message' => 'Вы вышли',
            'code' => 200
        ]);
    }
    public function signIn(SignInRequest $request)
    {
        if (Auth::attempt($request->all())) {
            $user = User::find(Auth::id());
            $user->token = Str::random(32);
            $user->save();
            return response()->json([
                'user_token' => $user->token
            ]);
        } else {
            return response()->json([
                'message' => 'Неверные данные',
                'code' => 401
            ]);
        }
    }
}
