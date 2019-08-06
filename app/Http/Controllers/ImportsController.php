<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;

class ImportsController extends Controller
{

    public function index()
    {

        $ldap = Adldap::search()->users()->setDn(env('LDAP_IMPORT_DN'))
            ->select('samaccountname', 'displayname', 'description')
            ->notFilter(function ($q) {

                $accounts = Account::select('accountname')->get();
                $account_names = [];
                foreach($accounts as $account)
                {
                    array_push($account_names, $account->accountname);
                }

                $q->whereIn('samaccountname', $account_names);

            })->sortBy('samaccountname', 'asc')->get();

        return view('settings.import.index', compact('ldap'));
    }

    public function show($account)
    {
        $account = Adldap::search()->users()->find($account);

        return view('settings.import.show', compact('account'));
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
            'accountname' => 'required'
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
            'title' => 'Konsult - ' . request()->company,
            'fullname' => request()->firstname . ' ' . request()->lastname,
        ]);

        // Get the user
        $adAccount = Adldap::search()->users()->find($account->fresh()->accountname);

        // Remove account expire date
        $adAccount->accountExpires = 0;

        // Set account ext7
        $adAccount->extensionattribute7 = $account->fresh()->mobile;

        // Set account company
        $adAccount->company = $account->fresh()->company;

        // Set account title
        $adAccount->title = $account->fresh()->title;

        // Set account email
        $adAccount->mail = $account->fresh()->email;

        // Get the account control object for the user
        $accountControl = $adAccount->getUserAccountControlObject();

        // Mark the account as disabled
        $accountControl->accountIsDisabled();

        // Set the account control object for the user
        $adAccount->setUserAccountControl($accountControl);

        $adAccount->save();

        // Get default AD-groups
        $rdsF5 = Adldap::search()->groups()->find('CS-SYS-RDS 2016-Grant-Logon Access F5 ExternalUsers');
        $rdsRD = Adldap::search()->groups()->find('CS-SYS-RDS 2016-Soltak Blandat-Remote Desktop');
        $mgmtServer = Adldap::search()->groups()->find('CS-DS-LSA-MGMT-RDP');


        // Add the user to the groups
        try{
            $rdsF5->addMember($adAccount);
            $rdsRD->addMember($adAccount);
            $mgmtServer->addMember($adAccount);
        }catch(\Exception $e){}

        return redirect(route('settings.import.index'))->with(
            'status',
            'A2-konto har importerats'
        );
    }
}
