<?php

namespace App\Http\Controllers;

use App\Models\TestAnswers;
use App\Models\TestQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestQuestionController extends Controller
{
    public function index(Request $request)
    {
        return TestQuestion::with('answers')->get();
    }

    public function item($test_id, $id)
    {
        return TestQuestion::with('answers')->find($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'test_id' => 'required',
            'answers' => 'required|array|max:4|min:4',
            'answers.*.text' => 'required',
            'answers.*.is_correct' => 'required',
        ]);

        $answers = $request->answers;
        $question = TestQuestion::create([
            'description' => $request->description,
            'test_id' => $request->test_id
        ]);


        $answers = array_map(function ($i) use ($question) {
            $i['test_question_id'] = $question->id;
            return $i;
        }, $answers);
        TestAnswers::insert($answers);
        return ['success' => true];
    }

    public function update(Request $request, $test_id, $id)
    {
        $request->validate([
            'description' => 'required',
            'test_id' => 'required',
            'answers' => 'required|array|max:4|min:4',
            'answers.*.text' => 'required',
            'answers.*.is_correct' => 'required',
        ]);

        TestQuestion::find($id)->update(['description' => $request->description]);

        $answers_ids = array_column($request->answers, 'id');

        $answers = TestAnswers::whereIn('id', $answers_ids)->get();
        $newAnswers = $request->answers;
        $answers->each(function ($item) use ($newAnswers) {
            $new = collect($newAnswers)->first(function ($a) use ($item) {
                return $a['id'] == $item->id;
            });

            $item->update(['text' => $new['text'], 'is_correct' => $new['is_correct']]);
        });

        return ['success' => true];
    }

    public function delete($id)
    {
        TestQuestion::find($id)->delete();
        return ['success' => true];
    }
}
