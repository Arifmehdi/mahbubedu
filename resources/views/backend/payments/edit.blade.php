<form class="form-horizontal" id="editClassForm" action="{{ route('payments.update', $payment->id) }}">
        <div class="form-group">
            <label class="col-md-12 form-label" for="student_id">Student<span class="text-danger">*</span></label>
            <div class="col-md-12">
                <select name="student_id" id="student_id" class="form-control">
                    <option value="">Choose Student</option>
                    @foreach($students as $student => $studentId)
                        <option value="{{ $studentId }}" {{ $studentId == $payment->student_id ? 'selected' : ''  }}>{{ $student }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12 form-label" for="amount">Amount <span class="text-danger">*</span></label>
            <div class="col-md-12">
                <input type="number" name="amount" class="form-control" value="{{ $payment->amount }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12 form-label" for="year">Year <span class="text-danger">*</span></label>
            <div class="col-md-12">
                <select name="payment_type" id="payment_type" class="form-control">
                    <option value="">Choose Payment Type</option>
                    <option value="admission" {{ $payment->payment_type == 'admission' ? 'selected' : ''  }}>Admission</option>
                    <option value="course fee" {{ $payment->payment_type == 'course_fee' ? 'selected' : ''  }}>Course Fee</option>
                    <option value="other" {{ $payment->payment_type == 'other' ? 'selected' : ''  }}>Other</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 form-label" for="payment_date">Payment Date  <span class="text-danger">*</span></label>
            <div class="col-md-12">
                <input type="date"  name="payment_date" class="form-control" id="payment_date" value="{{ $payment->payment_date}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 form-label" for="ref_mobile_number">Refference Mobile Number </label>
            <div class="col-md-12">
                <input type="number" name="ref_mobile_number" class="form-control" id="ref_mobile_number" value="{{ $payment->reference_number}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 form-label" for="description">Description </label>
            <div class="col-md-12">
                <textarea name="description" class="form-control" id="description" value="{{ $payment->details}}"> {{ $payment->details}}</textarea>
            </div>
        </div>

    </form>

