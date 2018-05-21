<?php
    use App\Http\Controllers\RolesAccessController;
?>

@extends('layouts.app')

@section('customCSS')

@endsection

@section('content')
         <!-- page heading start-->
        <div class="page-heading">
            <h3>
               {{ $users->name }}
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Account Settings</a>
                </li>
                <li>
                    <a href="{{ url('accountsettings-users') }}">User</a>
                </li>
                <li class="active">{{ $users->name }}</li>
            </ul>
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper"> 
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-xs-12 col-sm-9 col-md-9"> 
                                <ul class="p-info">
                                    <li>
                                        <div class="title">User ID</div>
                                        <div class="desk">{{ $users->id }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Name</div>
                                        <div class="desk">{{ $users->name }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Email</div>
                                        <div class="desk">{{ $users->email }}</div>
                                    </li> 
                                    <li>
                                        <div class="title">Password</div>
                                        <div class="desk"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i></div>
                                    </li> 
                                    <li>
                                        <div class="title">Branch</div>
                                        <div class="desk">{{ $users->BranchName }}</div>
                                    </li> 
                                    <li>
                                        <div class="title">Role</div>
                                        <div class="desk">{{ $users->RoleName }}</div>
                                    </li> 
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3"> 
                                <div class="row"> 
                                    <div class="col-md-12 col-xs-12 col-sm-12  m-bot15">
                                        <?= (RolesAccessController::checkAccountSettingsUpdate() == true) ? '<a type="button" class="btn btn-blue pull-right btn-block" data-toggle="modal" href="#updatedetails"><i class="fa fa-pencil m-r-1"></i> Update Details</a>' : '' ?>
                                    </div> 
                                </div>
                            </div> 
                        </div>
                    </div>
                </div> 
            </div>

        </div>
        <!--body wrapper end-->

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="updatedetailsLabel" role="dialog" tabindex="-1" id="updatedetails" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href">&times;</button>
                        <h4 class="modal-title">Update User Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="updateUsers" class="form-horizontal adminex-form" method="POST">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <input type="hidden" name="update-id" value="{{ $usersid }}" />
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12  col-xs-12">
                                        <div id="update-error" class="form-group p-l-1 p-r-1 hide">
                                            <div id="update-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                        </div>
                                        <div id="update-success" class="form-group p-l-1 p-r-1 hide">
                                            <div id="update-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">User ID</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <label class="control-label">{{ $usersid }}</label>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-name" name="update-name" type="text" pattern=".{4,}" required title="4 characters minimum" value="{{ $users->name }}" class="form-control" placeholder="Enter Name">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Email</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-email" name="update-email" type="text" required title="Please key in email in the correct format" value="{{ $users->email }}"  class="form-control" placeholder="Enter Username">
                                            </div>
                                        </div> 

                                         <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Password</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-password" name="update-password" type="password" pattern=".{6,}" required title="6 characters minimum" value="******" class="form-control" placeholder="Enter Password">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Branch</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <select id="update-branchid" name="update-branchid" required title="Please select a branch" class="form-control m-bot15">
                                                    <option value="">Please select</option>
                                                    @foreach ($branches as $branch)
                                                    <option {{ ($branch->ID == $users->branchID) ? 'selected="selected"' : '' }} value="{{ $branch->ID }}">{{ $branch->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Role</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <select id="update-roleid" name="update-roleid" required title="Please select a role" class="form-control m-bot15">
                                                    <option value="">Please select</option>
                                                    @foreach ($roles as $role)
                                                    <option {{ ($role->ID == $users->roleID) ? 'selected="selected"' : '' }} value="{{ $role->ID }}">{{ $role->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 

                                    </div> 

                                </div>

                                <hr>

                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button id="updateusers-submit" type="submit" class="btn btn-red-primex btn-block" >Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <!-- modal -->

@endsection

@section('customJS')
<script type="text/javascript">
	var frm = $('#addUsers');

	frm.submit(function (e) {
        e.preventDefault();

        var name = $('#add-name').val();
        var email = $('#add-email').val();
        var password = $('#add-password').val();
        var branchid = $('#add-branch').val();
        var roleid = $('#add-role').val();

        if(name == '' | email == '' | password == '' | branchid == '' | roleid == ''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("All fields required!");
            $('#addroles-submit').removeClass('hide');

            return false;
        }

        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                    $('#add-success, #addusers-submit').removeClass('hide');
                    $('#add-success-text').html('User ('+result.data.usersName+') successfully added!');

                }else{
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addusers-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });

    var frm2 = $('#updateUsers');

    frm2.submit(function (e) {
        e.preventDefault();

        var name = $('#update-name').val();
        var email = $('#update-email').val();
        var password = $('#update-password').val();
        var branchid = $('#update-branch').val();
        var roleid = $('#update-role').val();

        if(name == '' | email == '' | password == '' | branchid == '' | roleid == ''){
            $('#update-error').removeClass('hide');
            $('#update-error-text').html("All fields required!");
            $('#updateusers-submit').removeClass('hide');

            return false;
        }

        $.ajax({
            type: frm2.attr('method'),
            url: frm2.attr('action'),
            data: frm2.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                    $('#update-success, #addusers-submit').removeClass('hide');
                    $('#update-success-text').html('User ('+result.data.usersName+') successfully updated!');

                }else{
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updateusers-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });


</script>
@endsection 