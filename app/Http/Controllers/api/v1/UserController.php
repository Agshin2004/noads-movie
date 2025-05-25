<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\StoreNowWatchingRequest;
use App\Http\Requests\UpdateNowWatchingRequest;
use App\Models\Comment;
use App\Models\NowWatching;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function getUserComments(Request $request)
    {
        $userId = auth('api')->id();

        if (!$userId)
            throw new \Exception('JWT Malformed. User id not found.', 400);

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
            throw new \Exception('JWT Malformed. User id not found.', 400);

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
        $updated = tap($comment, fn() => $comment->update([
            'body' => $request->input('body'),
        ]));

        return $this->successResponse($updated);
    }

    public function deleteComment(Request $request, Comment $comment)
    {
        Gate::authorize('delete', [$comment]);
        $comment->delete();
        // default sends 204 with no content (when done manually null returned)
        return response()->noContent();
    }

    public function getNowWatching(Request $request)
    {
        $userId = auth()->id();
        if (!$userId)
            throw new \Exception('JWT Malformed. User id not found.', 400);

        $user = User::find($userId);
        $nowWatchings = $user->nowWatchings()->get();

        return $this->successResponse($nowWatchings);
    }

    public function addNowWatching(StoreNowWatchingRequest $request)
    {
        $data = $request->validated();
        $userId = auth()->id();
        if (!$userId)
            throw new \Exception('JWT Malformed. User id not found');

        $data['user_id'] = $userId;

        $obj = NowWatching::firstOrCreate($data);
        // check if object was fetched if it was then just return success response with already exists text
        if (!$obj->wasRecentlyCreated)
            return $this->successResponse(message: 'already exists.');

        return $this->successResponse($obj);
    }

    public function editNowWatching(UpdateNowWatchingRequest $request, NowWatching $nowWatching)
    {
        $data = $request->validated();
        Gate::authorize('update', [$nowWatching]);

        $updated = tap($nowWatching, fn() => $nowWatching->update($data));

        return $this->successResponse($updated);
    }

    public function deleteNowWatching(Request $request, NowWatching $nowWatching)
    {
        Gate::authorize('delete', [$nowWatching]);
        $nowWatching->delete();
        // default sends 204 with no content (when done manually null returned)
        return response()->noContent();
    }
}
