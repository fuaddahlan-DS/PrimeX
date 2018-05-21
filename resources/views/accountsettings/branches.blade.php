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
                    Branches
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ url('home') }}">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" onclick="return false;">Account Settings</a>
                    </li>
                    <li class="active"> Branches </li>
                </ul>

            </div>
            <!-- page heading end-->
            <!--body wrapper start-->
            <div class="wrapper">


                <div class="row">
                    <div class="col-md-3 col-xs-12 col-sm-4">
                        <?= (RolesAccessController::checkAccountSettingsCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addbranch"><i class="fa fa-plus m-r-1"></i> Add Branch</a>' : '' ?>                        
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
                                        <th>Branch ID</th>
                                        <th>Branch Name</th>
                                        <th>Phone Number</th>
                                        <th>Fax</th>
                                        <th>Email</th>
                                        <th>SEO Name</th>
                                        <th>&#32;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@foreach ($branches as $branch)
                                    <tr>
                                        <td>{{ $branch->ID }}</td>
                                        <td>{{ $branch->Name }}</td>
                                        <td>{{ $branch->PhoneNo }}</td>
                                        <td>{{ $branch->FaxNo }}</td>
                                        <td>{{ $branch->Email }}</td>
                                        <td>{{ $branch->SEOName }}</td>
                                        <td>
                                            <a type="button" class="btn btn-red-primex pull-right btn-block" href="{{ url('accountsettings-branches') }}/{{ $branch->ID }}"> View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                        @php
	                    $paginationLink = $branches->links('vendor.pagination.bootstrap-4');
	                    if(request()->has('search'))
	                        $paginationLink = $branches->appends(['search' => request()->input('search')])->links('vendor.pagination.bootstrap-4');
	                    @endphp
	                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
	                        {{$paginationLink}}
	                    </div>
                    </div>
                </div>

            </div>
            <!--body wrapper end-->


        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="addbranchLabel" role="dialog" tabindex="-1" id="addbranch" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                        <h4 class="modal-title">Add New Branch</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="addBranches" class="form-horizontal adminex-form" method="POST">
                            	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            	<div class="row">
                                    <div class="col-md-12 col-sm-12  col-xs-12">
                                    	<div id="add-error" class="form-group p-l-1 p-r-1 hide">
                                            <div id="add-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                        </div>
                                        <div id="add-success" class="form-group p-l-1 p-r-1 hide">
                                            <div id="add-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">SEO Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-seoname" name="add-seoname" maxlength="50" type="text" class="form-control" placeholder="Enter SEO Name">
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Branch Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-name" name="add-name" type="text" class="form-control" placeholder="Enter Branch Name">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Branch Code</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-code" name="add-code" type="text" maxlength="3" class="form-control" placeholder="Enter Branch Code">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Registration Number</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-registrationno" name="add-registrationno" maxlength="20" type="text" class="form-control" placeholder="Enter Registration Number">
                                            </div>
                                        </div>
 
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Phone</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-phoneno" name="add-phoneno" type="text" maxlength="14" class="form-control" placeholder="Enter Phone">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Fax Number</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-faxno" name="add-faxno" type="text" maxlength="14" class="form-control" placeholder="Enter Fax Number">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Address</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <textarea id="add-address" name="add-address" type="text" class="form-control" type="text" placeholder="Enter Address"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Email</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-email" name="add-email" type="text" class="form-control" type="email" placeholder="Enter Email">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">GST No</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-gstno" name="add-gstno" type="text" maxlength="20" class="form-control" type="text" placeholder="Enter GST No">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">GST Rate</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <div class="input-group m-bot15"> 
                                                    <input id="add-gstrate" name="add-gstrate" type="text" maxlength="5" class="form-control text-right" value="6">
                                                    <span class="input-group-addon ">%</span>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Website</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-website" name="add-website" type="text" class="form-control" type="text" placeholder="Enter Website">
                                            </div>
                                        </div> 

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Minimum Top Up</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <div class="input-group m-bot15">
                                                    <span class="input-group-addon">RM</span>
                                                    <input id="add-minprocess" name="add-minprocess" type="text" maxlength="5" class="form-control text-right" value="100">
                                                    <span class="input-group-addon ">.00</span>
                                                </div>
                                            </div>
                                        </div>  
                                    </div> 

                                </div>

                                <hr>

                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button id="addbranches-submit" type="submit" class="btn btn-red-primex btn-block" >Save</button>
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

    var frm = $('#addBranches');
    
    frm.submit(function (e) {
        e.preventDefault();

        var seoname = $('#add-seoname').val();
        var name = $('#add-name').val();
        var code = $('#add-code').val();
        var registrationno = $('#add-registrationno').val();
        var phoneno = $('#add-phoneno').val();
        var faxno = $('#add-faxno').val();
        var address = $('#add-address').val();
        var email = $('#add-email').val();
        var gstno = $('#add-gstno').val();
        var gstrate = $('#add-gstrate').val();
        var website = $('#add-website').val();
        var minprocess = $('#add-minprocess').val();

        if(seoname == '' | code =='' | name =='' | registrationno =='' | phoneno =='' | faxno =='' | address =='' | email =='' | gstno =='' | gstrate =='' | website =='' | minprocess ==''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("All fields are required!");
            $('#addbranches-submit').removeClass('hide');

            return false;
        }

        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                	$('#add-error').addClass('hide');
                    $('#add-success, #addbranches-submit').removeClass('hide');
                    $('#add-success-text').html('Branch Code ('+result.data.branchCode+') successfully added!');

                }else{
                	$('#add-success').addClass('hide');
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addbranches-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });
</script>
@endsection 