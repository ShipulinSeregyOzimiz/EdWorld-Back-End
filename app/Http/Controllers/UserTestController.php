<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestAnswers;
use App\Models\TestQuestion;
use App\Models\User;
use App\Models\UserTest;
use App\Models\UserTestAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserTestController extends Controller
{

    public function index($id)
    {
        return UserTest::with('answers')->find($id);
    }

    public function store(Request $request)
    {
        Log::error($request->headers);
        $request->validate([
            'user_id' => 'nullable',
            'test_id' => 'required'
        ]);
        $test = UserTest::create(['user_id' => $request->user_id, 'test_id' => $request->test_id]);

        return ['success' => true, 'test_id' => $test->id];
    }

    public function setAnswer(Request $request)
    {
        $request->validate([
            'user_test_id' => 'required',
            'test_answer_id' => 'required'
        ]);

        $test = Test::whereHas('questions', function ($q) use ($request) {
            $q->whereHas('answers', function ($qq) use ($request) {
                $qq->where('id', $request->test_answer_id);
            });
        })->withCount('questions')
            ->with(['questions' => function ($q) use ($request) {
                $q->whereHas('answers', function ($qq) use ($request) {
                    $qq->where('id', $request->test_answer_id);
                });
            }])->first();

        if (UserTestAnswer::where('user_test_id', $request->user_test_id)->whereIn('test_answer_id', $test->questions[0]->answers->pluck('id'))->exists())
            return response()->json([
                'success' => false,
                'data' => [
                    'errors' => ['test_answer_id' => ['Exists']]
                ]], 422);
        $test_answer = TestAnswers::find($request->test_answer_id);

        UserTestAnswer::create(['user_test_id' => $request->user_test_id, 'test_answer_id' => $request->test_answer_id, 'correct' => $test_answer->is_correct]);
        $user_test = UserTest::with('answers')->withCount('answers')->find($request->user_test_id);

        if ($test->questions_count == $user_test->answers_count) {
            $user_test->finished = true;
            $user_test->score = $user_test->answers->filter(function ($item) {
                return $item->correct == 1;
            })->count();
            $user_test->save();
        }
        return ['success' => true];
    }


    public function questions($test_id)
    {
        $questions = TestQuestion::with('answers')->where('test_id', $test_id)->get()->makeHidden(['created_at', 'updated_at', 'deleted_at']);
        $questions->each(function ($q) {
            $q->answers->makeHidden(['created_at', 'updated_at', 'deleted_at', 'is_correct', 'test_question_id']);
        });

        return $questions;
    }
}
