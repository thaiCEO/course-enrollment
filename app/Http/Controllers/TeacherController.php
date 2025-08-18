<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function test()
    {
          return view('messages/teacher/test', [
            'teachers' => 'test page',
        ]);
    }
    public function index(Request $request)
    {
        if ($request->get('search')) {
            $teachers = Teacher::where('name', 'LIKE', '%' . $request->search . '%')->paginate(5);
        } else {
            $teachers = Teacher::latest()->paginate(5);
        }

        return view('messages/teacher/teacher', [
            'teachers' => $teachers,
        ]);
    }



    public function show(Teacher $teacher) {

        $teacher->load('addresses');

        return view('messages/teacher/show_teacher', [
            'teacher' => $teacher,
        ]);
    }


    public function create()
    {
        return view('messages/teacher/form_teacher');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|min:3',
            'email'          => 'required|email|unique:teachers,email',
            'phone'          => 'required|string|min:8',
            'bio'            => 'nullable|string',
            'specialization' => 'nullable|string',
            'profile_image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()]);
        }

        $teacher = new Teacher($request->except('profile_image'));

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_teacher'), $imageName);
            $teacher->profile_image = $imageName;
        }

        $teacher->save();

        return redirect()->route('teacher.list')->with(['status' => 200, 'message' => 'បង្កើតគ្រូបានដោយជោគជ័យ']);
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('messages/teacher/teacher_edit', [
            'teacher' => $teacher,
        ]);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|min:3',
            'email'          => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone'          => 'required|string|min:8',
            'bio'            => 'nullable|string',
            'specialization' => 'nullable|string',
            'profile_image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $teacher->fill($request->except('profile_image'));

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_teacher'), $imageName);

            if ($teacher->profile_image && File::exists(public_path('profile_teacher/' . $teacher->profile_image))) {
                File::delete(public_path('profile_teacher/' . $teacher->profile_image));
            }

            $teacher->profile_image = $imageName;
        }

        $teacher->save();

        return redirect()->route('teacher.list')->with('success', 'បានកែប្រែព័ត៌មានគ្រូដោយជោគជ័យ');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        if ($teacher->profile_image && file_exists(public_path('profile_teacher/' . $teacher->profile_image))) {
            unlink(public_path('profile_teacher/' . $teacher->profile_image));
        }

        $teacher->delete();

        return redirect()->route('teacher.list')->with('success', 'បានលុបគ្រូដោយជោគជ័យ');
    }

    public function deleteWithSelect(Request $request)
    {
        $selected_id = explode(',', $request->selected_id);

        foreach ($selected_id as $id) {
            $teacher = Teacher::find($id);

            if ($teacher->profile_image && File::exists(public_path('profile_teacher/' . $teacher->profile_image))) {
                File::delete(public_path('profile_teacher/' . $teacher->profile_image));
            }

            $teacher->delete();
        }

        return response([
            'status' => 200,
            'message' => 'បានលុបគ្រូដែលបានជ្រើសរើសដោយជោគជ័យ'
        ]);
    }

    // Optional API methods
    public function getTeacher()
    {
        $teachers = Teacher::latest()->get();
        return response()->json($teachers);
    }

    public function showTeacher($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        return response()->json($teacher);
    }
}
