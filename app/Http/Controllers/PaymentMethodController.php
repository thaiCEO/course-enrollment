<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
      /**
     * Display a listing of the payment methods.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('id', 'desc')->paginate(10);
        return view('messages/payment_method/index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new payment method.
     */
    public function create()
    {
        return view('messages/payment_method/create');
    }

    /**
     * Store a newly created payment method in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name',
        ]);

        PaymentMethod::create([
            'name' => $request->name,
        ]);

        return redirect()->route('payment-method.index')->with('success', 'វិធីសាស្ត្រទូទាត់ត្រូវបានបន្ថែមដោយជោគជ័យ');
    }

    /**
     * Display the specified payment method.
     */
    public function show($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('messages/payment_method/show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified payment method.
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('messages/payment_method/edit', compact('paymentMethod'));
    }

    /**
     * Update the specified payment method in storage.
     */
    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name,' . $paymentMethod->id,
        ]);

        $paymentMethod->update([
            'name' => $request->name,
        ]);

        return redirect()->route('payment-method.index')->with('success', 'វិធីសាស្ត្រទូទាត់ត្រូវបានកែប្រែដោយជោគជ័យ');
    }


    /**
     * Remove the specified payment method from storage.
     */
      public function destroy($id)
    {

        $paymentMethod = PaymentMethod::findOrFail($id);

        $paymentMethod->delete();

        return redirect()->route('payment-method.index')->with('success', 'វិធីសាស្ត្រទូទាត់ត្រូវបានលុបដោយជោគជ័យ');
    }

    
}
