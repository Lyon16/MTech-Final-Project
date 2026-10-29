<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    // Display all customers
    public function index()
    {
        $customers = Customer::orderByDesc('id')->paginate(10);

        return view('customers.index', compact('customers'));
    }

    // Show the Add Customer form
    public function create()
    {
        return view('customers.create');
    }

    // Save a new customer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $validated['created_at'] = now();

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer added successfully!');
    }

    // Display one customer
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    // Show the Edit Customer form
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Update an existing customer
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    // Delete a customer without sales history
    public function destroy(Customer $customer)
    {
        return DB::transaction(function () use ($customer) {
            $customer = Customer::query()
                ->lockForUpdate()
                ->findOrFail($customer->id);

            if ($customer->sales()->exists()) {
                return redirect()->route('customers.index')
                    ->with('error',
                        'This customer has sales records and cannot be deleted.');
            }

            $customer->delete();

            return redirect()->route('customers.index')
                ->with('success', 'Customer deleted successfully!');
        });
    }
}
