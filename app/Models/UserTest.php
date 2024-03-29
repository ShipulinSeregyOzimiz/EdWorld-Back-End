<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'test_id', 'finished', 'score', 'test_application_id'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function application()
    {
        return $this->belongsTo(TestApplication::class);
    }

    public function answers()
    {
        return $this->hasMany(UserTestAnswer::class);
    }
}
