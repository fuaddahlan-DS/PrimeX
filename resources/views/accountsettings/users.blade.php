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
                    Users
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ url('home') }}">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" onclick="return false;">Account Settings</a>
                    </li>
                    <li class="active"> Users </li>
                </ul>

            </div>
            <!-- page heading end-->
            <!--body wrapper start-->
            <div class="wrapper">


                <div class="row">
                    <div class="col-md-3 col-xs-12 col-sm-4">
                        <?= (RolesAccessController::checkAccountSettingsCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#adduser"><i class="fa fa-plus m-r-1"></i> Add User</a>' : '' ?>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-4 pull-right">
                        <div class="input-group m-bot15">
                        	<form method="get" action="">
	                            <input type="text" name="search" class="form-control">
	                            <span class="input-group-btn">
	                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
	                            </span>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <section>
                            <table class="table table-resp table-bordered">
                                <thead class="cf">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>&#32;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->RoleName }}</td>
                                        <td>
                                            <a type="button" class="btn btn-red-primex pull-right btn-block" href="{{ url('accountsettings-users') }}/{{ $user->id }}/"> View</a>
                                        </td>
                                    </tr>
                            		@endforeach
                                </tbody>
                            </table>
                        </section>
                        @php
                        $paginationLink = $users->links('vendor.pagination.bootstrap-4');
                        if(request()->has('search'))
                            $paginationLink = $users->appends(['search' => request()->input('search')])->links('vendor.pagination.bootstrap-4');
                        @endphp
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            {{$paginationLink}}
                        </div>
                    </div>
                </div>

            </div>
            <!--body wrapper end-->

            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="adduserLabel" role="dialog" tabindex="-1" id="adduser" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                            <h4 class="modal-title">Add New User</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="addUsers" class="form-horizontal adminex-form" method="POST" action="{{ url('accountsettings-users') }}">
                                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12  col-xs-12">
                                        	<div id="add-error" class="form-group p-l-1 p-r-1 hide">
	                                            <div id="add-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
	                                        </div>
	                                        <div id="add-success" class="form-group p-l-1 p-r-1 hide">
	                                            <div id="add-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
	                                        </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Name</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="add-name" name="add-name" type="text" pattern=".{4,}" required title="4 characters minimum" class="form-control" placeholder="Enter Name">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Email</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="add-email" name="add-email" type="email" required title="Please key in email in the correct format" class="form-control" placeholder="Enter Email">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Password</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="add-password" name="add-password" type="password" pattern=".{6,}" required title="6 characters minimum" class="form-control" placeholder="Enter Password">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Branch</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <select id="add-branchid" name="add-branchid" required title="Please select a branch" class="form-control m-bot15">
                                                    	<option value="">Please select</option>
                                                    	@foreach ($branches as $branch)
                                                        <option value="{{ $branch->ID }}">{{ $branch->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Role</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <select id="add-roleid" name="add-roleid" required title="Please select a role" class="form-control m-bot15">
                                                        <option value="">Please select</option>
                                                        @foreach ($roles as $role)
                                                        <option value="{{ $role->ID }}">{{ $role->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-4 text-center">
                                            <button id="addusers-submit" type="submit" class="btn btn-red-primex btn-block">Save</button>
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


</script>
@endsection 