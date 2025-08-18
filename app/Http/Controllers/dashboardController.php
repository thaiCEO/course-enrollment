<?php

namespace App\Http\Controllers;

use App\Models\course;
use App\Models\Payment;
use App\Models\student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function view_dashboard(Request $request) {

        $studentTotal = student::count();
        $course = course::count();
        $teacher = Teacher::count();
        $revenue =  Payment::sum('amount');
  
        return view('dashboard' , [
            'studentTotal' => $studentTotal,
            'course' => $course,
            'teacher' => $teacher,
            'revenue' => $revenue,
        ]);
  
    }


      public function change(Request $request)
    {
        $supportedLanguages = ['en', 'km' ];
        $locale = $request->lang;
        if (!in_array($locale, $supportedLanguages)) {
            return redirect()->back()->with('error', 'Language not supported.');
        } 
        session()->put('locale', $locale);
        return redirect()->back();

    }





}