<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{
    public int $id;
    public string $body = '';
    public $comments;

    public function mount($id)
    {
        $this->id = $id;
        $this->comments = $this->loadComments();
    }

    public function loadComments()
    {
        return Comment::where('movieOrShowId', $this->id)->latest()->get();
    }

    public function createComment()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'Must be logged in to use the feature.');
        }

        if (strlen($this->body) < 3) {
            return back()->with('fail', 'Comment is too short');
        }

        Comment::create([
            'user_id' => auth()->id(),
            'movieOrShowId' => $this->id,
            'body' => $this->body
        ]);

        $this->comments = $this->loadComments();
        $this->body = '';
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
