<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use Illuminate\Pagination\LengthAwarePaginator;

class PeopleViewModel extends ViewModel
{
    private array $personDetails;
    private array $movieCredits;
    public function __construct(array $personDetails, array $movieCredits)
    {
        $this->personDetails = $personDetails;
        $this->movieCredits = $movieCredits;
    }
    public function getPersonDetails()
    {
        // TODO: Merge only needed data
        return $this->personDetails;
    }

    public function getMovieCredits()
    {
        $perPage = 10;

        // Get current page from query string if not present default to1
        $currentPage = request()->input('page', 1);

        // Create collection from the movies array
        $collection = collect($this->movieCredits);

        // Slice the collection to get the items to display in current page
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);

        // Create paginatro
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems, // items
            $collection->count(), // total
            $perPage, // perPage
            $currentPage, // currentPage
        );


        return collect($paginatedItems->items())->map(function ($movie) {
            $imageUrl = $movie['poster_path'] ? "https://image.tmdb.org/t/p/original/" . $movie['poster_path'] : asset('images/notfound.jpg');

            return collect($movie)->merge([
                'poster_path' => $imageUrl,
                'genre_ids' => 'TODO: Add Genre', // TODO: Parse genres
                'vote_average' => round($movie['vote_average'], 1),
            ]);
        });
    }
}
