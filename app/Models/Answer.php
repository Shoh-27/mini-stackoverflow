<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body', 'question_id', 'user_id', 'is_best'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(AnswerVote::class);
    }

// Javobning umumiy reytingi
    public function getVoteCountAttribute()
    {
        return $this->votes()->sum('vote');
    }

}
