<form class="form-horizontal" id="editClassForm" action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
    @method('PATCH')
    @csrf

    <input type="hidden" name="userId" value="{{ $teacher->user->id}}">
    <div class="form-group">
        <label class="col-md-12 form-label" for="teacher_name">Teacher Name <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <input type="text" name="teacher_name" class="form-control" value="{{ $teacher->user->name}}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ $teacher->user->email}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="{{ $teacher->user->phone}}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12 form-label" for="address">Address <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <textarea  id="address" cols="30" rows="3" name="address" class="form-control">{{ $teacher->user->address}}</textarea>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="dob">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" name="dob" class="form-control" value="{{ $teacher->user->dob}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="class">Class <span class="text-danger">*</span></label>
                <select name="class_id" id="class_id" class="form-control">
                    <option value="">Choose Class</option>
                    @foreach ($classes as $class => $classId)
                    <option value="{{ $classId }}" @if($classId == $teacher->class_id) selected @endif>{{$class}}</option>

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
                <input type="hidden" name="oldImage" id ="oldEditImageinput"  value="{{ $teacher->user->image }}">

                <img src="{{ asset($teacher->user->image) }}"  id ="editImage" class="bg-primary-light avatar avatar-lg " alt="">
            </div>
        </div>

        <!-- Admission Date Field -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="joining_date">Joining Date <span class="text-danger">*</span></label>
                <input type="date" id="joining_date" name="joining_date" class="form-control" value="{{ $teacher->joining_date}}">
            </div>
        </div>
    </div>
</form>

