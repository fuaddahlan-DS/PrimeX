<?php
    use App\Http\Controllers\RolesAccessController;
?>

@extends('layouts.app')

@section('content')
         <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Unit of Measurement
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('home')}}">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Settings</a>
                </li>
                <li class="active"> Unit of Measurements </li>
            </ul>
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">


            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-4"> 
                    <?= (RolesAccessController::checkSettingsCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#adduom"><i class="fa fa-plus m-r-1"></i> Add New Unit</a>' : '' ?>
                     
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
                                <th>Unit ID</th>
                                <th>Unit Name</th>
                                <th>Unit Description</th> 
                                <th>Code</th> 
                                <th>&#32;</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($unitOfMeasurement as $unitOfMeasurements)
                                <tr>
                                    <td>{{ $unitOfMeasurements->ID }}</td>
                                    <td>{{ $unitOfMeasurements->Name }}</td>
                                    <td>{{ $unitOfMeasurements->Description }}</td>
                                    <td>{{ $unitOfMeasurements->Code }}</td>
                                    <td>
                                        <?= (RolesAccessController::checkSettingsUpdate() == true) ? '<a type="button" class="btn btn-blue-primex pull-right btn-block" data-toggle="modal" href="#updateuom" onclick="getUnitOfMeasurementDetails(' . $unitOfMeasurements->ID . ')">Edit</a>' : '' ?>
                                         
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                    @php
                    $paginationLink = $unitOfMeasurement->links('vendor.pagination.bootstrap-4');
                    if(request()->has('search'))
                        $paginationLink = $unitOfMeasurement->appends(['search' => request()->input('search')])->links('vendor.pagination.bootstrap-4');
                    @endphp
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        {{$paginationLink}}
                    </div>
                </div>
            </div>

        </div>
        <!--body wrapper end-->


        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="adduomLabel" role="dialog" tabindex="-1" id="adduom" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href">&times;</button>
                        <h4 class="modal-title">Add New Unit</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal adminex-form" method="get">

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="add-error" class="form-group p-l-1 p-r-1 hide">
                                            <div id="add-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                        </div>
                                        <div id="add-success" class="form-group p-l-1 p-r-1 hide">
                                            <div id="add-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Unit Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-name" name="name" type="text" class="form-control" placeholder="Enter Unit Name">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Unit Code</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-code" name="code" type="text" class="form-control" placeholder="Enter Unit Code">
                                            </div>
                                        </div>  
                                        
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <textarea id="add-description" name="description" type="text" class="form-control" type="text" placeholder="Enter Unit Description"></textarea>
                                            </div>
                                        </div>
                                    </div>  

                                </div>

                                <hr>


                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button id="addunitofmeasurement-submit" type="button" class="btn btn-red-primex btn-block" >Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <!-- modal -->
 

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="updateuomLabel" role="dialog" tabindex="-1" id="updateuom" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                        <h4 class="modal-title">Update Unit Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="updateUnitOfMeasurementID">
                            <form class="form-horizontal adminex-form" method="get">

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="update-error" class="form-group p-l-1 p-r-1 hide">
                                            <div id="update-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                        </div>
                                        <div id="update-success" class="form-group p-l-1 p-r-1 hide">
                                            <div id="update-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Unit ID</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <label id="update-id" class="control-label"></label>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Unit Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-name" name="name" type="text" class="form-control" placeholder="Enter Unit Name">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Unit Code</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-code" name="code type="text" class="form-control" placeholder="Enter Unit Code">
                                            </div>
                                        </div>  
                                        
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <textarea id="update-description" name="description" type="text" class="form-control" type="text" placeholder="Enter Unit Description"></textarea>
                                            </div>
                                        </div>

                                        <div id="updateunitofmeasurement" class="col-sm-12 col-xs-12 text-center"> 
                                        </div>
                                    </div>  

                                </div>

                                <hr>

                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button id="updateunitofmeasurement-submit" type="button" class="btn btn-red-primex btn-block">Save</button>
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
	$("#addunitofmeasurement-submit").click(function() { 
        $('#addunitofmeasurement-submit').addClass('hide');
        $('#add-error, #add-success').addClass('hide');
        var name = $('#add-name').val();
        var description = $('#add-description').val();
        var code = $('#add-code').val();

        if(name == '' | code==''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("Name and Code are required!");
            $('#addunitofmeasurement-submit').removeClass('hide');
            return false;
        }

        data = {
            'name': name,
            'description': description,
            'code': code,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/add-unit-of-measurement',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#add-success, #addunitofmeasurement-submit').removeClass('hide');
                    $('#add-success-text').html('Unit Of Measurement record ('+result.data.unitOfMeasurementName+') successfully added!');

                }else{
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addunitofmeasurement-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });



    $("#updateunitofmeasurement-submit").click(function() { 
        $('#updateunitofmeasurement-submit').addClass('hide');
        $('#update-error, #update-success').addClass('hide');
        var name = $('#update-name').val();
        var description = $('#update-description').val();
        var code = $('#update-code').val();
        var id = $('#updateUnitOfMeasurementID').val();

        if(name == '' | code==''){
            $('#update-error').removeClass('hide');
            $('#update-error-text').html("Name and Code are required!");
            $('#updateunitofmeasurement-submit').removeClass('hide');
            return false;
        }

        data = {
            'name': name,
            'description': description,
            'code': code,
            'id': id,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/update-unit-of-measurement',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#update-success, #updateunitofmeasurement-submit').removeClass('hide');
                    $('#update-success-text').html(result.message);

                }else{
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updateunitofmeasurement-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });


    function getUnitOfMeasurementDetails(id){
        $('#updateunitofmeasurement').html('');
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };
        $.ajax({
            url: $('#baseURL').val()+'/get-unit-of-measurement-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                	$('#updateUnitOfMeasurementID').val(result.unitofmeasurement.ID);
                	$('#update-id').html(result.unitofmeasurement.ID);
                	$('#update-name').val(result.unitofmeasurement.Name);
                	$('#update-description').val(result.unitofmeasurement.Description);
                    $('#update-code').val(result.unitofmeasurement.Code);
                }else{
                    $('#updateunitofmeasurement').html(result.message);
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }
</script>
@endsection        