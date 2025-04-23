<?php

function reformatGenres(array $genres)
{
    // flat collection will be returned
    $genresName = collect($genres)->mapWithKeys(function ($genreKey) {
        return [$genreKey['id'] => $genreKey['name']];
    });
    return $genresName;
}

function movieOrShowLink(string $mediaType, int $id)
{
    return "/watch/$mediaType/$id";
}