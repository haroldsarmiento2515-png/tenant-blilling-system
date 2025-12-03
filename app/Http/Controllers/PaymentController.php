<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Bill;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('bill.tenant')->get();
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bills = Bill::all();
        return view('payments.create', compact('bills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'transaction_id' => 'nullable|string|max:100',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        Payment::create($request->all());

        // Update the bill's paid amount
        $bill = Bill::find($request->bill_id);
        $bill->paid_amount += $request->amount;
        
        // Update status based on remaining balance
        if ($bill->remainingBalance() <= 0) {
            $bill->status = 'paid';
        } elseif ($bill->due_date < now() && $bill->remainingBalance() > 0) {
            $bill->status = 'overdue';
        }
        
        $bill->save();

        return redirect()->route('payments.index')
                         ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load('bill.tenant');
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $bills = Bill::all();
        return view('payments.edit', compact('payment', 'bills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'transaction_id' => 'nullable|string|max:100',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Adjust the bill's paid amount
        $originalAmount = $payment->amount;
        $payment->update($request->all());
        
        // Update the bill's paid amount
        $bill = Bill::find($request->bill_id);
        $bill->paid_amount += ($request->amount - $originalAmount);
        
        // Update status based on remaining balance
        if ($bill->remainingBalance() <= 0) {
            $bill->status = 'paid';
        } elseif ($bill->due_date < now() && $bill->remainingBalance() > 0) {
            $bill->status = 'overdue';
        } else {
            $bill->status = 'pending';
        }
        
        $bill->save();

        return redirect()->route('payments.index')
                         ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        // Adjust the bill's paid amount
        $bill = $payment->bill;
        $bill->paid_amount -= $payment->amount;
        
        // Update status based on remaining balance
        if ($bill->remainingBalance() <= 0) {
            $bill->status = 'paid';
        } elseif ($bill->due_date < now() && $bill->remainingBalance() > 0) {
            $bill->status = 'overdue';
        } else {
            $bill->status = 'pending';
        }
        
        $bill->save();
        
        $payment->delete();

        return redirect()->route('payments.index')
                         ->with('success', 'Payment deleted successfully.');
    }
}