<?php

namespace App\Http\Controllers;

use App\Account;
use Adldap\AdldapException;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use App\Http\Controllers\SamsLogController;

class AccountsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return view('accounts.index');
    }

    /* # Active Directory management # */

    public function adIndex()
    {
        // Set ldap to null
        $ldap = null;

        // Return view for AD account search
        return view('accounts.ad.index', compact('ldap'));
    }

    public function adSearch()
    {
        // Validate the request
        request()->validate([
            'search' => 'required|min:3'
        ]);

        // Get ldap results
        $ldap = Adldap::search()->select('samaccountname', 'displayname', 'title' ,'company', 'employeetype')
            ->orWhereStartsWith('samaccountname', request()->search)
            ->orWhereContains('displayname', request()->search)
            ->whereHas('employeetype')
            ->whereNotEquals('employeetype', 'Elev')
            ->get();


        // Return view with results
        return view('accounts.ad.index', compact('ldap'));

    }

    public function adShow($account)
    {
        // Get the user
        $user = Adldap::search()->users()->find($account);

        // Get the users manager
        $manager = Adldap::search()->users()->findByDn($user->manager['0']);

        // Get the users direct reports
        $directreports = [];
        if($user->directreports != null)
        {
            foreach($user->directreports as $report)
            {
                array_push($directreports, Adldap::search()->users()->findByDn($report));
            }
        }

        // Return view with results
        return view('accounts.ad.show', compact('user', 'manager', 'directreports'));

    }

    public function resetPassword($account)
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

            return redirect(route('accounts.ad.show', $account))->with('status', 'Lösenordet har nollstälts');
        }
        catch(\Exception $e)
        {
            // If an exception is thrown return back with error
            return back()->with('error', 'Lösenordet uppfyller inte kritetierna.');
        }
    }

    public function unlockAccount($account)
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
        return redirect(route('accounts.ad.show', $account))->with('status', 'Kontot har låsts upp!');
    }

    /* # Consultant management # */

    public function store()
    {
        // Add account to database after validation
        $account = Account::create($this->validateRequest());

        // Create log message
        $logMessage = "Ett nytt konto för <b>" . request()->firstname . " " . request()->lastname . "</b> har beställts";

        // Log the creation of the account
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Tillägg', $logMessage);

        // Redirect the user to the new account
        return redirect($account->path())->with('status', 'Beställningen för kontot har mottagits');

    }

    public function update(Account $account)
    {
        // Update the account after validation
        $account->update($this->validateRequest());

        // Create log message
        $logMessage = "En ändring för  <b>" . request()->firstname . " " . request()->lastname . "</b>";

        // Log the creation of the account
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Ändring', $logMessage);

        // Redirect the user to the new account
        return redirect($account->path())->with('status', 'Ändringen har mottagits och kommer utföras vid nästa synk');
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



    /* # Helpers # */
    public function validateRequest()
    {
        return request()->validate([
            'uuid' => 'required|sometimes|unique:accounts',
            'firstname' => 'required|sometimes',
            'lastname' => 'required|sometimes',
            'title' => '',
            'mobile' => 'required|sometimes',
            'vht' => 'required|sometimes',
            'ansvar' => 'required|sometimes',
            'company' => 'required|sometimes',
            'consultantCompany' => 'required|sometimes',
            'department' => '',
            'managerUuid' => 'required|sometimes',
            'employeeType' => 'required|sometimes',
            'startDate' => 'required|sometimes',
            'endDate' => 'required|sometimes',
            'localAccount' => 'required|sometimes',
            'isEdu' => 'required|sometimes',
            'createdBy' => 'required|sometimes'
        ]);
    }
}