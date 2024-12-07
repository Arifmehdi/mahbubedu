@extends('backend.layouts.app')
@section('content')
<section class="content">
    <div class="row">

      <div class="col-12">
        <div class="box">
                <div class="row align-items-center">
                    <div class="box-header with-border col-6">
                        <h4 class="box-title">Payment List</h4>
                        {{-- <p class="mb-0 box-subtitle">Export data to Copy, CSV, Excel, PDF & Print</p> --}}
                    </div>
                    <div class="col-6 text-end">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-success mt-10  text-center">+ Add Payment</a>
                    </div>
                </div>


          <!-- /.box-header -->
          <div class="box-body">
              <div class="table-responsive">
                {{-- <table id="example" class="table text-fade table-bordered table-hover margin-top-10 w-p100 student-table"> --}}
                <table class="table text-fade table-bordered table-hover margin-top-10 w-p100 student-table">
                  <thead>
                      <tr class="text-dark">
                          <th class="text-start">
                            <div>
                                <input type="checkbox" id="is_check_all" class="text-dark">
                            </div>
                          </th>
                          <th class="text-start">{{ __('SL.') }}</th>
                          <th class="text-start">{{ __('Student Name') }}</th>
                          <th class="text-start">{{ __('Amount') }}</th>
                          <th class="text-start">{{ __('Payment Type') }}</th>
                          <th class="text-start">{{ __('Payment Date') }}</th>
                          <th class="text-start">{{ __('Refference Number') }}</th>
                          <th class="text-start">{{ __('Action') }}</th>
                      </tr>
                  </thead>
                    <tbody></tbody>
                </table>

              </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>

    <!-- Popup Create Model Plase Here -->
    <div id="myModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add Payment</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" id="addClassForm">
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
							<label class="col-md-12 form-label" for="amount">Amount <span class="text-danger">*</span></label>
							<div class="col-md-12">
								<input type="number" name="amount" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-12 form-label" for="year">Payment Type <span class="text-danger">*</span></label>
							<div class="col-md-12">
                                <select name="payment_type" id="payment_type" class="form-control">
                                    <option value="">Choose Payment Type</option>
                                    <option value="admission">Admission</option>
                                    <option value="course_fee">Course Fee</option>
                                    <option value="other">Other</option>
                                </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-12 form-label" for="payment_date">Payment Date  <span class="text-danger">*</span></label>
							<div class="col-md-12">
                                <input type="date"  name="payment_date" class="form-control" id="payment_date">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-12 form-label" for="ref_mobile_number">Refference Mobile Number </label>
							<div class="col-md-12">
                                <input type="number" name="ref_mobile_number" class="form-control" id="ref_mobile_number">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-12 form-label" for="description">Description </label>
							<div class="col-md-12">
                                <textarea name="description" class="form-control" id="description"></textarea>
							</div>
						</div>

					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger " data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-success float-end" id="createClassBtn">Submit</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /Popup Create Model Plase Here -->

    <!-- Popup Edit Model Plase Here -->
    <div id="myEditModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myEditModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myEditModalLabel">Edit Class</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
                <div class="modal-body" id="edit_modal_body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success float-end" id="editClassBtn">Update</button>
                </div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /Popup Edit Model Plase Here -->

    <!-- Delete Form -->
    <form id="delete_form" action="" method="post">
        @method('DELETE')
        @csrf
    </form>
@endsection

@push('js')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        $('.student-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('payments.index') }}",
            pageLength: 50,
            lengthMenu: [
                [10, 25, 50, 100, 500, 1000, -1],
                [10, 25, 50, 100, 500, 1000, "All"]
            ],
            dom: 'lBfrtip', // Add buttons to the table
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'], // Export buttons

            columns: [
                { name: 'check', data: 'check', sWidth: '3%', orderable: false },
                {
                    data: null,
                    name: 'index',
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    },
                    orderable: false,
                    searchable: false
                },
                { data: 'student', name: 'student' },
                { data: 'amount', name: 'amount' },
                { data: 'payment_type', name: 'payment_type' },
                { data: 'payment_date', name: 'payment_date' },
                { data: 'reference_number', name: 'reference_number' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });



        $(document.body).on('click', '#is_check_all', function(event) {
            var checked = event.target.checked;
            if (true == checked) {
                $('.check1').prop('checked', true);
            }
            if (false == checked) {
                $('.check1').prop('checked', false);
            }
        });

        $(document.body).on('click', '.check1', function(event) {
            var allItem = $('.check1');

            var array = $.map(allItem, function(el, index) {
                return [el]
            })

            var allChecked = array.every(isSameAnswer);

            function isSameAnswer(el, index, arr) {
                if (index === 0) {
                    return true;
                } else {
                    return (el.checked === arr[index - 1].checked);
                }
            }

            if (allChecked && array[0].checked) {
                $('#is_check_all').prop('checked', true);
            } else {
                $('#is_check_all').prop('checked', false);
            }
        });
    });
</script>

<script>

$(document).ready(function () {
    $('#createClassBtn').on('click', function (e) {
        e.preventDefault();

        // Serialize form data
        var formdata = $('#addClassForm').serialize();

        // Make AJAX request
        $.ajax({
            url: "{{ route('payments.store') }}", // Ensure this route exists
            type: 'POST', // Correct method name
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            },
            success: function (res) {
                // Toastify({
                //     text: res.success,
                //     duration: 3000,
                //     close: true,
                //     gravity: "top",
                //     position: "right",
                //     backgroundColor: "#28a745",
                //     stopOnFocus: true
                // }).showToast();

                showToast(res.success, "success");
                $('.student-table').DataTable().draw(false);
                $('#addClassForm')[0].reset();
                $('#myModal').modal('hide');
                // location.reload();
            },
            error: function (xhr) {
                // if (xhr.status === 422) {
                //     // Handle validation errors
                //     var errors = xhr.responseJSON.errors;
                //     var errorList = '<div class="alert alert-danger"><ul>';
                //     $.each(errors, function (key, value) {
                //         errorList += '<li>' + value[0] + '</li>';
                //     });
                //     errorList += '</ul></div>';
                //     $('.modal-body').prepend(errorList);
                // } else {
                //     alert('An error occurred. Please try again.');
                // }

                if (xhr.status === 422) {
                    // Handle validation errors
                    var errors = xhr.responseJSON.errors;

                    // Clear any previous error messages
                    $('.form-group .error-message').remove();

                    // Loop through errors and display them below the relevant input fields
                    $.each(errors, function (key, value) {
                        var inputField = $('[name="' + key + '"]');
                        inputField.closest('.form-group').append('<span class="text-danger error-message">' + value[0] + '</span>');
                    });
                } else {
                    showToast("An error occurred. Please try again.", "error");
                }
            }
        });
    });


        // Edit Modal
    $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        $('.data_preloader').show();
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'get',
            success: function(data) {
                $('#edit_modal_body').html(data);
                $('#myEditModal').modal('show');
                $('.data_preloader').hide();
            },
            error: function(err) {
                $('.data_preloader').hide();
                if (err.status == 0) {
                    showToast("Net Connetion Error. Reload This Page.", "error");
                } else {
                    showToast("Server Error. Please contact to the support team.", "error");
                }
            }
        });
    });

    $(document).on('click', '#editClassBtn',function(e) {
        e.preventDefault();
        $('.loading_button').show();
        var url = $('#editClassForm').attr('action');
        var request = $('#editClassForm').serialize();
        $('.error').html('');

        $.ajax({
            url: url,
            type: 'PATCH',
            data: request,
            success: function(data) {
                showToast(data, "success");
                $('#editClassForm')[0].reset();
                $('.loading_button').hide();
                $('.student-table').DataTable().draw(false);
                $('#myEditModal').modal('hide');
            },
            error: function(error) {
                $('.loading_button').hide();
                showToast("An error occurred. Please try again.", error);
            }
        });
    });


    $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#delete_form').attr('action', url);

            $.confirm({
                'title': 'Delete Confirmation',
                'message': 'Are you sure?',
                'buttons': {
                    'Yes': {
                        'class': 'yes btn-danger',
                        'action': function() {
                            // $('#delete_form').submit();
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                success: function(data) {
                                    showToast(data, "success");
                                    $('.loading_button').hide();
                                    $('.student-table').DataTable().draw(false);
                                },
                                error: function(error) {
                                    $('.student-table').DataTable().draw(false);
                                    $('.loading_button').hide();
                                    showToast("An error occurred. Please try again.", "error");
                                }
                            });
                        }
                    },
                    'No': {
                        'class': 'no btn-primary',
                        'action': function() {}
                    }
                }
            });
    });
});

</script>
@endpush

