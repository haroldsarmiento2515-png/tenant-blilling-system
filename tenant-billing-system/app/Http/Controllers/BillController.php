<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Tenant;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::with('tenant')->get();
        return view('bills.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::all();
        return view('bills.create', compact('tenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'bill_number' => 'required|unique:bills,bill_number',
            'billing_date' => 'required|date',
            'due_date' => 'required|date|after:billing_date',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Bill::create($request->all());

        return redirect()->route('bills.index')
                         ->with('success', 'Bill created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        $bill->load('tenant', 'payments');
        return view('bills.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        $tenants = Tenant::all();
        return view('bills.edit', compact('bill', 'tenants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'bill_number' => 'required|unique:bills,bill_number,'.$bill->id,
            'billing_date' => 'required|date',
            'due_date' => 'required|date|after:billing_date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,overdue',
            'description' => 'nullable|string',
        ]);

        $bill->update($request->all());

        return redirect()->route('bills.index')
                         ->with('success', 'Bill updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        $bill->delete();

        return redirect()->route('bills.index')
                         ->with('success', 'Bill deleted successfully.');
    }
}