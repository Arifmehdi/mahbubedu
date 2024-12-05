<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $course = Course::orderByDesc('id');

            return DataTables::of($course)
                ->addIndexColumn()
                ->addColumn('check', function ($row) {
                    return '<div class="icheck-primary text-center ">
                                <input type="checkbox" name="class_id[]" value="' . $row->id . '" class="mt-2 check1 text-dark">
                            </div>';
                })
                ->editColumn('teacher', function ($row) {
                    return $row->teacher->name;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('courses.edit', $row->id);
                    $deleteUrl = route('courses.destroy', $row->id);

                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary edit"><i class="fas fa-edit"></i> </a>&nbsp;';
                    $deleteButton = '<a href="' . $deleteUrl . '" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> </a>';

                    return '<div class="btn-group">' . $editButton . $deleteButton . '</div>';
                })
                ->rawColumns(['check', 'action'])
                ->make(true);
        }
        $teachers = User::where('role','teacher')->pluck('id','name');
        return view('backend.course.index', compact('teachers'));
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
            'course_name' => 'required',
            'year' => 'required',
            'teacher_id' => 'required',
            'description' => 'nullable',
        ]);

        $data = [
            'name' => $request->course_name,
            'year' => $request->year,
            'description' => $request->description,
            'teacher_id' => $request->teacher_id,
        ];
        $class = Course::create($data);
        return response()->json(['success' => 'Course Created Successfully!']);
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
        $course = Course::find($id);
        $teachers = User::where('role','teacher')->pluck('id','name');
        return view('backend.course.edit', compact('course','teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'course_name' => 'required',
            'year' => 'required',
            'teacher_id' => 'required',
            'description' => 'nullable',
        ]);

        $course = Course::find($id);
        $course->name = $request->course_name;
        $course->year = $request->year;
        $course->teacher_id = $request->teacher_id;
        $course->description = $request->description;
        $course->save();
        return response()->json('Course Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);
        $course->delete();
        return response()->json('Course Deleted Successfully');
    }
}
