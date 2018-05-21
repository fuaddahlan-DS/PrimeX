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
               {{ $roles->Name }}
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Account Settings</a>
                </li>
                <li>
                    <a href="{{ url('accountsettings-roles') }}">Roles</a>
                </li>
                <li class="active">{{ $roles->Name }}</li>
            </ul>
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper"> 
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-xs-12 col-sm-9 col-md-9"> 
                                <ul class="p-info">
                                    <li>
                                        <div class="title">Role ID</div>
                                        <div class="desk">{{ $roles->ID }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Name</div>
                                        <div class="desk">{{ $roles->Name }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Description</div>
                                        <div class="desk">{{ $roles->Description }}</div>
                                    </li> 
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3"> 
                                <div class="row"> 
                                    <div class="col-md-12 col-xs-12 col-sm-12  m-bot15">
                                        <?= (RolesAccessController::checkAccountSettingsUpdate() == true) ? '<a type="button" class="btn btn-blue pull-right btn-block" data-toggle="modal" href="#updatedetails" onclick="getRolesById(' . $roles->ID . ')"><i class="fa fa-pencil m-r-1"></i> Update Details</a>' : '' ?>                           
                                    </div> 
                                </div>
                            </div> 

                            <div class="col-md-12 col-sm-12 col-xs-12 m-t-2">
                                <section>
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
                                            @foreach ($rolespermissionsjoin as $rolespermissions)
                                            <tr>
                                                <td>{{ $rolespermissions->Name }}</td>
                                                <td><?= $rolespermissions->PermissionCreate == 1 ? '<i class="fa fa-check" aria-hidden="true"></i>' : '' ?></td>
                                                <td><?= $rolespermissions->PermissionView == 1 ? '<i class="fa fa-check" aria-hidden="true"></i>' : '' ?></td>  
                                                <td><?= $rolespermissions->PermissionUpdate == 1 ? '<i class="fa fa-check" aria-hidden="true"></i>' : '' ?></td>
                                                <td><?= $rolespermissions->PermissionDelete == 1 ? '<i class="fa fa-check" aria-hidden="true"></i>' : '' ?></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </section>
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                        <h4 class="modal-title">Update Role Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="updateRoles" class="form-horizontal adminex-form" method="POST">
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
                                            <label class="col-xs-5 col-sm-5 control-label">Role ID</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <label id="update-id" name="update-id" class="control-label">RL03</label>
                                                <input id="update-id-hidden" name="update-id-hidden" type="hidden" value="">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-name" name="update-name" type="text" class="form-control" placeholder="Enter Name">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                 <textarea id="update-description" name="update-description" type="text" class="form-control" type="text" placeholder="Enter Role Description"></textarea>
                                            </div>
                                        </div>  
                                    </div> 
                                </div>

                                <div class="row"> 
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <section>
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
                                                    @foreach ($rolespermissionsjoin as $rolespermission)
                                                    <tr>
                                                        <td>{{ $rolespermission->Name }}</td>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input id="{{ $rolespermission->ID }}-1" name="{{ $rolespermission->ID }}[1]" type="checkbox">
                                                                </label>
                                                            </div> 
                                                        </td>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input id="{{ $rolespermission->ID }}-2" name="{{ $rolespermission->ID }}[2]" type="checkbox">
                                                                </label>
                                                            </div> 
                                                        </td>  
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input id="{{ $rolespermission->ID }}-3" name="{{ $rolespermission->ID }}[3]" type="checkbox">
                                                                </label>
                                                            </div> 
                                                        </td>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input id="{{ $rolespermission->ID }}-4" name="{{ $rolespermission->ID }}[4]" type="checkbox">
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
                                        <button id="updateroles-submit" type="submit" class="btn btn-red-primex btn-block" >Save</button>
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

    var frm = $('#updateRoles');
    
    frm.submit(function (e) {
        e.preventDefault();

        var name = $('#update-name').val();
        var description = $('#update-description').val();

        if(name == '' | description ==''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("Name and Description are required!");
            $('#updateroles-submit').removeClass('hide');

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
                    $('#add-success-text').html(result.message);
                }else{
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#updateroles-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });

    function getRolesById(id) {
        $('#updatecolors').html('');
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };
        $.ajax({
            url: $('#baseURL').val()+'/get-roles-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#update-id-hidden').val(result.roles.ID);
                    $('#update-id').html(result.roles.ID);
                    $('#update-name').val(result.roles.Name);
                    $('#update-description').val(result.roles.Description);

                    var data = result.rolespermissionsjoin;

                    for(var i in data)
                    {
                        var id = data[i].ID;
                        var permissioncreate = data[i].PermissionCreate;
                        var permissionview = data[i].PermissionView;
                        var permissionupdate = data[i].PermissionUpdate;
                        var permissiondelete = data[i].PermissionDelete;

                        if (permissioncreate == "1") {
                            $('#'+id+'-1').prop('checked', true);
                        }

                        if (permissionview == "1") {
                            $('#'+id+'-2').prop('checked', true);
                        }

                        if (permissionupdate == "1") {
                            $('#'+id+'-3').prop('checked', true);
                        }

                        if (permissiondelete == "1") {
                            $('#'+id+'-4').prop('checked', true);
                        }
                    }
                }else{
                    $('#updatedetails').html(result.message);
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }
</script>
@endsection        