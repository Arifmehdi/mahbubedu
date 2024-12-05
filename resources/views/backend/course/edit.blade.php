<form class="form-horizontal" id="editClassForm" action="{{ route('courses.update', $course->id) }}">
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

</form>


