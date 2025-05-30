<?php



function genres()
{
    return [
        28 => 'Action',
        12 => 'Adventure',
        16 => 'Animation',
        35 => 'Comedy',
        80 => 'Crime',
        99 => 'Documentary',
        18 => 'Drama',
        10751 => 'Family',
        14 => 'Fantasy',
        36 => 'History',
        27 => 'Horror',
        10402 => 'Music',
        9648 => 'Mystery',
        10749 => 'Romance',
        878 => 'Science Fiction',
        10770 => 'TV Movie',
        53 => 'Thriller',
        10752 => 'War',
        37 => 'Western',
        10759 => 'Action & Adventure',
        10762 => 'Kids',
        10763 => 'News',
        10764 => 'Reality',
        10765 => 'Sci-Fi & Fantasy',
        10766 => 'Soap',
        10767 => 'Talk',
        10768 => 'War & Politics',
    ];
}

function countries()
{
    return [
        'AF' => 'Afghanistan',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BD' => 'Bangladesh',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia and Herzegovina',
        'BR' => 'Brazil',
        'BG' => 'Bulgaria',
        'CA' => 'Canada',
        'CL' => 'Chile',
        'CN' => 'China',
        'CO' => 'Colombia',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'EE' => 'Estonia',
        'FI' => 'Finland',
        'FR' => 'France',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GR' => 'Greece',
        'GT' => 'Guatemala',
        'HN' => 'Honduras',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JP' => 'Japan',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KR' => 'South Korea',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MY' => 'Malaysia',
        'MX' => 'Mexico',
        'MD' => 'Moldova',
        'MA' => 'Morocco',
        'NL' => 'Netherlands',
        'NZ' => 'New Zealand',
        'NG' => 'Nigeria',
        'MK' => 'North Macedonia',
        'NO' => 'Norway',
        'PK' => 'Pakistan',
        'PA' => 'Panama',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'RO' => 'Romania',
        'RU' => 'Russia',
        'SA' => 'Saudi Arabia',
        'RS' => 'Serbia',
        'SG' => 'Singapore',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'ZA' => 'South Africa',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syria',
        'TW' => 'Taiwan',
        'TH' => 'Thailand',
        'TR' => 'Turkey',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VE' => 'Venezuela',
        'VN' => 'Vietnam',
        'YE' => 'Yemen',
        'ZW' => 'Zimbabwe',
    ];
}

function movieOrShowLink(string $mediaType, int $id)
{
    return "/watch/$mediaType/$id";
}

function makeGenresFromIds(array $genreIds)
{
    return collect($genreIds)->map(function ($genreId) {
        return genres()[$genreId];
    });
}

function mediaTypes()
{
    return ['movie', 'tv'];
}

function sortingOptions()
{
    return [
        'popularity.asc',
        'popularity.desc',
        'vote_average.asc',
        'vote_average.desc',
        'vote_count.asc',
        'vote_count.desc',
        'primary_release_date.asc',
        'primary_release_date.desc',
    ];
}

function includeOptions()
{
    // NOTE: Include options must match the name of the endpoint
    return [
        'recommendations'
    ];
}

function getTmdbToken()
{
    return config('moviedb.api_key');
}
