<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function report_summary(Request $request)
    {
        $students = User::with('payments')->where('role', 'student')->get();

        $report = $students->map(function ($student) {
            $admissionFee = $student->payments->where('payment_type', 'admission')->sum('amount');
            $courseFee = $student->payments->where('payment_type', 'course_fee')->sum('amount');
            $otherFee = $student->payments->where('payment_type', 'other')->sum('amount');
            $paidAmount = $student->payments->sum('amount');
            $dueAmount = ($admissionFee + $courseFee + $otherFee) - $paidAmount;

            return [
                'id' => $student->id, // Ensure id is included
                'name' => $student->name,
                'email' => $student->email,
                'mobile_no' => $student->phone,
                'admission_fee' => $admissionFee,
                'course_fee' => $courseFee,
                'registration_fee' => $otherFee,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
            ];
        });

        if ($request->ajax()) {
            return DataTables::of($report)
                ->addIndexColumn()
                ->addColumn('check', function ($row) {
                    return '<div class="icheck-primary text-center">
                                <input type="checkbox" name="class_id[]" value="' . $row['id'] . '" class="mt-2 check1 text-dark">
                            </div>';
                })
                ->rawColumns(['check'])
                ->make(true);
        }

        $students = User::where('role', 'student')->pluck('id', 'name');
        return view('backend.report.index', compact('students'));
    }
}
