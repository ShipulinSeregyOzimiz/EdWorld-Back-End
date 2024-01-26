<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return User::paginate(8);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'has_access' => 'required|boolean',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'has_access' => $request->has_access,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id
        ]);
        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'has_access' => 'required|boolean'
        ]);

        User::find($id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'has_access' => $request->has_access
        ]);


        return ['success' => true];
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return ['success' => true];
    }

    public function item($id)
    {
        return User::find($id);
    }
}
