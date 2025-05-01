<?php

namespace App\Livewire;

use App\Models\Rating;
use Livewire\Component;

class Ratings extends Component
{
    public int $rating;
    public int $movieOrShowId;
    public int $ratingCount;
    public int $ratingAverage;
    public $rated;

    protected $rules = [
        'rating' => ['required', 'integer', 'between:1,10']
    ];

    protected $messages = [
        'rating.required' => 'You must select a rating',
        'rating.integer' => 'Rating must be an integer',
        'rating.between' => 'Rating must be between 1 and 10.',
    ];

    public function mount($movieOrShowId)
    {
        $this->movieOrShowId = $movieOrShowId;

        $this->ratingCount = $this->getRatingCount();
        $this->ratingAverage = $this->getRatingsAverage();
        $this->rated = $this->getRated();
    }

    public function submitRating()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'Must be logged in to use the feature.');
        }

        $this->validate();

        // if validatio nwas successful
        Rating::create([
            'user_id' => auth()->id(),
            'movieOrShowId' => $this->movieOrShowId,
            'rating' => $this->rating
        ]);

        // Update average rating, rated and total rating count after user rated movie or show
        $this->rated = $this->getRated();
        $this->ratingCount = $this->getRatingCount();
        $this->ratingAverage = $this->getRatingsAverage();
    }

    public function render()
    {
        return view('livewire.ratings');
    }

    private function getRated()
    {
        return Rating::where('user_id', auth()->id())
            ->where('movieOrShowId', $this->movieOrShowId)
            ->first();
    }

    private function getRatingCount()
    {
        return Rating::where('movieOrShowId', $this->movieOrShowId)->count();
    }

    private function getRatingsAverage()
    {
        return Rating::where('movieOrShowId', $this->movieOrShowId)->avg('rating') ?? 0;
    }
}
