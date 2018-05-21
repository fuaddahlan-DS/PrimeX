<?php
    use App\Http\Controllers\RolesAccessController;
?>

@extends('layouts.app')

@section('content')
         <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Service Category
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('home')}}">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Settings</a>
                </li>
                <li class="active"> Service Categories </li>
            </ul>
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">


            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-4">
                    <?= (RolesAccessController::checkSettingsCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addsercat"><i class="fa fa-plus m-r-1"></i> Add New Category</a>' : '' ?>
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
                                <th>Service Category ID</th>
                                <th>Service Category Name</th>
                                <th>Description</th> 
                                <th>&#32;</th>
                            </tr>
                            </thead>
                            <tbody>
                            	@foreach ($serviceCategories as $serviceCategory)
                                <tr>
                                    <td>{{ $serviceCategory->ID }}</td>
                                    <td>{{ $serviceCategory->Name }}</td>
                                    <td>{{ $serviceCategory->Description }}</td>
                                    <td>
                                        <?= (RolesAccessController::checkSettingsUpdate() == true) ? '<a type="button" class="btn btn-blue-primex pull-right btn-block" data-toggle="modal" href="#updatesc" onclick="getServiceCategoryDetails(' . $serviceCategory->ID . ')">Edit</a>' : '' ?>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                    @php
                    $paginationLink = $serviceCategories->links('vendor.pagination.bootstrap-4');
                    if(request()->has('search'))
                        $paginationLink = $serviceCategories->appends(['search' => request()->input('search')])->links('vendor.pagination.bootstrap-4');
                    @endphp
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        {{$paginationLink}}
                    </div>
                </div>
            </div>

        </div>
        <!--body wrapper end-->



        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="addsercatLabel" role="dialog" tabindex="-1" id="addsercat" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href">&times;</button>
                        <h4 class="modal-title">Add New Category</h4>
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
                                            <label class="col-xs-5 col-sm-5 control-label">Service Category Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-name" name="name" type="text" class="form-control" placeholder="Enter Service Category Name">
                                            </div>
                                        </div> 

                                        
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <textarea id="add-description" name="description" type="text" class="form-control" type="text" placeholder="Enter Service Category Description"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Show in History</label>
                                            <div class="col-xs-7 col-sm-7">
                                               <div class="checkbox">
                                                    <label>
                                                        <input id="add-showinhistory" name="showinhistory" type="checkbox">
                                                    </label>
                                                </div> 
                                            </div>
                                        </div> 

                                    </div>  

                                </div>

                                <hr>


                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button class="btn btn-red-primex btn-block" type="button" id="addservicecategory-submit">Save</button>
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
        <div aria-hidden="true" aria-labelledby="updatescLabel" role="dialog" tabindex="-1" id="updatesc" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                        <h4 class="modal-title">Update Service Category Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        	<input type="hidden" id="updateServiceCategoryID">
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
                                            <label class="col-xs-5 col-sm-5 control-label">Service Category ID</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <label id="update-id" class="control-label"></label>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Service Category Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input type="text" id="update-name" name="name" class="form-control" placeholder="Enter Service Category Name">
                                            </div>
                                        </div> 

                                        
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <textarea type="text" id="update-description" name="description" class="form-control" type="text" placeholder="Enter Service Category Description"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Show in History</label>
                                            <div class="col-xs-7 col-sm-7">
                                               <div class="checkbox">
                                                    <label>
                                                        <input id="update-showinhistory" name="showinhistory" type="checkbox">
                                                    </label>
                                                </div> 
                                            </div>
                                        </div>

                                    	<div id="updateservicecategory" class="col-sm-12 col-xs-12 text-center"> 
                                    	</div>
                                    </div>  

                                </div>

                                <hr>

                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button type="button" class="btn btn-red-primex btn-block" type="button" id="updateservicecategory-submit">Save</button>
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
	$("#addservicecategory-submit").click(function() { 
        $('#addservicecategory-submit').addClass('hide');
        $('#add-error, #add-success').addClass('hide');
        var name = $('#add-name').val();
        var description = $('#add-description').val();
        var showinhistory = $('#add-showinhistory').prop('checked');

        if(name == '' | description==''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("Name and Description are required!");
            $('#addservicecategory-submit').removeClass('hide');
            return false;
        }

        if (showinhistory == true) {
        	showinhistory = 1;
        }
        else {
        	showinhistory = 0;
        }

        data = {
            'name': name,
            'description': description,
            'showinhistory': showinhistory,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/add-service-category',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#add-success, #addservicecategory-submit').removeClass('hide');
                    $('#add-success-text').html('Service Category record ('+result.data.serviceCategoryName+') successfully added!');

                }else{
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addservicecategory-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });



    $("#updateservicecategory-submit").click(function() { 
        $('#updateservicecategory-submit').addClass('hide');
        $('#update-error, #update-success').addClass('hide');
        var name = $('#update-name').val();
        var description = $('#update-description').val();
        var showinhistory = $('#update-showinhistory').prop('checked');
        var id = $('#updateServiceCategoryID').val();

        if(name == '' | description==''){
            $('#update-error').removeClass('hide');
            $('#update-error-text').html("Name and Description are required!");
            $('#updateservicecategory-submit').removeClass('hide');
            return false;
        }

        if (showinhistory == true) {
        	showinhistory = 1;
        }
        else {
        	showinhistory = 0;
        }

        data = {
            'name': name,
            'description': description,
            'showinhistory': showinhistory,
            'id': id,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/update-service-category',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#update-success, #updateservicecategory-submit').removeClass('hide');
                    $('#update-success-text').html(result.message);

                }else{
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updateservicecategory-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });


    function getServiceCategoryDetails(id){
        $('#updateservicecategory').html('');
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };
        $.ajax({
            url: $('#baseURL').val()+'/get-service-category-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                	$('#updateServiceCategoryID').val(result.servicecategories.ID);
                	$('#update-id').html(result.servicecategories.ID);
                	$('#update-name').val(result.servicecategories.Name);
                	$('#update-description').val(result.servicecategories.Description);

                	if (result.servicecategories.ShowInHistory == 1) {
                		$('#update-showinhistory').prop('checked', true);
                	}
                	else {
                		$('#update-showinhistory').prop('checked', false);
                	}
                }else{
                    $('#updateservicecategory').html(result.message);
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }
</script>
@endsection        