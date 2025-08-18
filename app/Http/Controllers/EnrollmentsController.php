<?php

namespace App\Http\Controllers;

use App\Models\course;
use App\Models\Enrollment;
use App\Models\enrollments;
use App\Models\student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class EnrollmentsController extends Controller
{
     public function List()
    {
        $enrollments = Enrollment::with(['student', 'course', 'teacher'])->paginate(10);
        return view('messages/enrollment/enrollment', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = Enrollment::with(['student', 'course', 'teacher'])->findOrFail($id);
        return view('messages/enrollment/show', compact('enrollment'));
    }

    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        $teachers = Teacher::all(); // Add teachers for selection
        return view('messages/enrollment/form_enrollment', compact('students', 'courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'nullable|exists:teachers,id', // <- changed to nullable
            'enrolled_date' => 'required|date',
        ]);

        Enrollment::create($request->only(['student_id', 'course_id', 'teacher_id', 'enrolled_date']));

        return redirect()->route('enrollments.List')
                         ->with('success', __('messages.enrollment_created_success'));
    }

    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        $teachers = Teacher::all(); // Add teachers for selection
        return view('messages/enrollment/enrollment_edit', compact('enrollment', 'students', 'courses', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'nullable|exists:teachers,id', // <- changed to nullable
            'enrolled_date' => 'required|date',
        ]);

        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update($request->only(['student_id', 'course_id', 'teacher_id', 'enrolled_date']));

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
