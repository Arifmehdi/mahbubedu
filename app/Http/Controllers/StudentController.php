<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $student = Student::orderByDesc('id');

            return DataTables::of($student)
                ->addIndexColumn()
                ->addColumn('check', function ($row) {
                    return '<div class="icheck-primary text-center ">
                                <input type="checkbox" name="class_id[]" value="' . $row->id . '" class="mt-2 check1 text-dark">
                            </div>';
                })
                ->editColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->editColumn('image', function ($row) {
                    return $row->user->image;
                })
                ->editColumn('email', function ($row) {
                    return $row->user->email;
                })
                ->editColumn('phone', function ($row) {
                    return $row->user->phone;
                })
                ->editColumn('dob', function ($row) {
                    return $row->user->dob;
                })
                ->editColumn('address', function ($row) {
                    return $row->user->address;
                })
                ->editColumn('class', function ($row) {
                    return $row->class->name;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('students.edit', $row->id);
                    $deleteUrl = route('students.destroy', $row->id);

                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary edit"><i class="fas fa-edit"></i> </a>&nbsp;';
                    $deleteButton = '<a href="' . $deleteUrl . '" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> </a>';

                    return '<div class="btn-group">' . $editButton . $deleteButton . '</div>';
                })
                ->rawColumns(['check', 'action'])
                ->make(true);
        }
        $classes = Classes::pluck('id','name');
        return view('backend.students.index', compact('classes'));
    }


    // public function index()
    // {
    //     $students = Student::with('class')->get();
    //     // dd($students);
    //     return view('backend.students.index', compact('students'));
    // }

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
            'student_name' => 'required|string|max:255', // Ensure it's a string with a max length
            'email' => 'required|email|unique:users,email', // Check uniqueness in the `users` table
            'phone' => 'required|unique:users,phone', // Check uniqueness in the `users` table
            'address' => 'nullable|string|max:255', // Ensure it's a string and optional
            'dob' => 'required|date', // Ensure it's a valid date
            'class_id' => 'required|integer', // Ensure it's an integer
            'admission_date' => 'required|date', // Ensure it's a valid date
        ]);

        $user = User::where('email', $request->email)->orwhere('phone', $request->phone)->first();
        if($user){
            $userId = $user->id;
        }else{
            $user_data =new  User();
            $user_data->name = $request->student_name;
            $user_data->email = $request->email;
            $user_data->phone = $request->phone;
            $user_data->address = $request->address;
            $user_data->dob = $request->dob;
            $user_data->role = 'student';
            $user_data->password = bcrypt('password');
            $user_data->save();
            $userId  = $user_data->id;
        }
        $data = [
            'user_id' => $userId,
            'class_id' => $request->class_id,
            'admission_date' => $request->admission_date,
        ];
        $class = Student::create($data);
        return response()->json(['success' => 'Student Created Successfully!']);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        $studentId = $student->user_id;
        $student->delete();

        $user = User::find($studentId);
        $user->delete();

        return response()->json('Student Deleted Successfully');
    }
}
