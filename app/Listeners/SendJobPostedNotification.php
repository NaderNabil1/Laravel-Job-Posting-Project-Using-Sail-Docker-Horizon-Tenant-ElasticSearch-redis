<?php

use Illuminate\Contracts\Queue\ShouldQueue;

class SendJobPostedNotification implements ShouldQueue
{
    public $queue = 'events';

    public function handle(\App\Events\JobPosted $event): void
    {
        //We can send email here or notification whatever
    }
}
