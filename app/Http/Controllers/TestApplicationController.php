<?php

namespace App\Http\Controllers;

use App\Models\TestApplication;
use App\Models\User;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'test_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:11|starts_with:77',
            'message' => 'required'
        ]);

        $item = TestApplication::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message
        ]);
        UserTest::find($request->test_id)->update(['test_application_id' => $item->id]);
        return ['success' => true];
    }

    public function index(Request $request)
    {
        return TestApplication::with('test.answers.testAnswer')->paginate(8);
    }

    public function delete($id)
    {
        TestApplication::find($id)->delete();
        return ['success' => true];
    }
}
