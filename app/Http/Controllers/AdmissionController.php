<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Classes;
use App\Models\Course;
use App\Models\StudentCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $student = Admission::orderByDesc('id');

            return DataTables::of($student)
                ->addIndexColumn()
                ->addColumn('check', function ($row) {
                    return '<div class="icheck-primary text-center ">
                                <input type="checkbox" name="class_id[]" value="' . $row->id . '" class="mt-2 check1 text-dark">
                            </div>';
                })


                ->editColumn('student', function ($row) {
                    return $row->student->name;
                })
                ->editColumn('admission', function ($row) {
                    return $row->admission_date;
                })
                ->editColumn('course', function ($row) {
                    $student_course = StudentCourse::where('admission_id',$row->id)->first();
                    $student_course_amount = $student_course->course->course_fee;
                    return $student_course_amount;
                })
                ->editColumn('class', function ($row) {
                    return $row->class->name;
                })

                ->editColumn('status', function ($row) {
                    $status = ucfirst($row->status);
                    $badgeClass = match ($row->status) {
                        'pending' => 'badge-warning',    // Yellow badge
                        'confirmed' => 'badge-success', // Green badge
                        'rejected' => 'badge-danger',   // Red badge
                        default => 'badge-secondary',   // Default grey badge
                    };

                    return '<span class="badge ' . $badgeClass . '">' . $status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admissions.edit', $row->id);
                    $deleteUrl = route('admissions.destroy', $row->id);

                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary edit"><i class="fas fa-edit"></i> </a>&nbsp;';
                    $deleteButton = '<a href="' . $deleteUrl . '" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> </a>';

                    return '<div class="btn-group">' . $editButton . $deleteButton . '</div>';
                })
                ->rawColumns(['check', 'action', 'status'])
                ->make(true);
        }
        $classes = Classes::pluck('id','name');
        $students = User::where('role','student')->pluck('id','name');
        $courses = Course::pluck('id','name');
        return view('backend.admissions.index', compact('classes','students','courses'));
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
        // Validate request data
        $request->validate([
            'student_id' => 'required|integer|exists:users,id',
            'course_id' => 'required|integer|exists:courses,id',
            'class_id' => 'required|integer|exists:classes,id',
            'status' => 'required|string|max:255',
            'admission_date' => 'required|date',
        ]);

        // Prevent duplicate entries in student_course table
        $existingStudentCourse = StudentCourse::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($existingStudentCourse) {
            return response()->json(['error' => 'Student is already enrolled in this course!'], 422);
        }

        // Prevent duplicate entries in admission table
        $existingAdmission = Admission::where('student_id', $request->student_id)
            ->where('class_id', $request->class_id)
            ->first();

        if ($existingAdmission) {
            return response()->json(['error' => 'Student is already admitted to this class!'], 422);
        }

        // Insert into admission table
        $admission = new Admission();
        $admission->student_id = $request->student_id;
        $admission->class_id = $request->class_id;
        $admission->admission_date = $request->admission_date;
        $admission->admission_fee = $request->admission_fee_input;
        $admission->status = $request->status;
        $admission->save();

        $student_admission_id = $admission->id;

        // Insert into student_course table
        $student_course = new StudentCourse();
        $student_course->student_id = $request->student_id;
        $student_course->course_id = $request->course_id;
        $student_course->admission_id = $student_admission_id;
        $student_course->save();

        return response()->json(['success' => 'Admission Added Successfully!']);
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
        $admiision = Admission::with('course')->find($id);
        $student_course = StudentCourse::where('admission_id',$id)->first();
        $student_course_amount = $student_course->course->course_fee;
        $classes = Classes::pluck('id','name');
        $students = User::where('role','student')->pluck('id','name');
        $courses = Course::pluck('id','name');
        return view('backend.admissions.edit', compact('classes','students','courses','admiision','student_course', 'student_course_amount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id' => 'required|integer|exists:users,id',
            'course_id' => 'required|integer|exists:courses,id',
            'class_id' => 'required|integer|exists:classes,id',
            'status' => 'required|string|max:255',
            'admission_date' => 'required|date',
        ]);
        // // Prevent duplicate entries in student_course table
        // $existingStudentCourse = StudentCourse::where('student_id', $request->student_id)
        //     ->where('course_id', $request->course_id)
        //     ->first();

        // if ($existingStudentCourse) {
        //     return response()->json(['error' => 'Student is already enrolled in this course!'], 422);
        // }

        // // Prevent duplicate entries in admission table
        // $existingAdmission = Admission::where('student_id', $request->student_id)
        //     ->where('class_id', $request->class_id)
        //     ->first();

        // if ($existingAdmission) {
        //     return response()->json(['error' => 'Student is already admitted to this class!'], 422);
        // }

        // Insert into admission table
        $admission = Admission::find($id);
        $admission->student_id = $request->student_id;
        $admission->class_id = $request->class_id;
        $admission->admission_date = $request->admission_date;
        $admission->admission_fee = $request->edit_admission_fee_input;
        $admission->status = $request->status;
        $admission->save();

        $student_admission_id = $admission->id;

        // Update or insert into student_course table
        $student_course = StudentCourse::where('admission_id', $student_admission_id)->first();

        if ($student_course) {
            // Update existing record
            $student_course->student_id = $request->student_id;
            $student_course->course_id = $request->course_id;
            $student_course->admission_id = $student_admission_id;
            $student_course->save();
        } else {
            // Create new record if not found
            $student_course = new StudentCourse();
            $student_course->student_id = $request->student_id;
            $student_course->course_id = $request->course_id;
            $student_course->admission_id = $student_admission_id;
            $student_course->save();
        }

        return response()->json(['success' => 'Admission Updates Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admission = Admission::find($id);
        if (!$admission) {
            return response()->json('Admission not found', 404);
        }

        // Use student_id from the admission to find the related student course
        $studentCourse = StudentCourse::where('student_id', $admission->student_id)->first();
        if (!$studentCourse) {
            return response()->json('Student Course not found', 404);
        }

        // Delete the admission and the related student course
        $admission->delete();
        $studentCourse->delete();

        return response()->json('Student Course and Admission deleted successfully');
    }

}
