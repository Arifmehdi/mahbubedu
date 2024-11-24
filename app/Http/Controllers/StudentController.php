<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Student::get();
        return view('student.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
      $request->validate([
        'name'=>'required',
        'image'=>'required',
        'email'=>'required|email',
        'phone'=>'required',
        'address'=>'required',
        'class'=>'required',
        'roll'=>'required',
        'fathers_name'=>'required',
        'mothers_name'=>'required',
  
    ]);
    
    $image= $request->file('image');
    $d = $request->all();

    if ( $image){
        $paths = "uploads/";
        $pathname = date('YmdHis').'.'.$image->getClientOriginalExtension();
        $image->move($paths,$pathname);
        $d['image'] = $pathname;
    }
  
//dd($d);
        

        Student::create($d);
     return redirect(route('student.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Student::find($id);
      
  
      return view ('student.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Student::find($id);
      
  
      return view ('student.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $d = Student::find($id);
        $request->validate([
            'name'=>'required',
            'old_image'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'address'=>'required',
            'class'=>'required',
            'roll'=>'required',
            'fathers_name'=>'required',
            'mothers_name'=>'required',
      ]);
  
        $data=$request->all();
        $image=$request->image;
  
        if($image==""){
            $image = $request->old_image;
        }else{
                $path = "uploads/";
                $pname = date('YmdHis').'.'.$image->getClientOriginalExtension();
                $image->move($path,$pname);
                $data['image'] = $pname;
        }
  
        $d->update($data);
    
        return redirect(route('student.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        $student->delete();
        return redirect(route('student.index'));
    }
}
