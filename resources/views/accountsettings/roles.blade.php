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
                Roles
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Account Settings</a>
                </li>
                <li class="active"> Roles </li>
            </ul>
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">


            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-4"> 
                    <?= (RolesAccessController::checkAccountSettingsCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addrole"><i class="fa fa-plus m-r-1"></i> Add Role</a>' : '' ?>                    
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
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <section >
                        <table class="table table-resp table-bordered">
                            <thead class="cf">
                            <tr>
                                <th>Role ID</th>
                                <th>Name</th>
                                <th>Description</th> 
                                <th>&#32;</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->ID }}</td>
                                    <td>{{ $role->Name }}</td>
                                    <td>{{ $role->Description }}</td>  
                                    <td>
                                        <a type="button" class="btn btn-red-primex pull-right btn-block" href="{{ url('accountsettings-roles') }}/{{ $role->ID }}"> View</a> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                    @php
                    $paginationLink = $roles->links('vendor.pagination.bootstrap-4');
                    if(request()->has('search'))
                        $paginationLink = $roles->appends(['search' => request()->input('search')])->links('vendor.pagination.bootstrap-4');
                    @endphp
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        {{$paginationLink}}
                    </div>
                </div>
            </div>

        </div>
        <!--body wrapper end-->


        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="addroleLabel" role="dialog" tabindex="-1" id="addrole" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                        <h4 class="modal-title">Add Role</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="addRoles" class="form-horizontal adminex-form" method="POST">
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
                                                <input id="add-name" name="add-name" type="text" class="form-control" placeholder="Enter Name">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                 <textarea id="add-description" name="add-description" type="text" class="form-control" type="text" placeholder="Enter Role Description"></textarea>
                                            </div>
                                        </div>  
                                    </div> 
                                </div>

                                <div class="row"> 
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <section >
                                            <table class="table table-resp table-bordered">
                                                <thead class="cf">
                                                <tr>
                                                    <th>Permission</th>
                                                    <th>Create</th> 
                                                    <th>View</th>
                                                    <th>Update</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($rolespermissions as $rolespermission)
                                                    <tr>
                                                        <td>{{ $rolespermission->Name }}</td>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input name="{{ $rolespermission->ID }}[1]" type="checkbox">
                                                                </label>
                                                            </div> 
                                                        </td>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input name="{{ $rolespermission->ID }}[2]" type="checkbox">
                                                                </label>
                                                            </div> 
                                                        </td>  
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input name="{{ $rolespermission->ID }}[3]" type="checkbox">
                                                                </label>
                                                            </div> 
                                                        </td>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input name="{{ $rolespermission->ID }}[4]" type="checkbox">
                                                                </label>
                                                            </div> 
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </section>
                                    </div> 
                                </div>

                                <hr>

                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button id="addroles-submit" type="submit" class="btn btn-red-primex btn-block" >Save</button>
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

    var frm = $('#addRoles');
    
    frm.submit(function (e) {
        e.preventDefault();

        var name = $('#add-name').val();
        var description = $('#add-description').val();

        if(name == '' | description ==''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("Name and Description are required!");
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
                    $('#add-success, #addroles-submit').removeClass('hide');
                    $('#add-success-text').html('Role ('+result.data.roleName+') successfully added!');

                }else{
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addroles-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });
</script>
@endsection        