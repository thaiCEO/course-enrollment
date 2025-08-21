<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    // List all rooms
    public function index(Request $request)
    {
        
        $rooms = $request->get('search')
            ? Room::where('name', 'LIKE', '%' . $request->search . '%')->paginate(5)
            : Room::latest()->paginate(5);

        return view('messages.room.room', compact('rooms'));
    }

    // Show create form
    public function create()
    {
        return view('messages/room/form_room');
    }

    // Store new room
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|unique:rooms,name',
            'capacity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Room::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('room.index')->with('success', __('messages.roomAlertMessage.create'));
    }

    // Show edit form
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('messages.room.edit_room', compact('room'));
    }

    // Update room
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|unique:rooms,name,' . $room->id,
            'capacity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $room->name = $request->name;
        $room->capacity = $request->capacity;
        $room->save();

        return redirect()->route('room.index')->with('success', __('messages.roomAlertMessage.update'));
    }

    // Delete room
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('room.index')->with('success', __('messages.roomAlertMessage.delete'));
    }

    // Delete multiple rooms
    public function deleteSelected(Request $request)
    {
        $ids = explode(',', $request->selected_id);
        Room::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => 200,
            'message' => __('messages.roomAlertMessage.bulk_delete')
        ]);
    }

    // Show room details
    public function show($id)
    {
        $room = Room::with(['enrollments.student', 'enrollments.course', 'enrollments.teacher' , 'enrollments.course.studyTimes'])
                    ->withCount('enrollments') // total enrolled students
                    ->findOrFail($id);
        return view('messages.room.show_room', compact('room'));
    }

}
