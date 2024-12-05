<form class="form-horizontal" id="editClassForm" action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
    @method('PATCH')
    @csrf

    <input type="hidden" name="userId" value="{{ $student->user->id}}">
    <div class="form-group">
        <label class="col-md-12 form-label" for="student_name">Student Name <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <input type="text" name="student_name" class="form-control" value="{{ $student->user->name}}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ $student->user->email}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="{{ $student->user->phone}}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12 form-label" for="address">Address <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <textarea  id="address" cols="30" rows="3" name="address" class="form-control">{{ $student->user->address}}</textarea>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="dob">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" name="dob" class="form-control" value="{{ $student->user->dob}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="class">Class <span class="text-danger">*</span></label>
                <select name="class_id" id="class_id" class="form-control">
                    <option value="">Choose Class</option>
                    @foreach ($classes as $class => $classId)
                    <option value="{{ $classId }}" @if($classId == $student->class_id) selected @endif>{{$class}}</option>

                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Image Field -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="image">Image</label>
                <input type="file" name="image" id ="editImageinput" class="form-control">
                <input type="hidden" name="oldImage" id ="oldEditImageinput"  value="{{ $student->user->image }}">

                <img src="{{ asset($student->user->image) }}"  id ="editImage" class="bg-primary-light avatar avatar-lg " alt="">
            </div>
        </div>

        <!-- Admission Date Field -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="admission_date">Admission Date <span class="text-danger">*</span></label>
                <input type="date" id="admission_date" name="admission_date" class="form-control" value="{{ $student->admission_date}}">
            </div>
        </div>
    </div>
</form>

