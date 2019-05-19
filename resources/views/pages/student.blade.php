@extends('layouts.app')


@section('scripts')
<script type="text/javascript">

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$('#table').DataTable({
  processing: true,
  serverSide: true,
  ajax: '{!! URL::asset('/datatableStudent') !!}',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'age', name: 'age' },
        { data: 'phone', name: 'phone' },
        { data: 'address', name: 'address' },
        { data: 'section', name: 'section' },
        { data: 'created_at', name: 'created_at' },
        { data: 'updated_at', name: 'updated_at' },
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]    
});

 $(document).on('click', '.edit-modal', function() {
    $('#editID').val($(this).data('id'));
    $('#edit-name').val($(this).data('name'));
    $('#edit-age').val($(this).data('age'));
    $('#edit-phone').val($(this).data('phone'));
    $('#edit-address').val($(this).data('address'));
    $('#edit-section').val($(this).data('section'));
    $('#editModal').modal('show');
});

$(function() { 
    $('#addModal').submit(function(e) { 
        e.preventDefault();
        
        $.ajax({
            url: '/addStudent',
            type: 'POST',
            data: {_token: CSRF_TOKEN, 
                    name:$("#name").val(),
                    age:$("#age").val(),
                    phone:$("#phone").val(),
                    address:$("#address").val(),
                    section:$("#section").val()
                  },
            dataType: 'JSON',
            success: function (data) {
                BootstrapDialog.show({
                    message: 'Student successfully added.',
                    type:BootstrapDialog.TYPE_SUCCESS
                });
                $('.form-horizontal')[0].reset();
                $('#addModal').modal('hide');
                location.reload();
            }
        }); 
    });
});

$(function() { 
    $('#editModal').submit(function(e) { 
        e.preventDefault();
        
        $.ajax({
            url: '/editStudent',
            type: 'POST',
            data: {_token: CSRF_TOKEN, 
                    id:$("#editID").val(),
                    name:$("#edit-name").val(),
                    age:$("#edit-age").val(),
                    phone:$("#edit-phone").val(),
                    address:$("#edit-address").val(),
                    section:$("#edit-section").val()
                  },
            dataType: 'JSON',
            success: function (data) {
                BootstrapDialog.show({
                    message: 'Student successfully updated.',
                    type:BootstrapDialog.TYPE_SUCCESS
                });
                $('.form-horizontal')[0].reset();
                $('#editModal').modal('hide');
                location.reload();
            }
        }); 
    });
});

$(document).on('click', '.delete-modal', function() {
  $("#deleteMessage").text("Are you sure you want to delete this?");
  $('#deleteID').val($(this).data('id'));
  $('#deleteModal').modal('show');
});

$(function() { 
    $('#deleteModal').submit(function(e) { 
        e.preventDefault();
        
        $.ajax({
            url: '/deleteSection',
            type: 'POST',
            data: {_token: CSRF_TOKEN, 
                    id:$("#deleteID").val()
                  },
            dataType: 'JSON',
            success: function (data) {
                BootstrapDialog.show({
                    message: 'Section successfully deleted.',
                    type:BootstrapDialog.TYPE_SUCCESS
                });
                $('.form-horizontal')[0].reset();
                $('#deleteModal').modal('hide');
                location.reload();
            }
        }); 
    });
});

</script>
@endsection

@section('content')

<div class="container">

    <div class="form-group row mb-0">
        <div class="col-md-6">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">{{ __('Add') }}</button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-primary" id="refresh">{{ __('Refresh') }}</button>
        </div>
    </div>
    <div class="form-group"></div>

    <div class="row justify-content">
        <div class="col-lg-12">
            <div class="card">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Section</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

  <!-- START ADD MODALS -->     
<div class="modal fade in" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addStudentLabel">
  <div class="modal-dialog" role="document">
    <form class="form-horizontal" id="formData" method="post">
        @csrf <!-- {{ csrf_field() }} -->
    <div class="modal-content">
    
          <div class="modal-header">
            <h4 class="modal-title" >Add Student</h4>
            <button type="button" class="close" 
              data-dismiss="modal" 
              aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>

                <div class="col-md-6">
                    <input id="age" type="text" class="form-control" name="age" required autofocus>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                <div class="col-md-6">
                    <input id="phone" type="text" class="form-control" name="phone" required autofocus>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                <div class="col-md-6">
                    <input id="address" type="text" class="form-control" name="address" required autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="section" class="col-md-4 col-form-label text-md-right">{{ __('Section') }}</label>

                <div class="col-md-6">
                    <select id="section" type="section" class="form-control" name="section" required>
                     @foreach($sections as $section)
                        <option value="{{$section->id}}">{{$section->name}}</option>
                     @endforeach
                    </select>
                </div>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" 
               class="btn btn-default" 
               data-dismiss="modal">Close</button>
            <span class="pull-right">
              <button type="submit" id="addSubmit" class="btn btn-primary">Add</button>
            </span>
          </div>
    </div>
        </form>
  </div>
</div>
<!-- END ADD MODALS --> 

  <!-- START EDIT MODALS -->     
<div class="modal fade in" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addStudentLabel">
  <div class="modal-dialog" role="document">
    <form class="form-horizontal" id="formData" method="post">
        @csrf <!-- {{ csrf_field() }} -->
    <div class="modal-content">
    
          <div class="modal-header">
            <h4 class="modal-title" >Update Student</h4>
            <button type="button" class="close" 
              data-dismiss="modal" 
              aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <input id="edit-name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>

                <div class="col-md-6">
                    <input id="edit-age" type="text" class="form-control" name="age" required autofocus>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                <div class="col-md-6">
                    <input id="edit-phone" type="text" class="form-control" name="phone" required autofocus>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                <div class="col-md-6">
                    <input id="edit-address" type="text" class="form-control" name="address" required autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="section" class="col-md-4 col-form-label text-md-right">{{ __('Section') }}</label>

                <div class="col-md-6">
                    <select id="edit-section" type="section" class="form-control" name="section" required>
                     @foreach($sections as $section)
                        <option value="{{$section->id}}">{{$section->name}}</option>
                     @endforeach
                    </select>
                </div>
            </div>

            <input type="hidden" class="form-control" name="id" id="editID"/>


          </div>
          <div class="modal-footer">
            <button type="button" 
               class="btn btn-default" 
               data-dismiss="modal">Close</button>
            <span class="pull-right">
              <button type="submit" id="editSubmit" class="btn btn-primary">Update</button>
            </span>
          </div>
    </div>
        </form>
  </div>
</div>
<!-- END EDIT MODALS --> 

<!-- START DELETE MODALS -->     
<div class="modal fade in" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteLabel">
  <div class="modal-dialog" role="document">
    <form class="form-horizontal" id="formData" method="post">
        @csrf <!-- {{ csrf_field() }} -->
    <div class="modal-content">
    
          <div class="modal-header">
            <h4 class="modal-title" >Delete</h4>
            <button type="button" class="close" 
              data-dismiss="modal" 
              aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <div class="col-md-12">
                  <center><span id="deleteMessage"></span></center>
                </div>
              </div>

            <input type="hidden" class="form-control" name="id" id="deleteID"/>


          </div>
          <div class="modal-footer">
            <button type="button" 
               class="btn btn-default" 
               data-dismiss="modal">Close</button>
            <span class="pull-right">
              <button type="submit" id="deleteSubmit" class="btn btn-primary">Delete</button>
            </span>
          </div>
    </div>
        </form>
  </div>
</div>
<!-- END DELETE MODALS --> 
@endsection