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
//            'phone' => 'required|regex:/^\+7 \d{3} \d{3} \d{2} \d{2}$/',
            'email' => ['nullable'],
            'password' => ['required']
        ]);
        $arr = $request->all();
        $arr['phone'] = preg_replace('/[^0-9]/', '', $request->phone);
        $arr['role_id'] = 2;
//        if (User::where('phone', $arr['phone'])->exitsts()) {
//            return response()->json([
//                'success' => false,
//                'data' => [
//                    'errors' => ['user' => ['already exists']]
//                ]], 422);
//        }
        User::create($arr);


        return ['success' => true];
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);
        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        if (Auth::attempt(['phone' => $phone, 'password' => $request->password])) {
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
