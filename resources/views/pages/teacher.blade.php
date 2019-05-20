@extends('layouts.app')

@section('scripts')
<script>

$(document).ready(function(){
  
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  $('#formData').submit(function(e) { 
    e.preventDefault();
    $.ajax({
        url: '/editTeacher',
        type: 'POST',
        data: {_token: CSRF_TOKEN,
                name:$("#name").val(),
                subject:$("#subject").val(),
                email:$("#emailaddress").val(),
                dataType: 'JSON',
                success: function (data) {
                    BootstrapDialog.show({
                        message: 'successfully updated your account.',
                        type:BootstrapDialog.TYPE_SUCCESS
                    });
                 location.reload();
                }
        }
    });
  });



  $('#changePasswordForm').submit(function(e) { 
          e.preventDefault();
              $.ajax({
                url: '/editPassword',
                type: 'POST',
                data: {_token: CSRF_TOKEN, 
                        oldpass:$("#oldpass").val(),
                        action:'oldcheck'},
                dataType: 'JSON',
                success: function (data) {
                  if(data[0] == "1"){
                    BootstrapDialog.show({
                        message: 'Your current password is incorrect.',
                        type:BootstrapDialog.TYPE_WARNING
                    });
                  }
                  else
                  {
                    $.ajax({
                        url: '/editPassword',
                        type: 'POST',
                        data: {_token: CSRF_TOKEN, 
                                action:'changepass',
                                newpass:$("#newpass").val()},
                        dataType: 'JSON',
                        success: function (data) {
                          BootstrapDialog.show({
                              message: 'Password successfully changed.',
                              type:BootstrapDialog.TYPE_SUCCESS
                          });
                      //    location.reload();
                      }
                    }); 
                  }
              }
            });    
  });

});


</script>
@endsection



@section('content')
<div class="row">
  <div class="col-md-1"></div>
  <div class="col-md-4">
      <h3>Update Details</h3><br/>
      <form class="form-horizontal" id="formData">
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" value="{{$account->name}}" id="name" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Email Address</label>
                        <div class="col-sm-10">
                            <input type="email" value="{{Auth::user()->email}}" id="emailaddress" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Subject</label>
                        <div class="col-sm-10">
                          <select id="subject" type="subject" class="form-control" name="subject" required>
                           @foreach($subjects as $subject)
                              <option value="{{$subject->id}}">{{$subject->name}}</option>
                           @endforeach
                          </select>
                        </div>
                    </div>

                  <button style="float:right" type="submit" class="btn btn-success">Update Details</button>

          </form>

      <br /><br/>
  </div>
  <div class="col-md-1">
  </div>
  <div class="col-md-4">
      <div class="form-group col-md-8">
      <form id="changePasswordForm">
          <h3>Change Your Password</h3>
          <br />
          <div class="form-group " id="curpass"><label >Enter Current Password</label>
          <input type="password" id="oldpass" class="form-control" required></div>
          <label>Enter New Password</label>
          <input type="password" id="newpass" class="form-control" required>
          <br>
          <button style="float:right" type="submit" class="btn btn-warning" >Change Password</button>
      </form>
      </div>
  </div>
</div>
@endsection