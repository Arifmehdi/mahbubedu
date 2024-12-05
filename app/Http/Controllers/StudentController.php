<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
                // ->editColumn('image', function ($row) {
                //     "<img src="{{ asset('backend/uploads/students'.$row->image.') }}" class="bg-primary-light avatar avatar-lg rounded-circle" alt="">"
                //     return $row->user->image;
                // })
                ->editColumn('image', function ($row) {
                    $imageUrl = asset($row->user->image); 
                    return '<img src="' . $imageUrl . '" class="bg-primary-light avatar avatar-lg rounded-circle" alt="">';
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
                ->rawColumns(['check', 'action', 'image'])
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
            'image' => 'nullable|mimes:jpg,jpeg,gif,png|max:5120',
            'email' => 'required|email|unique:users,email', // Check uniqueness in the `users` table
            'phone' => 'required|unique:users,phone', // Check uniqueness in the `users` table
            'address' => 'nullable|string|max:255', // Ensure it's a string and optional
            'dob' => 'required|date', // Ensure it's a valid date
            'class_id' => 'required|integer', // Ensure it's an integer
            'admission_date' => 'required|date', // Ensure it's a valid date
        ]);

        $user_data = new User();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $directory = public_path('backend/uploads/students');

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true);
            }
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = time().'_'.$originalName.'_'. '.' . $image->getClientOriginalExtension();
            $image->move($directory, $imageName);

            $user_data->image = 'backend/uploads/students/' . $imageName;
        }

        $user = User::where('email', $request->email)->orwhere('phone', $request->phone)->first();
        if($user){
            $userId = $user->id;
        }else{
            // initailze before image
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
        $student = Student::with('user')->find($id);
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found');
        }
        $classes  = Classes::pluck('id','name');
        return view('backend.students.edit', compact('student','classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_name' => 'required|string|max:255', // Ensure it's a string with a max length
            'image' => 'nullable|mimes:jpg,jpeg,gif,png|max:5120',
            'email' => 'required|email|unique:users,email,' . $request->userId, // Check uniqueness in the `users` table
            'phone' => 'required|unique:users,phone,' . $request->userId, // Check uniqueness in the `users` table
            'address' => 'nullable|string|max:255', // Ensure it's a string and optional
            'dob' => 'required|date', // Ensure it's a valid date
            'class_id' => 'required|integer', // Ensure it's an integer
            'admission_date' => 'required|date', // Ensure it's a valid date
        ]);

        $user = User::find($request->userId);
        if ($request->hasFile('image')) {
            $oldImage = $request->oldImage; 
            if (File::exists(public_path($oldImage))) {
                File::delete(public_path($oldImage));
            }
        
            // Handle the new uploaded image
            $image = $request->file('image');
            $directory = public_path('backend/uploads/students');
        
            // Create the directory if it doesn't exist
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true);
            }
        
            // Generate a unique name for the image
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = time() . '_' . $originalName . '.' . $image->getClientOriginalExtension();
            
            // Move the image to the correct directory
            $image->move($directory, $imageName);
        
            // Update the user's image path
            $user->image = 'backend/uploads/students/' . $imageName;
        }

        $user->name = $request->student_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->dob = $request->dob;
        $user->role = 'student';
        $user->save();

        
        $student = Student::find($id);
        $student->user_id = $request->userId;
        $student->class_id = $request->class_id;
        $student->admission_date = $request->admission_date;
        $student->save();
        return response()->json('Student Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json('Student not found', 404);
        }
        $studentId = $student->user_id;

        $user = User::find($studentId);
        if (!$user) {
            return response()->json('User not found', 404);
        }

        $imagePath = public_path($user->image);
        $student->delete();
        $user->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return response()->json('Student and user deleted successfully');
    }

    // public function destroy(string $id)
    // {
    //     $student = Student::find($id);
    //     $studentId = $student->user_id;
    //     $student->delete();

    //     $user = User::find($studentId);
    //     $user->delete();

    //     return response()->json('Student Deleted Successfully');
    // }

}
