<?php

namespace App\Http\Controllers;

use App\Models\course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function view_dashboard(Request $request) {

             // ============================
        // 1. DAILY ENROLLMENTS (Last 7 days)
        // ============================
        $daily = Enrollment::selectRaw('CONVERT(date, enrolled_date) as date, COUNT(*) as count')
            ->whereNotNull('enrolled_date')
            ->where('enrolled_date', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('CONVERT(date, enrolled_date)'))
            ->orderBy(DB::raw('CONVERT(date, enrolled_date)'), 'asc')
            ->get();

        $dailyLabels = $daily->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M'));
        $dailyData   = $daily->pluck('count');

        // ============================
        // 2. MONTHLY ENROLLMENTS (Last 6 months)
        // ============================
        $monthly = Enrollment::selectRaw("FORMAT(enrolled_date, 'MMM yyyy') as month, COUNT(*) as count")
            ->whereNotNull('enrolled_date')
            ->where('enrolled_date', '>=', Carbon::now()->subMonths(6))
            ->groupBy(DB::raw("FORMAT(enrolled_date, 'MMM yyyy')"))
            ->orderBy(DB::raw('MIN(enrolled_date)'), 'asc')
            ->get();

        $monthlyLabels = $monthly->pluck('month');
        $monthlyData   = $monthly->pluck('count');

        // ============================
        // 3. YEARLY ENROLLMENTS (Last 5 years)
        // ============================
        $yearly = Enrollment::selectRaw('YEAR(enrolled_date) as year, COUNT(*) as count')
            ->whereNotNull('enrolled_date')
            ->where('enrolled_date', '>=', Carbon::now()->subYears(5))
            ->groupBy(DB::raw('YEAR(enrolled_date)'))
            ->orderBy('year', 'asc')
            ->get();

        $yearlyLabels = $yearly->pluck('year');
        $yearlyData   = $yearly->pluck('count');

        // ============================
        // 4. ENROLLMENTS PER COURSE (Pie Chart)
        // ============================
        $courses = Course::withCount('enrollments')->get();
        $courseLabels = $courses->pluck('title');
        $courseData   = $courses->pluck('enrollments_count');


         $teacher      = Teacher::count();
        $studentTotal = Student::count();
        $course       = Course::count();
        $revenue      = DB::table('payments')->sum('amount'); // from payments table

        $locale = app()->getLocale();

        // Daily labels
        $dailyLabels = $daily->pluck('date')->map(function($date) use ($locale) {
            // Khmer: full day, full month, full year
            $format = $locale === 'km' ? 'd F Y' : 'd M Y'; 
            return Carbon::parse($date)
                ->locale($locale)
                ->translatedFormat($format);
        });

        return view('dashboard', [
            'dailyLabels'   => $dailyLabels,
            'dailyData'     => $dailyData,
            'monthlyLabels' => $monthlyLabels,
            'monthlyData'   => $monthlyData,
            'yearlyLabels'  => $yearlyLabels,
            'yearlyData'    => $yearlyData,
            'courseLabels'  => $courseLabels,
            'courseData'    => $courseData,
             'teacher'       => $teacher,
            'studentTotal'  => $studentTotal,
            'course'        => $course,
            'revenue'       => $revenue,
            'locale'        => $locale, 

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