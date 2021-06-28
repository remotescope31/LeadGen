<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use App\UserLoginHistory;


class LogoutLogs
{

    private $UserLogoutHistory;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserLoginHistory $UserLoginHistory)
    {
        // the initialization of  private $UserLogoutHistory;

        $this->UserLogoutHistory = $UserLoginHistory;
    }


    public function handle(Logout $event)
    {

        //dd(request()->session()->getId());
        // from model UserLoginHistory
        $this->UserLogoutHistory->setLogOutLog();
    }
}
