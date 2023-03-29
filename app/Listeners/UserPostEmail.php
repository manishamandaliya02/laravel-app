<?php

namespace App\Listeners;

use App\Events\UserRegisterPostEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Mail\PostEmail;

class UserPostEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegisterPostEvent  $event
     * @return void
     */
    public function handle(UserRegisterPostEvent $event)
    {
        $userData = $event->user;
        for ($i=0; $i < count($userData) ; $i++) { 
            $name = $userData[$i]['name'];
            Mail::to($userData[$i]['email'])->queue(new PostEmail($name));
        }        
    }
}
