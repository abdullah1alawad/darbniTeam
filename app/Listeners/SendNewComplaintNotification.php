<?php

namespace App\Listeners;

use App\Events\NewComplaintEvent;
use App\Models\User;
use App\Notifications\NewComplaintNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewComplaintNotification
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
     * @param  \App\Events\NewComplaintEvent  $event
     * @return void
     */
    public function handle(NewComplaintEvent $event)
    {
        // Access the complaint and send the notification
        $complaint = $event->complaint;

        // Get all admin users who should receive the notification
        $adminUsers = User::where('role', 1)->get();

        foreach ($adminUsers as $admin) {
            $admin->notify(new NewComplaintNotification($complaint));
        }
    }
}
