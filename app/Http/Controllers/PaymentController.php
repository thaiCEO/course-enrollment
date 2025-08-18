<?php

namespace App\Http\Controllers;

use App\Models\Payment;

use App\Models\Admin;
use App\Models\Enrollment;
use App\Models\enrollments;
use App\Models\PaymentMethod;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {

        $paymentMethods = PaymentMethod::all();

        $payments = Payment::with(['enrollment.student', 'createdByAdmin', 'updatedByAdmin'])->latest()->paginate(10);
        return view('messages/payment/index', compact('payments' , 'paymentMethods'));
    }


    public function create()
    {
        $enrollments = Enrollment::with('student')->get();
        $paymentMethods = PaymentMethod::all();
        return view('messages/payment/create', compact('enrollments' , 'paymentMethods'));
    }

public function store(Request $request)
{
    $request->validate([
        'enrollment_id' => 'required|exists:enrollments,id',
        'status' => 'required|string',
        'payment_method_id' => 'required|exists:payment_methods,id',
        'paid_at' => 'nullable|date',
        'amount' => 'nullable|numeric|min:0',
    ]);

    $enrollment = Enrollment::with('course')->findOrFail($request->enrollment_id);

    $paidAt = $request->paid_at ? Carbon::parse($request->paid_at)->format('Y-m-d H:i:s') : null;

    $payment = Payment::create([
        'enrollment_id' => $request->enrollment_id,
        'status' => $request->status,
        'payment_method_id' => $request->payment_method_id,
        'amount' => $enrollment->course->price ?? 0,  // Use 0 if no price found
        'paid_at' => $paidAt,
        'created_by_admin_id' => Auth::id(),
    ]);

    // ✅ Build message
  
    // Load relations to avoid N+1
    $paidAt = $request->paid_at ? Carbon::parse($request->paid_at) : null;
    $payment->load('enrollment.student', 'enrollment.course', 'paymentMethod');

    $message = "🧾 ការទូទាត់ថ្មី\n"
             . "👨‍🎓 សិស្ស៖ " . ($payment->enrollment->student->username ?? 'N/A') . "\n"
             . "🔢 លេខសិស្ស៖ " . ($payment->enrollment->student->student_number ?? 'N/A') . "\n"
             . "📚 វគ្គ៖ " . ($payment->enrollment->course->title ?? 'N/A') . "\n"
             . "💲 តម្លៃវគ្គ៖ " . (isset($payment->enrollment->course->price) ? number_format($payment->enrollment->course->price, 2) . ' USD' : 'N/A') . "\n"
             . "💳 វិធីសាស្ត្រទូទាត់៖ " . ($payment->paymentMethod->name ?? 'N/A') . "\n"
             . "📅 ថ្ងៃបង់៖ " . ($paidAt instanceof \Carbon\Carbon  ? $paidAt->format('d M Y H:i'): now()->format('d M Y H:i') ). "\n"
             . "📌 ស្ថានភាព៖ {$payment->status}";

    // ✅ Send to Telegram (direct instance)
    (new \App\Services\TelegramService())->sendMessage($message);

    

   return redirect()->route('payment.index')->with('success', __('messages.payment_created_success'));

}

    public function show($id)
    {
        $payment = Payment::with(['enrollment.student', 'enrollment.course', 'createdByAdmin', 'updatedByAdmin', 'paymentMethod'])->findOrFail($id);
        return view('messages/payment/show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $enrollments = Enrollment::with('student')->get();
        $paymentMethods = PaymentMethod::all(); // ✅ load payment methods
         return view('messages/payment/edit', compact('payment', 'enrollments', 'paymentMethods'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'status' => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'paid_at' => 'nullable|date',
            'amount' => 'nullable|numeric|min:0',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update([
            'enrollment_id' => $request->enrollment_id,
            'status' => $request->status,
            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount, // Added amount update
            'paid_at' => $request->paid_at,
            'updated_by_admin_id' => Auth::user()->id ?? null,
        ]);

        return redirect()->route('payment.index')->with('success', 'ការបង់ប្រាក់ត្រូវបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ');
    }
    

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('payment.index')->with('success', 'ការបង់ប្រាក់ត្រូវបានលុបដោយជោគជ័យ');
    }
}
