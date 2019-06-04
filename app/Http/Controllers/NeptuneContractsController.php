<?php

namespace App\Http\Controllers;

use App\NeptuneRole;
use App\NeptuneContract;
use Illuminate\Http\Request;
use App\Http\Controllers\SamsLogController;

class NeptuneContractsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(NeptuneContract $contract)
    {
        // Return view to show specific contract
        return view('neptune.contracts.show', compact('contract'));
    }

    public function edit(NeptuneContract $contract)
    {
        // Get all roles
        $roles = NeptuneRole::orderBy('name')->get();

        // Return edit view for specific contract
        return view('neptune.contracts.edit', compact('contract', 'roles'));
    }

    public function create()
    {
        // Return create view
        return view('neptune.contracts.create');
    }

    public function store()
    {
        // Validate the contract request and then store it in the database
        $contract = NeptuneContract::create($this->validateRequest());

        // Log message
        $logMessage = "Ett nytt Neptune Avtal har lagts till: <b>" . request()->code . " - " . request()->name . "</b>";

        // Add the log
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Tillägg', $logMessage);

        // Redirect back to the created contract
        return redirect($contract->path())->with('status', 'Tillägg av avtal lyckades!');
    }

    public function update(NeptuneContract $contract)
    {
        $old_name = $contract->name;
        $old_role = $contract->role_id;

        // Validate the contract request and then update it in the database
        request()->role_id == 0 ? $exception = true : $exception = false;
        $contract->update($this->validateRequest($exception));

        if($exception == true)
        {
            // Remove relationthip
            $this->removeRelationship($contract);
        }

        if($old_name != request()->name)
        {
            // Log message
            $logMessage = "Neptune Avtals namn var ändrat från <b>" . $old_name . "</b> till " . request()->name . "</b>";

            // Add the log
            $log = new SamsLogController();
            $log->addLog(auth()->user()->id, 'Uppdatering', $logMessage);
        }

        if($old_role != request()->role_id && $exception == false){
            // Log message
            $logMessage = "Neptune Avtal <b>" . $contract->name . "</b> kopplades till roll <b>" . $contract->fresh()->role->name . "</b>";

            // Add the log
            $log = new SamsLogController();
            $log->addLog(auth()->user()->id, 'Uppdatering', $logMessage);
        }

        // Redirect back to the updated contract
        return redirect($contract->path())->with('status', 'Uppdateringen av avtalet lyckades!');
    }

    public function addRelationship(NeptuneContract $contract, NeptuneRole $role)
    {
        $contract->update([
            'role_id' => $role->id
        ]);

        // Log message
        $logMessage = "Neptune Avtal <b>" . $contract->name . "</b> kopplades till roll <b>" . $contract->fresh()->role->name . "</b>";

        // Add the log
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Uppdatering', $logMessage);
    }

    public function removeRelationship(NeptuneContract $contract)
    {
        $role_name = $contract->role->name;

        $contract->update([
            'role_id' => 0
        ]);

        // Log message
        $logMessage = "Neptune Avtal <b>" . $contract->name . "</b> kopplades ifrån roll <b>" . $role_name . "</b>";

        // Add the log
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Borttag', $logMessage);
    }

    public function removeRelationshipOnRoleDelete($role_id)
    {
        NeptuneContract::where('role_id', $role_id)->update(['role_id' => 0]);
    }

    public function destroy(NeptuneContract $contract)
    {
        $old_name = $contract->name;

        // Remove the contract from the database
        $contract->delete();

        // Log message
        $logMessage = "Neptune Avtal <b>" . $old_name. "</b> togs bort";

        // Add the log
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Borttag', $logMessage);

        // Redirect back to neptune index
        return redirect()->route('neptune.index')->with('status', 'Borttagningen av avtalet lyckades!');
    }

    protected function validateRequest($exception)
    {
        if($exception == true)
            return request()->validate([
                'code' => 'required|unique:neptune_contracts|sometimes',
                'name' => 'required|sometimes',
            ]);

        return request()->validate([
            'code' => 'required|unique:neptune_contracts|sometimes',
            'name' => 'required|sometimes',
            'role_id' => 'required|sometimes|exists:neptune_roles,id'
        ]);
    }
}
