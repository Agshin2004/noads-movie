<?php

namespace App\Livewire;

use App\Models\Favorite;
use Livewire\Component;

class Favorites extends Component
{
    public int $id;
    public bool $added;
    public string $type;

    public function mount($id, $type)
    {
        $this->id = $id;
        $this->type = $type;

        if (auth()->check()) {
            $this->added = Favorite::where('user_id', auth()->user()->id)
                ->where('movieOrShowId', $this->id)
                ->exists(); // Determine if any rows exist for the current query
        }
    }

    public function addOrRemove()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'Must be logged in to use the feature.');
        }

        $inFavorites = Favorite::where('user_id', auth()->user()->id)
            ->where('movieOrShowId', $this->id)
            ->exists(); // Determine if any rows exist for the current query

        if (!$inFavorites) {
            Favorite::create([
                'movieOrShowId' => $this->id,
                'user_id' => auth()->user()->id,
                'type' => $this->type
            ]);
            
            $this->added = true;
        } else {
            Favorite::where('user_id', auth()->user()->id)
                ->where('movieOrShowId', $this->id)
                ->delete();

            $this->added = false;
        }
    }

    public function render()
    {
        return view('livewire.favorites');
    }
}
