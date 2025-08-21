<?php

namespace App\Http\Controllers;

use App\Models\StudyTime;
use App\Models\Course;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudyTimeController extends Controller
{
    // ✅ List all study times
    public function index(Request $request)
    {
        $studyTimes = $request->get('search')
            ? StudyTime::with(['course', 'room'])
                ->whereHas('course', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                })
                ->paginate(5)
            : StudyTime::with(['course', 'room'])->latest()->paginate(5);

        return view('messages.studytime.studytime', compact('studyTimes'));
    }

    // ✅ Show create form
    public function create()
    {
        $courses = Course::all();
        $rooms   = Room::all(); // Add rooms selection
        return view('messages.studytime.form_studytime', compact('courses', 'rooms'));
    }

    // ✅ Store new study time
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'room_id'   => 'required|exists:rooms,id',
            'day_type'  => 'required|in:weekday,weekend',
            'start_time'=> 'required|date_format:H:i',
            'end_time'  => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        StudyTime::create($request->only('course_id', 'room_id', 'day_type', 'start_time', 'end_time'));

       return redirect()->route('study-time.index')
        ->with('success', __('messages.studyTimeAlertMessage.created'));
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $studyTime = StudyTime::findOrFail($id);
        $courses   = Course::all();
        $rooms     = Room::all();

        return view('messages.studytime.edit_studytime', compact('studyTime', 'courses', 'rooms'));
    }

    // ✅ Update study time
    public function update(Request $request, $id)
    {
        $studyTime = StudyTime::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'room_id'   => 'required|exists:rooms,id',
            'day_type'  => 'required|in:weekday,weekend',
            'start_time'=> 'required|date_format:H:i',
            'end_time'  => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $studyTime->update($request->only('course_id', 'room_id', 'day_type', 'start_time', 'end_time'));

        return redirect()->route('study-time.index')
                ->with('success', __('messages.studyTimeAlertMessage.updated'));
    }

    // ✅ Delete study time
    public function destroy($id)
    {
        $studyTime = StudyTime::findOrFail($id);
        $studyTime->delete();

        
        return redirect()->route('study-time.index')
            ->with('success', __('messages.studyTimeAlertMessage.deleted'));
    }

    // ✅ Delete multiple study times
    public function deleteSelected(Request $request)
    {
        $ids = explode(',', $request->selected_id);
        StudyTime::whereIn('id', $ids)->delete();

        return response()->json([
                'status' => 200,
                'message' => __('messages.studyTimeAlertMessage.bulkDeleted')
            ]);
    }

    // ✅ Show study time details by ID
    public function show($id)
    {
        // Load study time with course and the related room + enrolled students
        $studyTime = StudyTime::with(['course', 'course.teacher', 'room.enrollments.student',])->findOrFail($id);

        // Pass studyTime to the view
        return view('messages.studytime.show_studytime', compact('studyTime'));
    }
}
