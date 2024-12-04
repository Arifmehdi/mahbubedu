<form class="form-horizontal" id="editClassForm" action="{{ route('class.update', $class->id) }}">
    <div class="form-group">
        <label class="col-md-12 form-label" for="class_name">Class Name <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <input type="text" name="class_name" class="form-control" value="{{ $class->name}}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12 form-label" for="section">Section <span class="text-danger">*</span></label>
        <div class="col-md-12">
            <input type="text" name="section" class="form-control" value="{{ $class->section}}">
        </div>
    </div>

</form>


