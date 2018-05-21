<?php
    use App\Http\Controllers\RolesAccessController;
?>

@extends('layouts.app')

@section('content')
         <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Services
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('home')}}">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Catalogue</a>
                </li>
                <li class="active"> Services </li>
            </ul>
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">


            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-4"> 
                    <?= (RolesAccessController::checkCataloguesCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addservice"><i class="fa fa-plus m-r-1"></i> Add New Service</a>' : '' ?>
                </div> 
                <div class="col-md-4 col-xs-12 col-sm-4 pull-right"> 
                    <div class="input-group m-bot15">
                        <form method="get" action="">
                            <input type="text" name="search" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submits"><i class="fa fa-search"></i></button>
                            </span>
                        </form>
                    </div>
                </div> 
            </div>

            <div class="row">
                <div class="col-md-12">
                    <section >
                        <table class="table table-resp table-bordered">
                            <thead class="cf">
                            <tr>
                                <th>Service ID</th>
                                <th>Service Name</th>
                                <th>Warranty (days)</th>  
                                <th>Service Category</th>
                                <th>&#32;</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->ID }}</td>
                                    <td>{{ $service->ServName }}</td>
                                    <th>{{ $service->WarrantyPeriod }}</th>  
                                    <td>{{ $service->Name }}</td>
                                    <td>
                                        <a type="button" class="btn btn-red-primex pull-right btn-block" href="view-catalogues-services/{{ $service->ID }}"> View</a> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                    @php
                    $paginationLink = $services->links('vendor.pagination.bootstrap-4');
                    if(request()->has('search'))
                        $paginationLink = $services->appends(['search' => request()->input('search')])->links('vendor.pagination.bootstrap-4');
                    @endphp
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        {{$paginationLink}}
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
                                                    <th>Size</th>
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

    var frm2 = $('#updateMerchandises');
    
    frm2.submit(function (e) {
        e.preventDefault();

        var name = $('#update-name').val();
        var description = $('#update-description').val();
        var normalprice = $('#update-normalprice').val();
        var membersprice = $('#update-membersprice').val();
        var uomid = $('#update-uomid').val();
        var includegst = $('#update-includegst').val();

        if(name == '' | description == '' | normalprice == '' | membersprice == '' | uomid == '' | includegst == ''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("All fields required!");
            $('#updatemerchandises-submit').removeClass('hide');

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
                    $('#update-success, #updatemerchandises-submit').removeClass('hide');
                    $('#update-success-text').html('Merchandise ('+result.data.merchandiseName+') successfully updated!');

                }else{
                	$('#update-success').addClass('hide');
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updatemerchandises-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });


    function getMerchandisesDetails(id) {
        //$('#updatemerch').html('');
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };
        $.ajax({
            url: $('#baseURL').val()+'/get-merchandises-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#update-hidden-id').val(result.merchandises.ID);
                    $('#update-id').html(result.merchandises.ID);
                    $('#update-name').val(result.merchandises.Name);
                    $('#update-description').val(result.merchandises.Description);
                    $('#update-normalprice').val(result.merchandises.NormalPrice);
                    $('#update-membersprice').val(result.merchandises.MembersPrice);
                    $('#update-uomid').val(result.merchandises.UnitID);
                    if (result.merchandises.IncludeGST == 1) {
                    	$('#update-includegst').prop('checked', true);	
                    }
                    else {
                    	$('#update-includegst').prop('checked', false);	
                    }
                } 
                else {
                    $('#update-success').addClass('hide');
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updatemerchandises-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }    
</script>
@endsection