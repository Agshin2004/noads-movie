<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ReCaptcha
{
    public $privatekey;

    public function __construct()
    {
        $this->privatekey = config('recaptcha.privatekey');
    }

    public function validateRequest($userResponse)
    {
        $options = [
            'secret' => $this->privatekey,
            'response' => $userResponse
        ];
        // asForm sends the data as application/x-www-form-urlencoded not raw JSON 
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', $options)->json();

        return $response['success'];
    }
}
