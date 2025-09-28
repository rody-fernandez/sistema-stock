<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:150']);
        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success','Cliente creado con éxito');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate(['name' => 'required|string|max:150']);
        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success','Cliente actualizado');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success','Cliente eliminado');
    }
}
