<?php

namespace App\Http\Controllers;

use App\Account;
use App\Customer;
use Adldap\Models\User;
use App\AccountCounter;
use App\ConsultantTask;
use Adldap\AdldapException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use App\Http\Controllers\SamsLogController;
use Adldap\Models\Attributes\AccountControl;

class AccountsController extends Controller
{

    public function index()
    {
        return view('accounts.index');
    }

    /* # Active Directory management # */

    public function employeeIndex()
    {
        // Set ldap to null
        $ldap = null;

        // Return view for AD account search
        return view('accounts.employee.index', compact('ldap'));
    }

    public function employeeSearch()
    {
        // Validate the request
        request()->validate([
            'search' => 'required|min:3'
        ],[
            'search.required' => 'Sökfältet måste fyllas i',
            'search.min' => 'Sökfältet måste innehålla minst :min tecken',
        ]);

        // Get ldap results
        $ldap = Adldap::search()->select('samaccountname', 'displayname', 'title' ,'company')
            ->orWhereStartsWith('samaccountname', request()->search)
            ->orWhereContains('displayname', request()->search)
            ->whereHas('employeetype')
            ->whereEquals('employeetype', 'Anställd')
            ->get();

        Arr::sort($ldap);

        // Return view with results
        return view('accounts.employee.index', compact('ldap'));

    }

    public function employeeShow($account)
    {
        // Get the user
        $user = Adldap::search()->users()->find($account);

        // Get the users manager
        $manager = Adldap::search()->users()->findByDn($user->manager['0']);

        // Get the users direct reports
        $directreports = [];
        $consultants = [];

        if($user->directreports != null)
        {
            foreach($user->directreports as $report)
            {
                $_directreport = Adldap::search()->users()->findByDn($report);

                    if($_directreport->employeetype[0] == 'Anställd')
                        array_push($directreports, $_directreport);
                    if($_directreport->employeetype[0] == 'Konsult')
                        array_push($consultants, $_directreport);
            }
        }

        // Get the users direct reports
        $groups = [];
        $applications = [];
        if($user->memberof != null)
        {
            foreach(Arr::sort($user->memberof) as $group)
            {
                $_group = Adldap::search()->groups()->findByDn($group);
                if(substr($_group->samaccountname[0], 0, 16) == "CS-SYS-SCCM-APP-")
                {
                    array_push($applications, $_group);
                }
                else {
                    array_push($groups, $_group);
                }
            }
        }

        // Return view with results
        return view('accounts.employee.show', compact('user', 'manager', 'directreports', 'consultants', 'groups', 'applications'));

    }

    /* # Consultant management # */

    public function create()
    {
        return view('accounts.consultants.create');
    }

    public function consultantIndex()
    {
        // Set account to null
        $account = null;

        // Return view for AD account search
        return view('accounts.consultants.index', compact('account'));
    }

    public function consultantSearch()
    {
        // Validate the request
        request()->validate([
            'search' => 'required|min:3'
        ],[
            'search.required' => 'Sökfältet måste fyllas i',
            'search.min' => 'Sökfältet måste innehålla minst :min tecken',
        ]);

        // Get ldap results
        $account = Account::orWhere('accountname', 'LIKE', '%' . request()->search . '%')
                            ->orWhere('firstname', 'LIKE', '%' . request()->search . '%')
                            ->orWhere('lastname', 'LIKE', '%' . request()->search . '%')
                            ->orWhere('fullname', 'LIKE', '%' . request()->search . '%')
                            ->orderBy('accountname')
                            ->get();

        // Return view with results
        return view('accounts.consultants.index', compact('account'));

    }

    public function show(Account $account)
    {
        // Get the account from Active Directory
        $adAccount = Adldap::search()->find($account->accountname);

        // Get server access groups
        $serverPrefix = 'CS-DS-LSA-';
        $serverSuffix = '-Administrator';
        $servergroups = [];
        if($adAccount->memberof != null)
        {
            foreach(Arr::sort($adAccount->memberof) as $group)
            {
                $_group = Adldap::search()->groups()->findByDn($group);
                if(substr($_group->samaccountname[0], 0, 10) == $serverPrefix && substr($_group->samaccountname[0], 18) == $serverSuffix)
                {
                    array_push($servergroups, $_group);
                }
            }
        }

        // Get last task for the consultant
        $lastTask = ConsultantTask::where('account_id', $account->id)
                                    ->where('completed', 0)
                                    ->orderBy('endDate', 'desc')
                                    ->first();

        return view('accounts.consultants.show', compact('account', 'adAccount', 'servergroups', 'lastTask'));
    }

    public function edit(Account $account)
    {
        // Return the user to the edit user view
        return view('accounts.consultants.edit', compact('account'));
    }

    public function active()
    {

        // Get last task for the consultant
        $tasks = ConsultantTask::where('startDate', '<=', Date('Y-m-d'))
                                    ->where('endDate', '>', Date('Y-m-d'))
                                    ->where('completed', 0)
                                    ->orderBy('startDate')
                                    ->get();


        return view('accounts.consultants.active', compact('tasks'));
    }

    public function createTask(Account $account)
    {
        // Get all customers
        $customers = Customer::orderBy('name')->get();

        // Return the user to the create task view
        return view('accounts.consultants.task', compact('account', 'customers'));
    }

    public function store()
    {
        // Add account to database after validation
        $account = auth()->user()->accounts()->create(request()->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'company' => 'required',
            ],[
            'firstname.required' => 'Förnamn måste fyllas i',
            'lastname.required' => 'Efternamn måste fyllas i',
            'email.required' => 'E-post måste fyllas i',
            'email.email' => 'E-psot måste vara i ett giltigt e-post format',
            'mobile.required' => 'Mobil måste fyllas i',
            'company.required' => 'Ett konsultbolag måste fyllas i',
            ])
        );

        // Add accountname and title to the newly created account
        $account->fresh()->update([
            'accountname' => 'a2cc' . $this->lastAccountCountPrefix(),
            'title' => 'Konsult - ' . request()->company,
            'fullname' => request()->firstname . ' ' . request()->lastname,
        ]);

        // Create a new Active Directory instance for the user account
        $adldap = Adldap::make()->user([
            'cn' => $account->fresh()->accountname,
            'samaccountname' => $account->fresh()->accountname,
            'userprincipalname' => $account->fresh()->accountname . '@vkis.se',
            'dn' => 'CN=' . $account->fresh()->accountname .',OU=Admin,OU=Users,OU=DS,OU=CS,DC=vkis,DC=se',
            'title' => $account->fresh()->title,
            'givenname' => $account->fresh()->firstname,
            'sn' => $account->fresh()->lastname,
            'displayname' => 'A2 ' . $account->fresh()->fullname,
            'description' => $account->fresh()->title,
            'extensionattribute7' => $account->fresh()->mobile,
            'mail' => $account->fresh()->email
        ]);

        // Set first time password
        $adldap->setPassword(Str::random(40));

        // Save the new Active Directory account
        $adldap->save();

        // Get the new user
        $adAccount = Adldap::search()->users()->find($account->fresh()->accountname);

        // Get default AD-groups
        $rdsF5 = Adldap::search()->groups()->find('CS-SYS-RDS 2016-Grant-Logon Access F5 ExternalUsers');
        $rdsRD = Adldap::search()->groups()->find('CS-SYS-RDS 2016-Soltak Blandat-Remote Desktop');
        $mgmtServer = Adldap::search()->groups()->find('CS-DS-LSA-MGMT-RDP');

        // Add the user to the groups
        $rdsF5->addMember($adAccount);
        $rdsRD->addMember($adAccount);
        $mgmtServer->addMember($adAccount);

        // Log the creation of the account
        $logMessage = 'Ett nytt konsultkonto har skapats för ' . $account->fullname() . ' (' . $account->company . ')';
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Tillägg', $logMessage);

        // Redirect the user to the new account
        return redirect($account->path())->with(
            'status',
            'Ett nytt konsultkonto har skapats'
        );

    }

    public function storeTask(Account $account)
    {
        // Add account to database after validation
        $account->tasks()->create(request()->validate([
            'name' => 'required',
            'customer_id' => 'required',
            'startDate' => 'required|date|after:yesterday',
            'endDate' => 'required|date|after:startDate',
            'description' => 'required'
            ],[
            'name.required' => 'Aktivitetsnamn måste fyllas i',
            'customer_id.required' => 'Kund måste väljas',
            'startDate.required' => 'Startdatum måste väljas',
            'startDate.after' => 'Startdatum måste vara idag eller senare',
            'endDate.required' => 'Slutdatum måste välajs',
            'endDate.after' => 'Slutdatum måste vara efter Startdatum',
            'description.required' => 'Beskrivning måste fyllas i',
            ])
        );

        if(request()->startDate == Date('Y-m-d')){
            // Get account in Active Directory
            $adAccount = Adldap::search()->find($account->accountname);

            // Activate account
            $adAccount->useraccountcontrol = AccountControl::NORMAL_ACCOUNT;

            // Save the change
            $adAccount->save();
        }

        // Log the creation of the account
        $logMessage = 'En aktivitet, <b>' . request()->name . '</b>, för konsult ' . $account->fullname() . ' (' . $account->accountname . ')';
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Tillägg', $logMessage);

        // Redirect the user to the new account
        return redirect($account->path())->with(
            'status',
            'En ny uppgift har lagts till'
        );
    }

    public function update(Account $account)
    {
        // Update the account after validation
        $account->update(request()->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'company' => 'required',
            ],[
            'firstname.required' => 'Förnamn måste fyllas i',
            'lastname.required' => 'Efternamn måste fyllas i',
            'email.required' => 'E-post måste fyllas i',
            'email.email' => 'E-psot måste vara i ett giltigt e-post format',
            'mobile.required' => 'Mobil måste fyllas i',
            'company.required' => 'Ett konsultbolag måste fyllas i',
            ])
        );

        // Update title and fullname in database
        $account->update([
            'title' => 'Konsult - ' . request()->company,
            'fullname' => request()->firstname . ' ' . request()->lastname,
        ]);

        // Get account in Active Directory
        $adAccount = Adldap::search()->find($account->accountname);

        // Update attributes
        $adAccount->title = $account->fresh()->title;
        $adAccount->givenname = $account->fresh()->firstname;
        $adAccount->sn = $account->fresh()->lastname;
        $adAccount->displayname = 'A2 ' . $account->fresh()->fullname;
        $adAccount->description = $account->fresh()->title;
        $adAccount->extensionattribute7 = $account->fresh()->mobile;
        $adAccount->mail = $account->fresh()->email;

        // Save the change to Active Directory
        $adAccount->save();

        // Create log message
        $logMessage = "En ändring för  <b>" . $account->fullname() . "</b> har utförts";

        // Log the creation of the account
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Ändring', $logMessage);

        // Redirect the user to the new account
        return redirect($account->path())->with('status', 'Ändringen har utförts');
    }

    public function destroy(Account $account)
    {
        // Delete the account from the database
        $account->delete();

        // Create log message
        $logMessage = "Kontot för  <b>" . request()->firstname . " " . request()->lastname . "</b> har tagists bort";

        // Log the creation of the account
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Borttag', $logMessage);

        // Redirect the user to the new account
        return redirect(route('accounts.index'))->with('status', 'Kontot har tagits bort');
    }


    /* # Students # */

    /* Kungälv */

    public function studentsKKIndex()
    {
        // Set ldap to null
        $ldap = null;

        // Return view for AD account search
        return view('accounts.students.kk.index', compact('ldap'));
    }

    public function studentsKKSearch()
    {
        // Validate the request
        request()->validate([
            'search' => 'required|min:3'
        ],[
            'search.required' => 'Sökfältet måste fyllas i',
            'search.min' => 'Sökfältet måste innehålla minst :min tecken',
        ]);

        // Get ldap results
        $ldap = Adldap::search()->users()->setDn('OU=EDU Kungälv,OU=Hosting,DC=vkis,DC=se')
            ->select('samaccountname', 'displayname', 'department', 'physicaldeliveryofficename')
            ->orWhereStartsWith('samaccountname', request()->search)
            ->orWhereContains('displayname', request()->search)
            ->get();

        Arr::sort($ldap);

        // Return view with results
        return view('accounts.students.kk.index', compact('ldap'));

    }

    public function studentsKKShow($account)
    {
        // Get the user
        $user = Adldap::search()->users()->setDn('OU=EDU Kungälv,OU=Hosting,DC=vkis,DC=se')->find($account);

        // Return view with results
        return view('accounts.students.kk.show', compact('user'));

    }

    /* Lilla Edet */

    public function studentsLEIndex()
    {
        // Set ldap to null
        $ldap = null;

        // Return view for AD account search
        return view('accounts.students.le.index', compact('ldap'));
    }

    public function studentsLESearch()
    {
        // Validate the request
        request()->validate([
            'search' => 'required|min:3'
        ],[
            'search.required' => 'Sökfältet måste fyllas i',
            'search.min' => 'Sökfältet måste innehålla minst :min tecken',
        ]);

        // Get ldap results
        $ldap = Adldap::search()->users()->setDn('OU=EDU Lilla Edet,OU=Hosting,DC=vkis,DC=se')
            ->select('samaccountname', 'displayname', 'department', 'physicaldeliveryofficename')
            ->orWhereStartsWith('samaccountname', request()->search)
            ->orWhereContains('displayname', request()->search)
            ->get();

        Arr::sort($ldap);

        // Return view with results
        return view('accounts.students.le.index', compact('ldap'));

    }

    public function studentsLEShow($account)
    {
        // Get the user
        $user = Adldap::search()->users()->setDn('OU=EDU Lilla Edet,OU=Hosting,DC=vkis,DC=se')->find($account);

        // Return view with results
        return view('accounts.students.le.show', compact('user'));

    }


    /* # Helpers # */

    private function lastAccountCountPrefix()
    {
        // Get the last count in the database
        $lastCount =  AccountCounter::orderBy('created_at', 'desc')->first()->count;

        // Add leading zeros
        $newCount = $lastCount+1;
        if($newCount <= 10000 && $newCount >= 1000)
            $newCount = 0 . $newCount;

        if($newCount < 1000)
            $newCount = 0 . 0 . $newCount;

        // Add new count to database
        $accountCounter = new AccountCounter();
        $accountCounter->create([
            'count' => $newCount
        ]);

        return $newCount;
    }

    public function serverAdd($account)
    {
        request()->validate([
            'servername' => 'required',
        ], [
            'servername.required' => 'Minst ett servernamn måste fyllas i.',
        ]);

        $user = Adldap::search()->users()->find($account);
        $dbuser = Account::where('accountname', $account)->first();

        $servers = explode(';', request()->servername);
        $serverPrefix = 'CS-DS-LSA-';
        $serverSuffix = '-Administrator';

        $failed = [];
        $exists = [];
        $success = [];

        foreach($servers as $server)
        {
            // Set the groupname
            $groupname = $serverPrefix . $server . $serverSuffix;

            // Try to find the server access group
            if(!$group = Adldap::search()->groups()->find($groupname))
            {
                // Push server to failed array
                array_push($failed, $server);
            }
            else {
                try
                {
                    // Add the user to the group
                    $group->addMember($user);

                    // Push server to success array
                    array_push($success, $server);

                    // Add log message
                    $logMessage = "Rättigheter för server <b>" . $server . "</b> har lats till för " . $dbuser->fullname() . ' (' . $dbuser->accountname . ')';
                    $log = new SamsLogController();
                    $log->addLog(auth()->user()->id, 'Ändring', $logMessage);
                }
                catch(\Exception $e)
                {
                    // Push server to exists array
                    array_push($exists, $server);
                }
            }
        }

        $status = [];

        if(!empty($failed))
            $staus['failed'] = 'Ingen rättighetsgrupp kunde hittas för följande serverar, vänligen kontrollera servernamnet och försök igen: ' . implode(',', $failed);

        if(!empty($exists))
            $status['exists'] = 'Rättigheter för följande serverar fanns redan: ' . implode(',', $exists);

        if(!empty($success))
            $status['status'] = 'Rättigheter för följande serverar har lagts till: ' . implode(',', $success);

        return redirect(route('accounts.consultants.show', $dbuser->id))->with($status);

    }

    public function resetPassword($account, $type)
    {
        request()->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ], [
            'password.required' => 'Lösenordet uppfyller inte kritetierna.',
            'password.min' => 'Lösenordet uppfyller inte kritetierna.',
            'password_confirmation.required' => 'Lösenordet måste upprepas.',
            'password_confirmation.same' => 'Det upprepade lösenordet stämmer itne.',
        ]);

        // Get the user
        $user = Adldap::search()->users()->find($account);

        // Set the new password
        $user->setPassword(request()->password);

        try{
            // Try to save the user to AD
            $user->save();

            // Add log message
            $logMessage = "Nollställt lösenord för användare: <b>" . $user->displayname[0] . " (" . $user->samaccountname[0] . ")</b>";
            $log = new SamsLogController();
            $log->addLog(auth()->user()->id, 'Ändring', $logMessage);

            $statusMessage = 'Lösenordet har nollstälts';

            if($type == 'consultant')
            {
                $consultant = Account::where('accountname', $account)->first();
                return redirect(route('accounts.consultants.show', $consultant->id))->with('status', $statusMessage);
            }

            if($type == 'employee')
            {
                return redirect(route('accounts.employee.show', $account))->with('status', $statusMessage);
            }
        }
        catch(\Exception $e)
        {
            // If an exception is thrown return back with error
            return back()->with('error', 'Lösenordet uppfyller inte kritetierna. ');
        }
    }

    public function unlockAccount($account, $type)
    {
        // Get the user
        $user = Adldap::search()->users()->find($account);

        // Clear lockout time
        $user->setClearLockoutTime();

        // Save the user
        $user->save();

        // Add log message
        $logMessage = "Låst upp AD konto : <b>" . $user->displayname[0] . " (" . $user->samaccountname[0] . ")</b>";
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Ändring', $logMessage);

        // Return the user to the account
        return redirect(route('accounts.employee.show', $account))->with('status', 'Kontot har låsts upp!');
    }

}
