<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $student = Teacher::orderByDesc('id');

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
                //     "<img src="{{ asset('backend/uploads/teachers'.$row->image.') }}" class="bg-primary-light avatar avatar-lg rounded-circle" alt="">"
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
                    $editUrl = route('teachers.edit', $row->id);
                    $deleteUrl = route('teachers.destroy', $row->id);

                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary edit"><i class="fas fa-edit"></i> </a>&nbsp;';
                    $deleteButton = '<a href="' . $deleteUrl . '" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> </a>';

                    return '<div class="btn-group">' . $editButton . $deleteButton . '</div>';
                })
                ->rawColumns(['check', 'action', 'image'])
                ->make(true);
        }
        $classes = Classes::pluck('id','name');
        return view('backend.teachers.index', compact('classes'));
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
            'teacher_name' => 'required|string|max:255', // Ensure it's a string with a max length
            'image' => 'nullable|mimes:jpg,jpeg,gif,png|max:5120',
            'email' => 'required|email|unique:users,email', // Check uniqueness in the `users` table
            'phone' => 'required|unique:users,phone', // Check uniqueness in the `users` table
            'address' => 'nullable|string|max:255', // Ensure it's a string and optional
            'dob' => 'required|date', // Ensure it's a valid date
            'class_id' => 'required|integer', // Ensure it's an integer
            'joining_date' => 'required|date', // Ensure it's a valid date
        ]);

        $user_data = new User();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $directory = public_path('backend/uploads/teachers');

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true);
            }
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = time().'_'.$originalName.'_'. '.' . $image->getClientOriginalExtension();
            $image->move($directory, $imageName);

            $user_data->image = 'backend/uploads/teachers/' . $imageName;
        }

        $user = User::where('email', $request->email)->orwhere('phone', $request->phone)->first();
        if($user){
            $userId = $user->id;
        }else{
            // initailze before image
            $user_data->name = $request->teacher_name;
            $user_data->email = $request->email;
            $user_data->phone = $request->phone;
            $user_data->address = $request->address;
            $user_data->dob = $request->dob;
            $user_data->role = 'teacher';
            $user_data->password = bcrypt('password');
            $user_data->save();
            $userId  = $user_data->id;
        }
        $data = [
            'user_id' => $userId,
            'class_id' => $request->class_id,
            'joining_date' => $request->joining_date,
        ];
        $class = Teacher::create($data);
        return response()->json(['success' => 'Teacher Created Successfully!']);
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
        $teacher = Teacher::with('user')->find($id);
        if (!$teacher) {
            return redirect()->route('students.index')->with('error', 'Teacher not found');
        }
        $classes  = Classes::pluck('id','name');
        return view('backend.teachers.edit', compact('teacher','classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'teacher_name' => 'required|string|max:255', // Ensure it's a string with a max length
            'image' => 'nullable|mimes:jpg,jpeg,gif,png|max:5120',
            'email' => 'required|email|unique:users,email,' . $request->userId, // Check uniqueness in the `users` table
            'phone' => 'required|unique:users,phone,' . $request->userId, // Check uniqueness in the `users` table
            'address' => 'nullable|string|max:255', // Ensure it's a string and optional
            'dob' => 'required|date', // Ensure it's a valid date
            'class_id' => 'required|integer', // Ensure it's an integer
            'joining_date' => 'required|date', // Ensure it's a valid date
        ]);

        $user = User::find($request->userId);
        if ($request->hasFile('image')) {
            $oldImage = $request->oldImage; 
            if (File::exists(public_path($oldImage))) {
                File::delete(public_path($oldImage));
            }
        
            // Handle the new uploaded image
            $image = $request->file('image');
            $directory = public_path('backend/uploads/teachers');
        
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
            $user->image = 'backend/uploads/teachers/' . $imageName;
        }

        $user->name = $request->teacher_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->dob = $request->dob;
        $user->role = 'teacher';
        $user->save();

        
        $student = Teacher::find($id);
        $student->user_id = $request->userId;
        $student->class_id = $request->class_id;
        $student->joining_date = $request->joining_date;
        $student->save();
        return response()->json('Teacher Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json('Teacher not found', 404);
        }
        $teacherId = $teacher->user_id;

        $user = User::find($teacherId);
        if (!$user) {
            return response()->json('User not found', 404);
        }

        $imagePath = public_path($user->image);
        $teacher->delete();
        $user->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return response()->json('Teacher and user deleted successfully');
    }
}
