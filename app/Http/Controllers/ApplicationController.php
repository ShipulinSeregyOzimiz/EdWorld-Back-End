<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:11|starts_with:77',
            'name' => 'required',
            'place' => 'required'
        ]);
        Application::create($request->all());
        return ['success' => true];
    }

    public function index(Request $request)
    {
        return Application::paginate(20);
    }
}
