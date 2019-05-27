<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Session;
use Adldap\Laravel\Events\AuthenticationRejected;

class LogAuthRejected
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
     * @param  AuthenticationRejected  $event
     * @return void
     */
    public function handle(AuthenticationRejected $event)
    {
        Session::flash('error.ldap', "You don't have the permission to login!");
    }
}
