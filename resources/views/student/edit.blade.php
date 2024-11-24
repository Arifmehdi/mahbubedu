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
    <form action="{{route('student.update',$data->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        <table style="">
            <tr>
                <th><label for="name">Name</label></th>
                <td>
                    <input type="text" name="name" id="name" placeholder="Enter your name" value="{{$data->name}}" >
                    @error('name')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="image">Photo</label></th>
                <td>
                    <input type="file" name="image" id="image"  value="{{url('uploads/'.$data->image)}}">
                    <img src="{{url('uploads/'.$data->image)}}" alt=""  height="50px" width="50px">
                    <input type="hidden" name="old_image" value="{{url('uploads/'.$data->image)}}">
                    @error('image')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="email">Email</label></th>
                <td>
                    <input type="text" name="email" id="email" placeholder="Enter your email" value="{{$data->email}}" >
                    @error('email')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="phone">phone</label></th>
                <td>
                    <input type="text" name="phone" id="phone" placeholder="Enter your phone" value="{{$data->phone}}" >
                    @error('phone')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="address">Address</label></th>
                <td>
                    <input type="text" name="address" id="address" placeholder="Enter your address" value="{{$data->address}}" >
                    @error('address')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="class">Class</label></th>
                <td>
                    <input type="text" name="class" id="class" placeholder="Enter your class" value="{{$data->class}}" >
                    @error('class')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="roll">Roll</label></th>
                <td>
                    <input type="text" name="roll" id="roll" placeholder="Enter your roll" value="{{$data->roll}}" >
                    @error('roll')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="fathers_name">Father Name</label></th>
                <td>
                    <input type="text" name="fathers_name" id="fathers_name" placeholder="Enter your fathers name" value="{{$data->fathers_name}}">
                    @error('fathers_name')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="mothers_name">Mothers Name</label></th>
                <td>
                    <input type="text" name="mothers_name" id="mothers_name" placeholder="Enter your mothers name" value="{{$data->mothers_name}}" >
                    @error('mothers_name')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                
                <td colspan="2"><input type="submit" value="Save"></td>
            </tr>
        </table>
    </form>
</body>
</html>



