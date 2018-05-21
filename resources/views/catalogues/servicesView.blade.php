<?php
    use App\Http\Controllers\RolesAccessController;
?>

@extends('layouts.app')

@section('content')
         <!-- page heading start-->
        <div class="page-heading">
            <h3>
                {{ $servicesView->ServName }}
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="/home">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Catalogue</a>
                </li>
                <li>
                    <a href="/catalogues-services">Service</a>
                </li>
                <li class="active"> {{ $servicesView->ServName }} </li>
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
                                        <div class="title">Service ID</div>
                                        <div class="desk">{{ $servicesView->ID }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Service Name</div>
                                        <div class="desk">{{ $servicesView->ServName }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Warranty Period</div>
                                        <div class="desk">{{ $servicesView->WarrantyPeriod }}</div>
                                    </li> 
                                    <li>
                                        <div class="title">Service Category</div>
                                        <div class="desk">{{ $servicesView->Name }}</div>
                                    </li> 
                                    <li>
                                        <div class="title">Maintanence No.</div>
                                        <div class="desk">{{ $servicesView->MaintenanceCount }}</div>
                                    </li> 
                                    <li>
                                        <div class="title">Color</div>
                                        <div class="desk">{{ ($servicesView->ColorName == '') ? 'None' : $servicesView->ColorName }}</div>
                                    </li> 
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3"> 
                                <div class="row"> 
                                    <div class="col-md-12 col-xs-12 col-sm-12  m-bot15">
                                        <?= (RolesAccessController::checkCataloguesCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addservice"><i class="fa fa-plus m-r-1"></i> Add New Service</a>' : '' ?>
                                    </div> 
                                    <div class="col-md-12 col-xs-12 col-sm-12  m-bot15">
                                        <?= (RolesAccessController::checkCataloguesUpdate() == true) ? '<a type="button" class="btn btn-blue pull-right btn-block" data-toggle="modal" href="#updateservice" onclick="getServicesDetails(' . $servicesView->ID . ')"><i class="fa fa-pencil m-r-1"></i> Update Details</a>' : '' ?>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">  
                            <div class="col-md-12">
                                <h4>Pricing</h4>   
                                <hr>
                            </div> 
                             
                            <div class="col-md-12 ">
                                <section >
                                    <table class="table table-resp table-bordered">
                                        <thead class="cf">
                                        <tr>
                                            <th>Vehicle Type</th>
                                            <th>Normal Price</th>
                                            <th>Member Price</th> 
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicesViewPricing as $serviceViewPricing)
                                            <tr>
                                                <td>{{ $serviceViewPricing->Name }}</td>
                                                <td>RM {{ number_format($serviceViewPricing->NormalPrice, 2, '.', ',') }}</td>
                                                <td>RM {{ number_format($serviceViewPricing->MemberPrice, 2, '.', ',') }}</td> 
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
        <div aria-hidden="true" aria-labelledby="addserviceLabel" role="dialog" tabindex="-1" id="addservice" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href">&times;</button>
                        <h4 class="modal-title">Add New Service</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="addServices" class="form-horizontal adminex-form" method="POST" action="{{ url('add-services') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="add-error" class="form-group p-l-1 p-r-1 hide">
                                            <div id="add-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                        </div>
                                        <div id="add-success" class="form-group p-l-1 p-r-1 hide">
                                            <div id="add-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Service Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-name" name="add-name" type="text" class="form-control" placeholder="Enter Service Name">
                                            </div>
                                        </div> 

                                        
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <textarea id="add-description" name="add-description" type="text" class="form-control" type="text" placeholder="Enter Service Description"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Service Category</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <select id="add-servicecategory" name="add-servicecategory" class="form-control m-bot15">
                                                    <option value="">Please select</option>
                                                    @foreach ($servicecategories as $servicecategory)
                                                    <option value="{{ $servicecategory->ID }}">{{ $servicecategory->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Warranty</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <div class="input-group m-bot15"> 
                                                    <input id="add-warranty" name="add-warranty" type="text" class="form-control text-right" value="365">
                                                    <span class="input-group-addon ">days</span>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Maintenance</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-maintenance" name="add-maintenance" type="text" class="form-control" placeholder="Enter Maintenance">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Color</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <select id="add-color" name="add-color" class="form-control m-bot15">
                                                    <option value="">Please select</option>
                                                    @foreach ($colors as $color)
                                                    <option value="{{ $color->ID }}">{{ $color->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>  
                                    </div>  

                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <section >
                                            <table class="table table-resp table-bordered">
                                                <thead class="cf">
                                                <tr>
                                                    <th>Vehicle Type</th>
                                                    <th>Normal Price</th>
                                                    <th>Member Price</th> 
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($vehicletypes as $vehicletype)
                                                    <tr>
                                                        <td>{{ $vehicletype->Name }}</td>
                                                        <td>
                                                            <div class="input-group m-bot15 m-xs-t-0">
                                                                <span class="input-group-addon">RM</span>
                                                                <input id="add-pp-np-{{ $vehicletype->ID }}" name="add-pp-np-{{ $vehicletype->ID }}" type="text" class="form-control text-right" value="00">
                                                                <span class="input-group-addon ">.00</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group m-bot15 m-xs-t-0">
                                                                <span class="input-group-addon">RM</span>
                                                                <input id="add-pp-mp-{{ $vehicletype->ID }}" name="add-pp-mp-{{ $vehicletype->ID }}" type="text" class="form-control text-right" value="00">
                                                                <span class="input-group-addon ">.00</span>
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
                                        <button id="addservices-submit" type="submit" class="btn btn-red-primex btn-block" >Save</button>
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
        <div aria-hidden="true" aria-labelledby="updateserviceLabel" role="dialog" tabindex="-1" id="updateservice" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href">&times;</button>
                        <h4 class="modal-title">Update Service Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="updateServices" class="form-horizontal adminex-form" method="POST" action="{{ url('update-services') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" id="update-hidden-id" name="update-hidden-id" value="" />
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="update-error" class="form-group p-l-1 p-r-1 hide">
                                            <div id="update-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                        </div>
                                        <div id="update-success" class="form-group p-l-1 p-r-1 hide">
                                            <div id="update-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Service ID</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <label id="update-id" class="control-label">S02</label>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Service Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-name" name="update-name" type="text" class="form-control" placeholder="Enter Service Name">
                                            </div>
                                        </div> 

                                        
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <textarea id="update-description" name="update-description" type="text" class="form-control" type="text" placeholder="Enter Service Description"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Service Category</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <select id="update-servicecategory" name="update-servicecategory" class="form-control m-bot15">
                                                    <option value="">Please select</option>
                                                    @foreach ($servicecategories as $servicecategory)
                                                    <option value="{{ $servicecategory->ID }}">{{ $servicecategory->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Warranty</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <div class="input-group m-bot15"> 
                                                    <input id="update-warranty" name="update-warranty" type="text" class="form-control text-right" value="365">
                                                    <span class="input-group-addon ">days</span>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Maintenance</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-maintenance" name="update-maintenance" type="text" class="form-control" placeholder="Enter Maintenance">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Color</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <select id="update-color" name="update-color" class="form-control m-bot15">
                                                    <option value="">Please select</option>
                                                    @foreach ($colors as $color)
                                                    <option value="{{ $color->ID }}">{{ $color->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 

                                         

                                    </div>  


                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <section >
                                            <table class="table table-resp table-bordered">
                                                <thead class="cf">
                                                <tr>
                                                    <th>Vehicle Type</th>
                                                    <th>Normal Price</th>
                                                    <th>Member Price</th> 
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($vehicletypes as $vehicletype)
                                                    <tr>
                                                        <td>{{ $vehicletype->Name }}</td>
                                                        <td>
                                                            <div class="input-group m-bot15 m-xs-t-0">
                                                                <span class="input-group-addon">RM</span>
                                                                <input id="update-pp-np-{{ $vehicletype->ID }}" name="update-pp-np-{{ $vehicletype->ID }}" type="text" class="form-control text-right" value="00">
                                                                <span class="input-group-addon ">.00</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group m-bot15 m-xs-t-0">
                                                                <span class="input-group-addon">RM</span>
                                                                <input id="update-pp-mp-{{ $vehicletype->ID }}" name="update-pp-mp-{{ $vehicletype->ID }}" type="text" class="form-control text-right" value="00">
                                                                <span class="input-group-addon ">.00</span>
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
                                        <button id="updateservices-submit" type="submit" class="btn btn-red-primex btn-block" >Save</button>
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
	var frm = $('#addServices');
    
    frm.submit(function (e) {
        e.preventDefault();

        var name = $('#add-name').val();
        var description = $('#add-description').val();
        var warranty = $('#add-warranty').val();
        var servicecategory = $('#add-servicecategory').val();
        var color = $('#add-color').val();
        var maintenancecount = $('#add-maintenance').val();

        if(name == '' | description == '' | warranty == '' | servicecategory == '' | color == '' | maintenancecount == ''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("All fields required!");
            $('#addservices-submit').removeClass('hide');

            return false;
        }

        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                    $('#add-success, #addservices-submit').removeClass('hide');
                    $('#add-success-text').html('Service ('+result.data.servicesName+') successfully added!');

                }else{
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addservices-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });

    var frm2 = $('#updateServices');
    
    frm2.submit(function (e) {
        e.preventDefault();

        var name = $('#update-name').val();
        var description = $('#update-description').val();
        var warranty = $('#update-warranty').val();
        var servicecategory = $('#update-servicecategory').val();
        var color = $('#update-color').val();
        var maintenancecount = $('#update-maintenance').val();

        if(name == '' | description == '' | warranty == '' | servicecategory == '' | color == '' | maintenancecount == ''){
            $('#update-error').removeClass('hide');
            $('#update-error-text').html("All fields required!");
            $('#updateservices-submit').removeClass('hide');

            return false;
        }

        $.ajax({
            type: frm2.attr('method'),
            url: frm2.attr('action'),
            data: frm2.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                	$('#update-error').addClass('hide');
                    $('#update-success, #updateservices-submit').removeClass('hide');
                    $('#update-success-text').html(result.message);

                }else{
                	$('#update-success').addClass('hide');
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updateservices-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });


    function getServicesDetails(id) {
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };
        $.ajax({
            url: $('#baseURL').val()+'/get-services-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#update-hidden-id').val(result.services.ID);
                    $('#update-id').html(result.services.ID);
                    $('#update-name').val(result.services.Name);
                    $('#update-description').val(result.services.Description);
                    $('#update-servicecategory').val(result.services.ServiceCategoryID);
                    $('#update-warranty').val(result.services.WarrantyPeriod);
                    $('#update-maintenance').val(result.services.MaintenanceCount);
                    $('#update-color').val(result.services.ColorID);

                    for (i = 0; i < result.productprices.length; i++) {
                        $('#update-pp-np-' + result.productprices[i].VehicleTypeID).val(result.productprices[i].NormalPrice.split('.')[0]);
                        $('#update-pp-mp-' + result.productprices[i].VehicleTypeID).val(result.productprices[i].MemberPrice.split('.')[0]);
                    }
                } 
                else {
                    $('#update-success').addClass('hide');
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updateservices-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }    
</script>
@endsection