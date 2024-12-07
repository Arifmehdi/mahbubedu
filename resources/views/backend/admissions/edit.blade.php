<div class="p-2">
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr>
                <!-- Left Section: Admission Fee -->
                <td style="border: 1px solid black; padding: 10px; text-align: left; width: 50%;">
                    <strong>Admission Fee:</strong>
                    <input type="text" value="500" style="margin-left: 10px; width: 80px;" id="edit_admission_fee_amount">
                </td>

                <!-- Right Section: Course Fee -->
                <td style="border: 1px solid black; padding: 10px; text-align: right; width: 50%;">
                    <strong>Course Fee:</strong>
                    <input type="text" value="{{ $student_course_amount }}" style="margin-left: 10px; width: 80px;" id="edit_course_fee_amount">
                </td>
            </tr>
        </tbody>
    </table>
</div>
<form class="form-horizontal" id="editClassForm" action="{{ route('admissions.update', $admiision->id) }}">
    <input type="hidden" value="500" name="edit_admission_fee_input">
    <input type="hidden" value="{{ $student_course_amount }}" name="course_fee_input" id="edit_course_fee_input">
    <div class="form-group">
        <label class="col-md-12 form-label" for="student_id">Student<span class="text-danger">*</span></label>
        <div class="col-md-12">
            <select name="student_id" id="student_id" class="form-control">
                <option value="">Choose Student</option>
                @foreach($students as $student => $studentId)
                    <option value="{{ $studentId }}" {{ $studentId == $admiision->student_id ? 'selected' : '' }}>{{ $student }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @php
        $class_id = App\Models\StudentCourse::where('admission_id',$admiision->id)->first();
        $class_id_data = $class_id->course->id
    @endphp
    <div class="form-group">
        <label class="col-md-12 form-label" for="course_id">Course <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <select name="course_id" id="edit_course_id" class="form-control">
                <option value="">Choose Course</option>
                @foreach($courses as $course => $courseId)
                    <option value="{{ $courseId }}" {{ $class_id_data == $courseId ? 'selected' : '' }}>{{ $course }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 form-label" for="class_id">Class <span class="text-danger">*</span></label>
        <select name="class_id" id="class_id" class="form-control">
            <option value="">Choose Class</option>
                @foreach($classes as $class => $classId)
                    <option value="{{ $classId }}" {{ $admiision->class_id == $classId ? 'selected' : '' }}>{{ $class }}</option>
                @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="col-md-12 form-label" for="status">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-control">
            <option value="">Choose Status</option>
            <option value="pending" {{ $admiision->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ $admiision->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="rejected" {{ $admiision->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-md-12 form-label" for="admission_date">Admission Date </label>
        <div class="col-md-12">
            <input type="date" name="admission_date" id="admission_date" class="form-control" value="{{ $admiision->admission_date}}">
        </div>
    </div>

</form>
