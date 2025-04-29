<?php

namespace App\Jobs;

use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class SendFormTelegram implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct
    (
        private array $validatedData
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //! CANNOT user Request facade here (static-looking interface to laravels service container)
        // When Request::validate() is called, Laravel is statically proxying to the actual Request object in the container
        // $validatedData = Request::validate([
        //     'email' => 'required',
        //     'subject' => ['required', 'min:5'],
        //     'body' => ['required', 'min:10']
        // ]);

        $encoded = urlencode("{$this->validatedData['email']}\n\n{$this->validatedData['subject']}\n\n{$this->validatedData['body']}");

        $token = config('telegram.token');
        $adminId = config('telegram.admin_id');
        $telegramUrl = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$adminId}&text={$encoded}";
        // Send message
        Http::get($telegramUrl);
    }
}
