<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerVote;
use Illuminate\Http\Request;

class AnswerVoteController extends Controller
{
    public function vote(Request $request, Answer $answer)
    {
        $request->validate([
            'vote' => 'required|in:1,-1',
        ]);

        $vote = AnswerVote::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'answer_id' => $answer->id,
            ],
            ['vote' => $request->vote]
        );

        return redirect()->back();
    }
}

