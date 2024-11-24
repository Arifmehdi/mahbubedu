<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teacher</title>
</head>
<body>
    <h1>Add teacher</h1>
    <a href="{{route('teacher.index')}}">teacher homepage</a>
    <form action="{{route('teacher.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <table style="">
            <tr>
                <th><label for="">Name</label></th>
                <td>
                    <input type="text" name="name" id="name" placeholder="Enter your name">
                    @error('name')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="image">Photo</label></th>
                <td>
                    <input type="file" name="image" id="image">
                    @error('image')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="email">Email</label></th>
                <td>
                    <input type="text" name="email" id="email" placeholder="Enter your email">
                    @error('email')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="phone">phone</label></th>
                <td>
                    <input type="text" name="phone" id="phone" placeholder="Enter your phone">
                    @error('phone')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="address">Address</label></th>
                <td>
                    <input type="text" name="address" id="address" placeholder="Enter your address">
                    @error('address')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="fathers_name">Father Name</label></th>
                <td>
                    <input type="text" name="fathers_name" id="fathers_name" placeholder="Enter your fathers name">
                    @error('fathers_name')
                        <span style="color:red">{{$message}}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <th><label for="mothers_name">Mothers Name</label></th>
                <td>
                    <input type="text" name="mothers_name" id="mothers_name" placeholder="Enter your mothers name">
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
