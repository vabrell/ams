<?php

namespace App\Console\Commands;

use App\ConsultantTask;
use Illuminate\Console\Command;
use Adldap\Laravel\Facades\Adldap;

class DisableAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts:disable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get account tasks that are inactive
        $activeTasks = ConsultantTask::where('endDate', Date('Y-m-d'))
                                        ->where('completed', 0)
                                        ->get();

        foreach($activeTasks as $task)
        {
            // Get account in Active Directory
            $adAccount = Adldap::search()->users()->find($task->account->accountname);

            // Check if the account is disabled
            if($adAccount->isActive())
            {
                // Empty current account control object
                $adAccount->setUserAccountControl('');

                // Get the account control object for the user
                $accountControl = $adAccount->getUserAccountControlObject();

                // Mark the account as enabled
                $accountControl->accountIsNormal();

                // Mark the account as disabled
                $accountControl->accountIsDisabled();

                // Set the account control object for the user
                $adAccount->setUserAccountControl($accountControl);

                // Save the user
                $adAccount->save();
            }

            // Mark task as completed
            $task->update([
                'completed' => 1
            ]);

        }


    }
}
