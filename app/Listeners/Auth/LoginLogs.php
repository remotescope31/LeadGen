<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\UserLoginHistory;


class LoginLogs
{


    private $UserLoginHistory;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserLoginHistory $UserLoginHistory)
    {
        // the initialization of  private $UserLoginHistory;

        $this->UserLoginHistory = $UserLoginHistory;


    }


    public function handle(Login $event)
    {
        // from model UserLoginHistory

        $this->UserLoginHistory->setLogInLog();
    }
}
