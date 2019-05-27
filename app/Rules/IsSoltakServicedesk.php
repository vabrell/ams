<?php

namespace App\Rules;

use Adldap\Models\User as LdapUser;
use Adldap\Laravel\Validation\Rules\Rule;

class IsSoltakServicedesk extends Rule
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
        return $this->user->inGroup(env('SOLTAK_SERVICEDESK_ACCESS_GROUP'));
    }
}
