<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $payment = Payment::orderByDesc('id');
            return DataTables::of($payment)
                ->addIndexColumn()
                ->addColumn('check', function ($row) {
                    return '<div class="icheck-primary text-center ">
                                <input type="checkbox" name="class_id[]" value="' . $row->id . '" class="mt-2 check1 text-dark">
                            </div>';
                })
                ->editColumn('student', function ($row) {
                    return $row->student->name;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('payments.edit', $row->id);
                    $deleteUrl = route('payments.destroy', $row->id);

                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary edit"><i class="fas fa-edit"></i> </a>&nbsp;';
                    $deleteButton = '<a href="' . $deleteUrl . '" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> </a>';

                    return '<div class="btn-group">' . $editButton . $deleteButton . '</div>';
                })
                ->rawColumns(['check', 'action'])
                ->make(true);
        }
        $students = User::where('role','student')->pluck('id','name');
        return view('backend.payments.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'payment_type' => 'required',
            'payment_date' => 'required|date',
            'ref_mobile_number' => 'nullable|numeric',
            'description' => 'nullable',
        ]);

        $data = [
            'student_id' => $request->student_id,
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'payment_date' => $request->payment_date,
            'reference_number' => $request->ref_mobile_number,
            'details' => $request->description,
        ];

        $payment = Payment::create($data);
        return response()->json(['success' => 'Payment Created Successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::find($id);
        $students = User::where('role','student')->pluck('id','name');

        return view('backend.payments.edit', compact('students','payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'payment_type' => 'required|string',
            'payment_date' => 'required|date',
            'ref_mobile_number' => 'required|numeric',
            'description' => 'nullable',
        ]);

        $course = Payment::find($id);
        $course->student_id = $request->student_id;
        $course->amount = $request->amount;
        $course->payment_type = $request->payment_type;
        $course->payment_date = $request->payment_date;
        $course->reference_number = $request->ref_mobile_number;
        $course->details = $request->description;
        $course->save();
        return response()->json('Payment Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        return response()->json('Payment Deleted Successfully');
    }
}
