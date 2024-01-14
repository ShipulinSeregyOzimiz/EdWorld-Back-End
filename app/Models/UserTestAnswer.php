<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTestAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_test_id', 'test_answer_id', 'correct'];

    public function test()
    {
        return $this->belongsTo(UserTest::class);
    }

    public function testAnswer()
    {
        return $this->belongsTo(TestAnswers::class);
    }
}
