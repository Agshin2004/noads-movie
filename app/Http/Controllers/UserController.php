<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function addComment(Request $request)
    {
        $request->validate(
            [
                'movieOrShowId' => ['required', 'integer'],
                'body' => ['required', 'string', 'min:3']
            ]
        );

        $userId = auth()->id();
        if (!$userId)
            return new \Exception('JWT Malformed. User id not found.', 400);
        
        $comment = Comment::create([
            'user_id' => $userId,
            'movieOrShowId' => $request->input('movieOrShowId'),
            'body' => $request->input('body')
        ]);

        return $this->successResponse($comment);
    }
}
