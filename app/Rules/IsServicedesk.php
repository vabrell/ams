<?php

namespace App\Rules;

use Adldap\Models\User as LdapUser;
use Adldap\Laravel\Validation\Rules\Rule;

class IsServicedesk extends Rule
{
    /**
     * Determines if the user is allowed to authenticate.
     *
     * Only allows users in the `Accounting` group to authenticate.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->user->inGroup(env('SERVICEDESK_ACCESS_GROUP'));
    }
}
