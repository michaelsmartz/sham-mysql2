<?php

namespace App\Listeners;

use App\ShamUserProfile;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $profileId = $event->user->sham_user_profile_id;
        $s = ShamUserProfile::find($profileId);
        $allowedModules = $s->listMatrix();
        session(['allowedModules' => $allowedModules]);        
    }
}
