<?php

namespace App\Rules;

use Adldap\Models\User as LdapUser;
use Adldap\Laravel\Validation\Rules\Rule;

class IsAllowedLogin extends Rule
{
    /**
     * Determines if the user is allowed to authenticate.
     *
     * Only allows users in the `Admin` group to authenticate.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->user->inGroup(env('LOGIN_ACCESS_GROUP'), true);
    }
}
