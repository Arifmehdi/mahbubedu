<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student</title>
</head>
<body>
    <h1>Student Table</h1>
    <a href="{{route('student.create')}}">Add student</a>
    <table style="">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Photo</th>
                <th>Email</th>
                <th>phone</th>
                <th>Address</th>
                <th>Class</th>
                <th>Roll</th>
                <th>Father's Name</th>
                <th>Mother's Name</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($data as $key=>$list)
        <tbody>
        <tr class="table-secondary">
            <td scope="row">{{++$key}}</td>
            <td scope="row">{{$list->name}}</td>
            <td scope="row"><img src="{{url('uploads/'.$list->image)}}" alt=""  height="50px" width="50px"></td>
            <td scope="row">{{$list->email}}</td>
            <td scope="row">{{$list->phone}}</td>
            <td scope="row">{{$list->address}}</td>
            <td scope="row">{{$list->class}}</td>
            <td scope="row">{{$list->roll}}</td>
            <td scope="row">{{$list->fathers_name}}</td>
            <td scope="row">{{$list->mothers_name}}</td>
            
            <td scope="row">
                <a href="{{route('student.show',$list->id)}}">view</a>
                <a href="{{route('student.edit',$list->id)}}">Edit</a>
                <form action="{{route('student.destroy',$list->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" onclick="return confirm('Are You Sure !!!')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Deal">Delete</button>
                </form>
            </td>
        </tr>
        </tbody>
        @endforeach
     
    </table>
</body>
</html>