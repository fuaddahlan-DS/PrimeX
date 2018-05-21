<?php
    use App\Http\Controllers\RolesAccessController;
?>

@extends('layouts.app')

@section('content')
         <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Merchandise
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('home')}}">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Catalogue</a>
                </li>
                <li class="active"> Merchandise </li>
            </ul>
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">


            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-4">
                	<?= (RolesAccessController::checkCataloguesCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addmerch"><i class="fa fa-plus m-r-1"></i> Add Merchandise</a>' : '' ?>
                     
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
                                <th>Merchandise ID</th>
                                <th>Merchandise Name</th>
                                <th>Description</th>
                                <th class="numeric">Normal Price</th> 
                                <th class="numeric">Members Price</th>
                                <th>&#32;</th>
                            </tr>
                            </thead>
                            <tbody>
                            	@foreach ($merchandises as $merchandise)
                                <tr>
                                    <td>{{ $merchandise->ID }}</td>
                                    <td>{{ $merchandise->Name }}</td>
                                    <td>{{ $merchandise->Description }}</td>
                                    <td class="numeric">RM {{ $merchandise->NormalPrice }}</td>
                                    <td class="numeric">RM {{ $merchandise->MembersPrice }}</td> 
                                    <td>
                                    	<?= (RolesAccessController::checkCataloguesUpdate() == true) ? '<a type="button" class="btn btn-blue-primex pull-right btn-block" data-toggle="modal" href="#updatemerch" onclick="getMerchandisesDetails(' . $merchandise->ID . ')">Edit</a>' : '' ?>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                     @php
                    $paginationLink = $merchandises->links('vendor.pagination.bootstrap-4');
                    if(request()->has('search'))
                        $paginationLink = $merchandises->appends(['search' => request()->input('search')])->links('vendor.pagination.bootstrap-4');
                    @endphp
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        {{$paginationLink}}
                    </div>
                </div>
            </div>

        </div>
        <!--body wrapper end-->

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="addmerchLabel" role="dialog" tabindex="-1" id="addmerch" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href">&times;</button>
                        <h4 class="modal-title">Add New Merchandise</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="addMerchandises" class="form-horizontal adminex-form" method="POST" action="{{ url('add-merchandises') }}">
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
                                            <label class="col-xs-5 col-sm-5 control-label">Merchandise Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-name" name="add-name" type="text" class="form-control" placeholder="Enter Merchandise Name">
                                            </div>
                                        </div> 

                                        
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <textarea id="add-description" name="add-description" type="text" class="form-control" type="text" placeholder="Enter Merchandise Description"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Normal Price</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <div class="input-group m-bot15 m-xs-t-0">
                                                    <span class="input-group-addon">RM</span>
                                                    <input id="add-normalprice" name="add-normalprice" type="text" class="form-control text-right" value="100">
                                                    <span class="input-group-addon ">.00</span>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Members Price</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <div class="input-group m-bot15 m-xs-t-0">
                                                    <span class="input-group-addon">RM</span>
                                                    <input id="add-membersprice" name="add-membersprice" type="text" class="form-control text-right" value="100">
                                                    <span class="input-group-addon ">.00</span>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Unit of Measurements</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <select id="add-uomid" name="add-uomid" class="form-control m-bot15">
                                                    <option value="">Please select</option>
                                                    @foreach ($uoms as $uom)
                                                    <option value="{{ $uom->ID }}">{{ $uom->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>  


                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Include GST (6%)</label>
                                            <div class="col-xs-7 col-sm-7">
                                               <div class="checkbox">
                                                    <label>
                                                        <input id="add-includegst" name="add-includegst" type="checkbox">
                                                    </label>
                                                </div> 
                                            </div>
                                        </div> 

                                   
                                    </div>  

                                </div>

                                <hr>


                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button id="addmerchandises-submit" type="submit" class="btn btn-red-primex btn-block" >Save</button>
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
        <div aria-hidden="true" aria-labelledby="updatemerchLabel" role="dialog" tabindex="-1" id="updatemerch" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href">&times;</button>
                        <h4 class="modal-title">Update Merchandise Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="updateMerchandises" class="form-horizontal adminex-form" method="POST" action="{{ url('update-merchandises') }}">
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
                                            <label class="col-xs-5 col-sm-5 control-label">Merchandise ID</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <label id="update-id" class="control-label">MCH02</label>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Merchandise Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-name" name="update-name" type="text" class="form-control" placeholder="Enter Merchandise Name">
                                            </div>
                                        </div> 

                                        
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Description</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <textarea id="update-description" name="update-description" type="text" class="form-control" type="text" placeholder="Enter Merchandise Description"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Normal Price</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <div class="input-group m-bot15 m-xs-t-0">
                                                    <span class="input-group-addon">RM</span>
                                                    <input id="update-normalprice" name="update-normalprice" type="text" class="form-control text-right" value="100">
                                                    <span class="input-group-addon ">.00</span>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Member Price</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <div class="input-group m-bot15 m-xs-t-0">
                                                    <span class="input-group-addon">RM</span>
                                                    <input id="update-membersprice" name="update-membersprice" type="text" class="form-control text-right" value="100">
                                                    <span class="input-group-addon ">.00</span>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Unit of Measurement</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <select id="update-uomid" name="update-uomid" class="form-control m-bot15">
                                                    <option value="">Please select</option>
                                                    @foreach ($uoms as $uom)
                                                    <option value="{{ $uom->ID }}">{{ $uom->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>  


                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Include GST (6%)</label>
                                            <div class="col-xs-7 col-sm-7">
                                               <div class="checkbox">
                                                    <label>
                                                        <input id="update-includegst" name="update-includegst" type="checkbox">
                                                    </label>
                                                </div> 
                                            </div>
                                        </div> 

                                   
                                    </div>  

                                </div>

                                <hr>


                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button id="updatemerchandises-submit" type="submit" class="btn btn-red-primex btn-block" >Save</button>
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
	var frm = $('#addMerchandises');
    
    frm.submit(function (e) {
        e.preventDefault();

        var name = $('#add-name').val();
        var description = $('#add-description').val();
        var normalprice = $('#add-normalprice').val();
        var membersprice = $('#add-membersprice').val();
        var uomid = $('#add-uomid').val();
        var includegst = $('#add-includegst').val();

        if(name == '' | description == '' | normalprice == '' | membersprice == '' | uomid == '' | includegst == ''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("All fields required!");
            $('#addmerchandises-submit').removeClass('hide');

            return false;
        }

        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                    $('#add-success, #addmerchandises-submit').removeClass('hide');
                    $('#add-success-text').html('Merchandise ('+result.data.merchandiseName+') successfully added!');

                }else{
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addmerchandises-submit').removeClass('hide');
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