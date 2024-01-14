<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        return Test::paginate(20);
    }

    public function item($id)
    {
        return Test::with('questions.answers')->find($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);
        Test::create($request->all());
        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required'
        ]);
        Test::find($id)->update(['title' => $request->title]);
        return ['success' => true];
    }

    public function delete($id)
    {
        Test::find($id)->delete();
        return ['success' => true];
    }
}
