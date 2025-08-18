<?php

namespace App\Http\Controllers;

use App\Models\class_room;
use App\Models\student;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function getData() {
    //     $classRooms = class_room::orderBy("id", "DESC")->get(); // Fetch classroom data
    //     return response()->json($classRooms);
    // }
    

    public function index(Request $request)
    {
        if ($request->get('search') != '') {
            $students = student::orderBy('id', 'DESC')
                ->where('username', 'LIKE', '%' . $request->get('search') . '%')
                ->paginate(5);
        } else {
            // If no search term, simply paginate the teachers with subjects
            $students = student::orderBy('id', 'DESC')
                ->paginate(5);
        }
      
    
        return view('messages/student/student' , [
          'students' => $students,
        ]);

    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('messages/student/form_student');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the request data

        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4',
            'student_number' => 'required|unique:students,student_number',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required',
            'address' => 'required|min:5',
         

        ]);

        // If the validation passes, create a new student record

        if ($validator->passes()) {
            $user = new student();
            $user->username = $request->input('username');
            $user->student_number = $request->input('student_number'); // New field
            $user->gender = $request->input('gender');
            $user->date_of_birth = $request->input('date_of_birth');
            $user->phone_number = $request->input('phone_number');
            $user->address = $request->input('address');

            // Handle image upload
    if ($request->file("profile_student") != null) {

        $image = $request->file('profile_student');

        // Generate a unique file name
        $imageName = rand(0, 99999) . '.' . $image->getClientOriginalExtension();

        // Move the file to the specified directory

        $image->move(public_path("profile_student"), $imageName);

        // Save the file name or path to the database
        $user->profile_student =  $imageName; // Save relative path
     }

        // Save the user
        $user->save();

        // Set a success message in the session
       session()->flash("success", "សិស្សបានបង្កើតដោយជោគជ័យ"); 



            return response()->json([
                'status' => 200,
                'message' => 'student created successfully'
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Please fix errors',
                'errors' => $validator->errors(),
            ]);
        }

    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $student = student::find($id);
        return view('messages/student/student_edit' , [
          'student' => $student,
        ]);
}


public function showStudent($id) {

    $student = student::with(['addresses' , 'enrollments.payments' , 'courses'])->find($id);

        return view('messages/student/show_student' , [
          'student' => $student,
        ]);

}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());
            // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:ប្រុស,ស្រី',
            'address' => 'required',
            'phone_number' => 'required',
            'profile_student' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }


        // Find the student by ID
        $student = Student::findOrFail($id);

        // Update student details
        $student->username = $request->input('username');
        $student->date_of_birth = $request->input('date_of_birth');
        $student->gender = $request->input('gender');
        $student->address = $request->input('address');
        $student->phone_number = $request->input('phone_number');

        // Handle profile image upload
        if ($request->hasFile('profile_student')) {
            // Store the new profile image
            $image = $request->file('profile_student');
            $imageName = rand(0,99999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_student'), $imageName);

            // Delete the old profile image if it exists
            if ($student->profile_student) {
                $image_path = public_path("profile_student/".$student->profile_student);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            // Update the student's profile image field
            $student->profile_student = $imageName;
        }else {
            $student->profile_student = $request->old_image;
        }

        // Save the updated student information
        $student->save();

       return redirect()->route('student.list')->with('success', 'បានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ។'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the student by ID
        $student = student::findOrFail($id);

             // Check if the student has a profile image and delete it
        if ($student->profile_student && file_exists(public_path('profile_student/' . $student->profile_student))) {
            // Delete the image file from the public directory
            unlink(public_path('profile_student/' . $student->profile_student));
        }

        // Delete the student record from the database
        $student->delete();

        // Redirect back to the list of students with a success message
       return redirect()->route('student.list')->with('success', 'បានលុបសិស្សដោយជោគជ័យ'); 
    }

    public function deleteWithSelect (Request $request) {

        $ids = $request->selected_id;
        //convert to array
        $selected_id = explode(",", $ids);

        //loop through and delete each student
        foreach($selected_id as $id){
            $student = Student::find($id);

            if($student->profile_student != "") {
                $image_path = public_path("profile_student/".$student->profile_student);
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $student->delete();
        }


        return response([
            'status' => 200,
            'message' => "បានលុបសិស្សពីការជ្រើសរើសដោយជោគជ័យ"
        ]);
    }











    // for api function 
     public function getStudent()
    {
        $students = Student::with(['courses' => function ($query) {
        $query->select('courses.id', 'title', 'description'); // optional: limit course fields
        }, 'enrollments'])->get();

        return response()->json($students);
    }


    public function show($id)
{
    $student = Student::with([
        'courses' => function ($query) {
            $query->select('courses.id', 'title', 'description', 'course_image');
        },
        'enrollments'
    ])->find($id);

    if (!$student) {
        return response()->json([
            'message' => 'Student not found'
        ], 404);
    }

    return response()->json($student);
}


 public function search(Request $request)
    {

        $query = $request->input('query');

        if (!$query) {
            return response()->json(['message' => 'Query parameter is required.'], 400);
        }

        $students = Student::where('username', 'LIKE', "%{$query}%")
            ->orWhere('student_number', 'LIKE', "%{$query}%")
            ->orWhere('phone_number', 'LIKE', "%{$query}%")
            ->get();


        return response()->json($students);

    }
    
}
