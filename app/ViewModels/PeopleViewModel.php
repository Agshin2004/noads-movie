<?php

namespace App\ViewModels;

use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;
use Illuminate\Pagination\LengthAwarePaginator;

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

        $perPage = 10;

        // Get current page from query string if not present default to1
        $currentPage = request()->input('page', 1);

        // Create collection from the movies array
        $collection = collect($this->filterByBest($this->movieCredits, $this->tvCredits));

        // Slice the collection to get the items to display in current page
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);

        // Create paginator
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,  // items
            $collection->count(),  // total
            $perPage,  // perPage
            $currentPage,  // currentPage
            [
                'path' => request()->url(),  // Keep the current url (default it would add page query to /)
                'query' => request()->query()  // keep the query params if filters added
            ]
        );

        // Assigning items to field so we can access it and render it on page
        $this->paginationLinks = $paginatedItems;
        return collect($paginatedItems->items())->map(function ($movie) {
            $imageUrl = $movie['poster_path'] ? 'https://image.tmdb.org/t/p/original/' . $movie['poster_path'] : asset('images/notfound.jpg');

            $genres = collect($movie['genre_ids'])->map(function($genreId) {
                return genres()[$genreId] ?? null;
            })
                ->filter() // remove nulls if genre is unknown
                ->implode(', ');

            
            return collect($movie)->merge([
                'poster_path' => $imageUrl,
                'genre_ids' => $genres,
                'release_date' => Carbon::parse($movie['release_date'] ?? $movie['first_air_date'])->format('Y F'),
                'vote_average' => round($movie['vote_average'], 1),
            ]);
        });
    }

    private function filterByBest(array $movieCredits, array $tvCredits)
    {
        $moviesShows = array_merge($movieCredits, $tvCredits);
        shuffle($moviesShows);

        // usort() - Sort an array by values using a user-defined comparison function
        usort($moviesShows, function ($a, $b) {
            if ($a['vote_average'] === $b['vote_average']) {
                return 0;
            }
            return $a['vote_average'] > $b['vote_average'] ? -1 : 1;
        });

        return $moviesShows;
    }
}
