<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return User::paginate();
    }

    public function store()
    {

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable',
            'phone' => 'nullable',
            'birth_date' => 'nullable|date_format:Y-m-d',
        ]);

        User::find($id)->update($request->validated);


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
