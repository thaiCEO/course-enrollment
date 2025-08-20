<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Room; // ✅ Added Room model
use Illuminate\Http\Request;

class EnrollmentsController extends Controller
{
    public function List()
    {
        $enrollments = Enrollment::with(['student', 'course', 'teacher', 'room']) // ✅ Added room relation
                                ->paginate(10);

        return view('messages/enrollment/enrollment', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = Enrollment::with(['student', 'course', 'teacher', 'room']) // ✅ Added room relation
                                ->findOrFail($id);

        return view('messages/enrollment/show', compact('enrollment'));
    }

    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        $teachers = Teacher::all();
        $rooms = Room::all(); // ✅ Fetch rooms

        return view('messages/enrollment/form_enrollment', compact('students', 'courses', 'teachers', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'course_id'      => 'required|exists:courses,id',
            'teacher_id'     => 'nullable|exists:teachers,id',
            'room_id'        => 'nullable|exists:rooms,id', // ✅ Added validation
            'enrolled_date'  => 'required|date',
        ]);

        $room = Room::find($request->room_id);
    
        // Check room availability
        if ($room && $room->remainingCapacity() <= 0) {
            return redirect()->back()->withErrors(['room_id' => 'This room is full.']);
        }

        Enrollment::create($request->only([
            'student_id',
            'course_id',
            'teacher_id',
            'room_id',       // ✅ Added
            'enrolled_date'
        ]));

        return redirect()->route('enrollments.List')
                         ->with('success', __('messages.enrollment_created_success'));
    }

    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        $teachers = Teacher::all();
        $rooms = Room::all(); // ✅ Fetch rooms for edit form

        return view('messages/enrollment/enrollment_edit', compact('enrollment', 'students', 'courses', 'teachers', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id'    => 'required|exists:students,id',
            'course_id'     => 'required|exists:courses,id',
            'teacher_id'    => 'nullable|exists:teachers,id',
            'room_id'       => 'nullable|exists:rooms,id', // ✅ Added validation
            'enrolled_date' => 'required|date',
        ]);

        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update($request->only([
            'student_id',
            'course_id',
            'teacher_id',
            'room_id',      // ✅ Added
            'enrolled_date'
        ]));

        return redirect()->route('enrollments.List')
                         ->with('success', 'Enrollment updated successfully.');
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('enrollments.List')->with('success', 'Enrollment deleted.');
    }
}
