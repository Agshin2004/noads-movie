<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{
    public int $id;
    public string $body = '';
    public $comments;

    protected $rules = [
        'id' => ['required'],
        'body' => ['required', 'min:4']
    ];

    protected $validationMessages = [
        'body.required' => 'Comment is required',
        'body.min' => 'Comment is too short.',
    ];

    public function mount($id)
    {
        $this->id = $id;
        $this->comments = $this->loadComments();
    }

    public function createComment()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'Must be logged in to use the feature.');
        }

        $this->validate();

        // if validation wassuccessful
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

    private function loadComments()
    {
        return Comment::where('movieOrShowId', $this->id)->latest()->get();
    }
}
