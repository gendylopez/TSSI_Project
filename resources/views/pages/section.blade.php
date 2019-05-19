@extends('layouts.app')


@section('scripts')
<script type="text/javascript">

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$('#table').DataTable({
  processing: true,
  serverSide: true,
  ajax: '{!! URL::asset('/datatableSection') !!}',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'updated_at', name: 'updated_at' },
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]    
});

 $(document).on('click', '.edit-modal', function() {
    $('#editID').val($(this).data('id'));
    $('#edit-name').val($(this).data('name'));
    $('#editModal').modal('show');
});

$(function() { 
    $('#addModal').submit(function(e) { 
        e.preventDefault();
        
        $.ajax({
            url: '/addSection',
            type: 'POST',
            data: {_token: CSRF_TOKEN, 
                    name:$("#name").val()
                  },
            dataType: 'JSON',
            success: function (data) {
                console.log("ha");
                $('.form-horizontal')[0].reset();
                $('#addModal').modal('hide');
                BootstrapDialog.show({
                    message: 'Section successfully added.',
                    type:BootstrapDialog.TYPE_SUCCESS
                });
                location.reload();
            }
        }); 
    });
});

$(function() { 
    $('#editModal').submit(function(e) { 
        e.preventDefault();
        
        $.ajax({
            url: '/editSection',
            type: 'POST',
            data: {_token: CSRF_TOKEN, 
                    id:$("#editID").val(),
                    name:$("#edit-name").val()
                  },
            dataType: 'JSON',
            success: function (data) {
                BootstrapDialog.show({
                    message: 'Section successfully updated.',
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
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addSectionLabel">
  <div class="modal-dialog" role="document">
    <form class="form-horizontal" id="formDataAdd" method="post">
        @csrf <!-- {{ csrf_field() }} -->
    <div class="modal-content">
    
          <div class="modal-header">
            <h4 class="modal-title" >Add Section</h4>
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
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addSectionLabel">
  <div class="modal-dialog" role="document">
    <form class="form-horizontal" id="formDataEdit" method="post">
        @csrf <!-- {{ csrf_field() }} -->
    <div class="modal-content">
    
          <div class="modal-header">
            <h4 class="modal-title" >Update Section</h4>
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
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="addSectionLabel">
  <div class="modal-dialog" role="document">
    <form class="form-horizontal" id="formDataDelete" method="post">
        @csrf <!-- {{ csrf_field() }} -->
    <div class="modal-content">
    
          <div class="modal-header">
            <h4 class="modal-title" >Delete Section</h4>
            <button type="button" class="close" 
              data-dismiss="modal" 
              aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
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