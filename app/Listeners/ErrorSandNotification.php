<?php

namespace App\Listeners;

use App\Events\ErrorSand;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
Use Illuminate\Support\Facades\Response;
class ErrorSandNotification
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
     * @param  ErrorSand  $event
     * @return void
     */
    public function handle(ErrorSand $event)
    {
      echo  throwError($event->object);
    }
}
