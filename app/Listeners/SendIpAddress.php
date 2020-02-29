<?php
namespace App\Listeners;
use App\Events\UserLoggedIn;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
class SendIpaddress
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
     * @param  UserLoggedIn  $event
     * @return void
     */
    public function handle(UserLoggedIn $event)
    {
        // we can send raw emails or we can create mail files and send them over
        Mail::raw('you just logged in from :'.Request::ip(), function($msg) use ($event) { $msg->to([$event->request->email]); $msg->from(['blog@blog.com']); });
    }
}
