<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Teacher::get();
        return view('teacher.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.create');
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
        

        Teacher::create($d);
     return redirect(route('teacher.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Teacher::find($id);
      
  
      return view ('teacher.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Teacher::find($id);
      
  
      return view ('teacher.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $d = Teacher::find($id);
        $request->validate([
            'name'=>'required',
            'old_image'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'address'=>'required',
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
    
        return redirect(route('teacher.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Teacher = Teacher::find($id);
        $Teacher->delete();
        return redirect(route('teacher.index'));
    }
}
