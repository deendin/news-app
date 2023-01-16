<?php

namespace App\Listeners;

use App\Mail\SendNewsCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewsCreatedEmail
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        try {
            $news = $event->news;
            $user = $news->user;

            \Log::info('News created');

            Mail::to($user->email)
                ->queue(
                    new SendNewsCreatedMail($news, $user)
                );
            
        } catch (\Throwable $th) {
            // fail safe mechanism
            \Log::info($th->getMessage());
        }
    }
}
