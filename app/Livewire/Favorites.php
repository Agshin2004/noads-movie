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
        $this->added = Favorite::where('user_id', auth()->user()->id)
            ->where('movieOrShowId', $this->id)
            ->exists();
    }

    public function addOrRemove()
    {
        $inFavorites = Favorite::where('user_id', auth()->user()->id)
            ->where('movieOrShowId', $this->id)
            ->exists();

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
