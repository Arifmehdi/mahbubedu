<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $students = User::with('payments')->where('role', 'student')->get();

        // Initialize total counters
        $totalPaidAmount = 0;
        $totalDueAmount = 0;

        // Generate report data and calculate totals
        $report = $students->map(function ($student) use (&$totalPaidAmount, &$totalDueAmount) {
            $admissionFee = $student->payments->where('payment_type', 'admission')->sum('amount');
            $courseFee = $student->payments->where('payment_type', 'course_fee')->sum('amount');
            $otherFee = $student->payments->where('payment_type', 'other')->sum('amount');
            $paidAmount = $student->payments->sum('amount');
            $dueAmount = ($admissionFee + $courseFee + $otherFee) - $paidAmount;

            // Update totals
            $totalPaidAmount += $paidAmount;
            $totalDueAmount += $dueAmount;
        });

        $students = User::where('role','student')->pluck('id','name')->count();
        $teachers = User::where('role','teacher')->pluck('id','name')->count();
        return view('backend.dashboard', compact('students', 'teachers','totalPaidAmount','totalDueAmount'));
        // return view('home');
    }

    public function datatable()
    {
        return view('backend.datatable');
    }
}
