<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'phone' => 'required|digits:11|starts_with:77',
            'email' => ['nullable'],
            'password' => ['required']
        ]);
        $arr = $request->all();
        $arr['role_id'] = 2;
//        if (User::where('phone', $arr['phone'])->exitsts()) {
//            return response()->json([
//                'success' => false,
//                'data' => [
//                    'errors' => ['user' => ['already exists']]
//                ]], 422);
//        }
        $user = User::create($arr);
        $token = $user->createToken('study');
        return ['success' => true, 'user' => $user, 'token' => $token->accessToken];
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:11|starts_with:77',
            'password' => 'required'
        ]);
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('study');

            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token->accessToken,
                    'user' => $user,
                ]], 200);

        } else {
            return response()->json([
                'success' => false,
                'data' => [
                    'errors' => ['user' => ['Incorrect phone number or password']]
                ]], 401);
        }
    }

    public function getProfile()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user
            ]], 200);
    }
}
