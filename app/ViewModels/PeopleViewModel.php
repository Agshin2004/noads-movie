<?php

namespace App\ViewModels;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

class PeopleViewModel extends ViewModel
{
    public LengthAwarePaginator $paginationLinks;
    private array $personDetails;
    private array $movieCredits;
    private array $tvCredits;

    public function __construct(array $personDetails, array $movieCredits, array $tvCredits)
    {
        $this->personDetails = $personDetails;
        $this->movieCredits = $movieCredits;
        $this->tvCredits = $tvCredits;
    }

    public function getPersonDetails()
    {
        // TODO: Merge only needed data
        return collect($this->personDetails)->merge([
            'biography' => $this->personDetails['biography'] ?: 'No Biography Available'
        ]);
    }

    public function getCredits()
    {
        $this->filterByBest();
        $moviesShows = array_merge($this->movieCredits, $this->tvCredits);

        $perPage = 10;

        // Get current page from query string if not present default to1
        $currentPage = request()->input('page', 1);

        // Create collection from the movies array
        $collection = collect($moviesShows);

        // Slice the collection to get the items to display in current page
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);

        // Create paginatro
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,  // items
            $collection->count(),  // total
            $perPage,  // perPage
            $currentPage,  // currentPage
            [
                'path' => request()->url(),  // Keep the current url (default it would add page query to /)
                'query' => request()->query()  // keep the query params if filters added; TODO: Make filtering movies
            ]
        );

        // Assigning items to field so we can access it and render it on page
        $this->paginationLinks = $paginatedItems;

        return collect($paginatedItems->items())->map(function ($movie) {
            $imageUrl = $movie['poster_path'] ? 'https://image.tmdb.org/t/p/original/' . $movie['poster_path'] : asset('images/notfound.jpg');

            return collect($movie)->merge([
                'poster_path' => $imageUrl,
                'genre_ids' => 'TODO: Add Genre',  // TODO: Parse genres
                'vote_average' => round($movie['vote_average'], 1),
            ]);
        });
    }

    private function filterByBest()
    {
        // usort() - Sort an array by values using a user-defined comparison function
        usort($this->movieCredits, function ($a, $b) {
            if ($a['vote_average'] === $b['vote_average']) {
                return 0;
            }
            return $a['vote_average'] > $b['vote_average'] ? -1 : 1;
        });

        usort($this->tvCredits, function ($a, $b) {
            if ($a['vote_average'] === $b['vote_average']) {
                return 0;
            }
            return $a['vote_average'] > $b['vote_average'] ? -1 : 1;
        });
    }
}
