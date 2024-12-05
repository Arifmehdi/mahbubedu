<!-- <form class="form-horizontal" id="editClassForm" action="{{ route('courses.update', $course->id) }}">
    <div class="form-group">
        <label class="col-md-12 form-label" for="course_name">Course Name <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <input type="text" name="course_name" class="form-control" value="{{ $course->name}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 form-label" for="year">Year <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <select name="year" id="year" class="form-control">
                <option value="">Choose Year</option>
                @for($i = 2020; $i <= 2030; $i++)
                    <option value="{{ $i }}"  {{ $course->year == $i ? 'selected' : ''}}>{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 form-label" for="description">Teacher <span class="text-danger">*</span></label>
        <select name="teacher_id" id="teacher_id" class="form-control">
            <option value="">Choose Teacher</option>
            @foreach ($teachers as $teachers => $teachersId)
            <option value="{{ $teachersId }}" {{ $course->teacher_id == $teachersId ? 'selected' : ''}}>{{$teachers}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="col-md-12 form-label" for="description">Description </label>
        <div class="col-md-12">
            <textarea name="description" class="form-control" id="description"></textarea>
        </div>
    </div>

</form> -->



<form class="form-horizontal" id="editClassForm" action="{{ route('admissions.update', $course->id) }}">
    <div class="form-group">
        <label class="col-md-12 form-label" for="student_id">Student<span class="text-danger">*</span></label>
        <div class="col-md-12">
            <select name="student_id" id="student_id" class="form-control">
                <option value="">Choose Student</option>
                @foreach($students as $student => $studentId)
                    <option value="{{ $studentId }}">{{ $student }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 form-label" for="course_id">Course <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <select name="course_id" id="course_id" class="form-control">
                <option value="">Choose Course</option>
                @foreach($courses as $course => $courseId)
                    <option value="{{ $courseId }}">{{ $course }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 form-label" for="class_id">Class <span class="text-danger">*</span></label>
        <select name="class_id" id="class_id" class="form-control">
            <option value="">Choose Class</option>
                @foreach($classes as $class => $classId)
                    <option value="{{ $classId }}">{{ $class }}</option>
                @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="col-md-12 form-label" for="status">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-control">
            <option value="">Choose Status</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-md-12 form-label" for="admission_date">Admission Date </label>
        <div class="col-md-12">
            <input type="date" name="admission_date" id="admission_date" class="form-control">
        </div>
    </div>

</form>

