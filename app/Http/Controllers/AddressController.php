<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::with('addressable')->latest()->paginate(10);
        return view('messages/addresses/index', compact('addresses'));
    }

    public function create()
    {
        $students = Student::all(['id', 'username']); // adjust columns as you have
        $teachers = Teacher::all(['id', 'name']);
        return view('messages/addresses/create', compact('students', 'teachers'));
    }

    // --- Helper to normalize incoming request to addressable_type + addressable_id
    protected function normalizeOwnerFromRequest(Request $request): array
    {
        // If the form already sends the canonical fields, keep them.
        $type = $request->input('addressable_type');
        $id   = $request->input('addressable_id');

        // If your form sends separate student_id/teacher_id, map it:
        if (!$type || !$id) {
            if ($request->filled('student_id')) {
                $type = 'App\Models\Student';
                $id   = $request->input('student_id');
            } elseif ($request->filled('teacher_id')) {
                $type = 'App\Models\Teacher';
                $id   = $request->input('teacher_id');
            }
        }

        return [$type, $id];
    }

    public function store(Request $request)
    {
        // Normalize (supports either addressable_id or student_id/teacher_id)
        [$type, $id] = $this->normalizeOwnerFromRequest($request);

        $request->merge([
            'addressable_type' => $type,
            'addressable_id'   => $id,
            'is_main'          => $request->boolean('is_main'), // normalize checkbox
        ]);

        $request->validate([
            'addressable_type' => 'required|in:App\Models\Teacher,App\Models\Student',
            'addressable_id'   => 'required|integer',
            'address_line'     => 'required|string|max:255',
            'city'             => 'required|string|max:100',
            'phone'            => 'required|string|max:20',
            'is_main'          => 'nullable|boolean',
        ]);

        if ($request->is_main) {
            Address::where('addressable_type', $request->addressable_type)
                ->where('addressable_id', $request->addressable_id)
                ->update(['is_main' => false]);
        }

        Address::create([
            'addressable_type' => $request->addressable_type,
            'addressable_id'   => $request->addressable_id,
            'address_line'     => $request->address_line,
            'city'             => $request->city,
            'phone'            => $request->phone,
            'is_main'          => $request->is_main,
        ]);

       return redirect()->route('addresses.index')->with('success', 'បង្កើតអាសយដ្ឋានបានជោគជ័យ'); 
    }

    public function show($id)
    {
        $address = Address::with('addressable')->findOrFail($id);
        return view('messages/addresses/show', compact('address'));
    }

    public function edit($id)
    {
        $address  = Address::findOrFail($id);
        $students = Student::all(['id', 'username']);
        $teachers = Teacher::all(['id', 'name']);
        return view('messages/addresses/edit', compact('address', 'students', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);

        // Normalize (supports either addressable_id or student_id/teacher_id)
        [$type, $ownerId] = $this->normalizeOwnerFromRequest($request);

        $request->merge([
            'addressable_type' => $type,
            'addressable_id'   => $ownerId,
            'is_main'          => $request->boolean('is_main'),
        ]);

        $validator = Validator::make($request->all(), [
            'addressable_type' => 'required|string|in:App\Models\Student,App\Models\Teacher',
            'addressable_id'   => 'required|integer',
            'address_line'     => 'required|string|min:5',
            'city'             => 'required|string|min:2',
            'phone'            => 'required|string|min:6',
            'is_main'          => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ensure owner exists
        $ownerModel = $request->addressable_type;
        $owner      = $ownerModel::findOrFail($request->addressable_id);

        if ($request->is_main) {
            $owner->addresses()
                ->where('is_main', true)
                ->where('id', '!=', $address->id)
                ->update(['is_main' => false]);
        }

        $address->update([
            'addressable_type' => $request->addressable_type,
            'addressable_id'   => $request->addressable_id,
            'address_line'     => $request->address_line,
            'city'             => $request->city,
            'phone'            => $request->phone,
            'is_main'          => $request->is_main,
        ]);

        return redirect()->route('addresses.index')->with('success', 'កែប្រែអាសយដ្ឋានបានជោគជ័យ'); 
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();
        return redirect()->route('addresses.index')->with('success', 'លុបអាសយដ្ឋានបានជោគជ័យ'); 
    }
}
