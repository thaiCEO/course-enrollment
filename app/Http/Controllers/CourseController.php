<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    // Show list of courses
    public function List()
    {
        $courses = Course::with('teacher')->paginate(10);
        return view('messages.course.course', compact('courses'));
    }

    // Show create form
    public function create()
    {
        $teachers = Teacher::all();
        return view('messages.course.form_course', compact('teachers'));
    }

    // Store new course
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:teachers,id',
            'course_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $imageName = null;
        if ($request->hasFile('course_image')) {
            $imageName = time() . '.' . $request->course_image->extension();
            $request->course_image->move(public_path('courses'), $imageName);
        }

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'teacher_id' => $request->teacher_id,
            'course_image' => $imageName,
            'price' => $request->price,
            // Store is_active as 1 or 0
            'is_active' => $request->has('is_active') && $request->is_active == '1' ? 1 : 0,
        ]);

       return redirect()->route('courses.List')->with('success', 'បញ្ចូលមុខវិជ្ជា​ដោយ​ជោគជ័យ'); 
    }

    // Show single course
    public function show(Course $course)
    {
        $course->load('teacher', 'students');

        return view('messages.course.show', [
            'course' => $course,
            'teacher' => $course->teacher,
            'students' => $course->students,
        ]);
    }

    // Show edit form
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $teachers = Teacher::all();
        return view('messages.course.course_edit', compact('course', 'teachers'));
    }

    // Update existing course
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:teachers,id',
            'course_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('course_image')) {
            // Delete old image if exists
            if ($course->course_image && file_exists(public_path('courses/' . $course->course_image))) {
                unlink(public_path('courses/' . $course->course_image));
            }

            // Upload new image
            $imageName = time() . '.' . $request->course_image->extension();
            $request->course_image->move(public_path('courses'), $imageName);
            $course->course_image = $imageName;
        }

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'teacher_id' => $request->teacher_id,
            'price' => $request->price,
            'is_active' => $request->has('is_active') && $request->is_active == '1' ? 1 : 0,
            'course_image' => $course->course_image,
        ]);

        return redirect()->route('courses.List')->with('success', 'កែប្រែមុខវិជ្ជា​ដោយ​ជោគជ័យ');
    }

    // Delete one course
    public function destroy(Course $course)
    {
        if ($course->course_image && file_exists(public_path('courses/' . $course->course_image))) {
            unlink(public_path('courses/' . $course->course_image));
        }

        $course->delete();
        return redirect()->route('courses.List')->with('success', 'លុបមុខវិជ្ជា​ដោយ​ជោគជ័យ');
    }

    // Bulk delete selected courses (optional)
    public function deleteWithSelect(Request $request)
    {
        $ids = $request->selected_id;
        $selected_id = explode(",", $ids);

        foreach ($selected_id as $id) {
            $course = Course::find($id);
            if ($course) {
                if ($course->course_image && file_exists(public_path("courses/" . $course->course_image))) {
                    File::delete(public_path("courses/" . $course->course_image));
                }
                $course->delete();
            }
        }

        return response()->json([
            'status' => 200,
            'message' => "លុបមុខវិជ្ជា​ដែលបានជ្រើសដោយ​ជោគជ័យ"
        ]);
    }
}
