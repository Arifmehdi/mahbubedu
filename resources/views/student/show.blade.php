<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student</title>
</head>
<body>
    <h1>Add Student</h1>
    <a href="{{route('student.index')}}">student homepage</a>
    
        <table style="">
            <tr>
                <th><label for="name">Name</label></th>
                <td>
                    {{$data->name}}
                </td>
            </tr>
            <tr>
                <th><label for="image">Photo</label></th>
                <td>
                <img src="{{url('uploads/'.$data->image)}}" alt=""  height="50px" width="50px">
                </td>
            </tr>
            <tr>
                <th><label for="email">Email</label></th>
                <td>
                    {{$data->email}}
                </td>
            </tr>
            <tr>
                <th><label for="phone">phone</label></th>
                <td>
                    {{$data->phone}}
                </td>
            </tr>
            <tr>
                <th><label for="address">Address</label></th>
                <td>
                    {{$data->address}}
                </td>
            </tr>
            <tr>
                <th><label for="class">Class</label></th>
                <td>
                    {{$data->class}}
                </td>
            </tr>
            <tr>
                <th><label for="roll">Roll</label></th>
                <td>
                    {{$data->roll}}
                </td>
            </tr>
            <tr>
                <th><label for="fathers_name">Father Name</label></th>
                <td>
                    {{$data->fathers_name}}
                </td>
            </tr>
            <tr>
                <th><label for="mothers_name">Mothers Name</label></th>
                <td>
                    {{$data->mothers_name}}
                </td>
            </tr>
         
        </table>
 
</body>
</html>



