<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{

    public function index()
    {
        // Get all customers
        $customers = Customer::orderBy('name')->paginate(15);

        // Return the user to the index view
        return view('settings.customer.index', compact('customers'));
    }

    public function create(Customer $customer)
    {
        // Return the user to the index view
        return view('settings.customer.create');
    }

    public function edit(Customer $customer)
    {
        // Return the user to the edit view
        return view('settings.customer.edit', compact('customer'));
    }

    public function store()
    {
        // Validate the request and add the customer to the database
        $customer = Customer::create(request()->validate([
            'name' => 'required|min:2'
        ],[
            'name.required' => 'Ett namn på företaget måste anges',
            'name.min' => 'Namnet på företaget måste vara minst :min tecken långt'
        ]));

        // Log the creation of the customer
        $logMessage = '<b>' . request()->name . '</b> har lagts till som en ny kund';
        $log = new SamsLogController();
        $log->addLog(auth()->user()->id, 'Tillägg', $logMessage);

        // Return the user to the customer index
        return redirect(route('settings.customer.index'))->with('status', 'Kunden har lagts till');
    }

    public function update(Customer $customer)
    {
        $oldname = $customer->name;

        // Validate the request and update the customer to the database
        $customer->update(request()->validate([
            'name' => 'required|min:2'
        ],[
            'name.required' => 'Ett namn på företaget måste anges',
            'name.min' => 'Namnet på företaget måste vara minst :min tecken långt'
        ]));

        if(request()->name != $oldname)
        {
            // Log the update of the customer
            $logMessage = 'Kunden <b>' . $oldname . '</b> har ändrat namn till ' . request()->name;
            $log = new SamsLogController();
            $log->addLog(auth()->user()->id, 'Tillägg', $logMessage);
        }

        // Return the user to the customer index
        return redirect(route('settings.customer.index'))->with('status', 'Kunden har updaterats');
    }
}
