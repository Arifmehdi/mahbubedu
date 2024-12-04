<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ClassController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $classes = Classes::orderByDesc('id');

            return DataTables::of($classes)
                ->addIndexColumn()
                ->addColumn('check', function ($row) {
                    return '<div class="icheck-primary text-center ">
                                <input type="checkbox" name="class_id[]" value="' . $row->id . '" class="mt-2 check1 text-dark">
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('class.edit', $row->id);
                    $deleteUrl = route('class.destroy', $row->id);

                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary edit"><i class="fas fa-edit"></i> </a>&nbsp;';
                    $deleteButton = '<a href="' . $deleteUrl . '" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> </a>';

                    return '<div class="btn-group">' . $editButton . $deleteButton . '</div>';
                })
                ->rawColumns(['check', 'action'])
                ->make(true);
        }

        return view('backend.class.index');
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
            'class_name' => 'required',
            'section' => 'required',
        ]);

        $data = [
            'name' => $request->class_name,
            'section' => $request->section,
        ];
        $class = Classes::create($data);
        return response()->json(['success' => 'Class Created Successfully!']);
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
        $class = Classes::find($id);
        return view('backend.class.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'class_name' => 'required',
            'section' => 'required',
        ]);
        $class = Classes::find($id);
        $class->name = $request->class_name;
        $class->section = $request->section;
        $class->save();
        return response()->json('Class Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = Classes::find($id);
        $class->delete();
        return response()->json('Class Deleted Successfully');
    }
}
