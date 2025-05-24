<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function getUserComments(Request $request)
    {
        $userId = auth('api')->id();

        if (!$userId)
            return new \Exception('JWT Malformed. User id not found.', 400);

        $user = User::find($userId);
        $comments = $user->comments()->get();

        return $this->successResponse($comments);
    }

    public function addComment(Request $request)
    {
        $request->validate(
            [
                'movieOrShowId' => ['required', 'integer'],
                'body' => ['required', 'string', 'min:3']
            ]
        );

        $userId = auth('api')->id();

        if (!$userId)
            return new \Exception('JWT Malformed. User id not found.', 400);

        $comment = Comment::create([
            'user_id' => $userId,
            'movieOrShowId' => $request->input('movieOrShowId'),
            'body' => $request->input('body')
        ]);

        return $this->successResponse(data: $comment, code: 201);
    }

    public function editComment(Request $request, Comment $comment)
    {
        // NOTE: the route parameter {comment} must match the variable name $comment

        $request->validate([
            'body' => ['required', 'min:3'],
        ]);

        // new versions do not support $this->authorize anymore gotta use Gate facade
        Gate::authorize('update', [$comment]);

        // used tap function here to get UPDATED valie
        // returns $comment AFTER it's been modified
        $updated = tap($comment)->update([
            'body' => $request->input('body'),
        ]);

        return $this->successResponse($updated);
    }

    public function deleteComment(Request $request, Comment $comment)
    {
        Gate::authorize('delete', [$comment]);
        $comment->delete();
        return $this->successResponse(code: 204);
    }
}
