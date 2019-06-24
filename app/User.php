<?php

namespace App;

use App\Rules\IsSoltakInfra;
use Adldap\Laravel\Traits\HasLdapUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasLdapUser;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /* # Helpers # */
    public function isAdmin()
    {
        return $this->ldap->inGroup(env('ADMIN_ACCESS_GROUP'));
    }

    public function isSystemAdmin()
    {
        if($this->isAdmin())
            return true;

        return $this->ldap->inGroup(env('SYSTEMADMIN_ACCESS_GROUP'));
    }

    public function isHR()
    {
        if($this->isAdmin())
            return true;

        return $this->ldap->inGroup(env('HR_ACCESS_GROUP'));
    }

    public function isServicedesk()
    {
        if($this->isAdmin())
            return true;

        return $this->ldap->inGroup(env('SERVICEDESK_ACCESS_GROUP'));
    }

    public function isSchoolAdmin()
    {
        if($this->isSchoolAdminKK() || $this->isSchoolAdminLE())
            return true;

        return false;
    }

    public function isSchoolAdminKK()
    {
        if($this->isAdmin() || $this->isServicedesk())
            return true;

        return $this->ldap->inGroup(env('SCHOOLADMINKK_ACCESS_GROUP'));
    }

    public function isSchoolAdminLE()
    {
        if($this->isAdmin() || $this->isServicedesk())
            return true;

        return $this->ldap->inGroup(env('SCHOOLADMINLE_ACCESS_GROUP'));
    }

    /* # Relationships # */
    public function logs()
    {
        return $this->hasMany(SamsLog::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function taks()
    {
        return $this->hasMany(ConsultantTask::class);
    }
}
