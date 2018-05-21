<?php 
    use App\Http\Controllers\AccountSettingsController;
    use App\Http\Controllers\RolesAccessController;
?>

@extends('layouts.app')

@section('customCSS')

@endsection

@section('content')            
            <!-- page heading start-->
            <div class="page-heading">
                <h3>
                    {{ $branches->Name }}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ url('home') }}">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" onclick="return false;">Account Settings</a>
                    </li>
                    <li>
                        <a href="{{ url('accountsettings-branches') }}">Branches</a>
                    </li>
                    <li class="active"> {{ $branches->Name }} </li>
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
                                            <div class="title">Branch ID</div>
                                            <div class="desk">{{ $branches->ID }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Branch Name</div>
                                            <div class="desk">{{ $branches->Name }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Registration Number</div>
                                            <div class="desk">{{ $branches->RegistrationNo }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Phone</div>
                                            <div class="desk">{{ $branches->PhoneNo }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Fax Phone</div>
                                            <div class="desk">{{ $branches->FaxNo }}</div>
                                        </li>
                                        <li>
                                            <div class="title">SEO Name</div>
                                            <div class="desk">{{ $branches->SEOName }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Address</div>
                                            <div class="desk">{{ $branches->Address }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Email</div>
                                            <div class="desk">{{ $branches->Email }}</div>
                                        </li>
                                        <li>
                                            <div class="title">GST No.</div>
                                            <div class="desk">{{ $branches->GSTNo }}</div>
                                        </li>
                                        <li>
                                            <div class="title">GST Rate</div>
                                            <div class="desk">{{ $branches->GSTRate }} %</div>
                                        </li>
                                        <li>
                                            <div class="title">Website</div>
                                            <div class="desk"><?= ($branches->Website != '') ? '<a href="' . $branches->Website . '" target="_blank">' . $branches->Website . '</a>' : '' ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Minimum Top Up</div>
                                            <div class="desk">RM {{ $branches->MinProcess }}.00</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12  m-bot15">
                                            <?= (RolesAccessController::checkAccountSettingsUpdate() == true) ? '<a type="button" class="btn btn-blue pull-right btn-block" data-toggle="modal" href="#updatebranch" onclick="getBranchesById(' . $branches->ID . ')"><i class="fa fa-pencil m-r-1"></i> Update Details</a>' : '' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h4>Job Queue</h4>
                                    <hr>
                                </div>

                                <div class="col-xs-12 ol-md-offset-9 col-md-3">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12  m-bot15">
                                            <?= (RolesAccessController::checkAccountSettingsCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addservice"><i class="fa fa-plus m-r-1"></i> Add Service </a>' : '' ?>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <table class="table table-resp table-bordered">
                                        <thead class="cf">
                                            <tr>
                                                <th>Title</th>
                                                <th>Service Category</th>
                                                <th>Paper Size</th>
                                                <th>&#32;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jobqueues as $jobqueue)
                                            <tr>
                                                <td>{{ $jobqueue->Title }}</td>
                                                <td><?php echo AccountSettingsController::getServiceCategoriesByJobQueueId($jobqueue->ID); ?>
                                                </td>
                                                <td>{{ $jobqueue->PaperName }}</td>
                                                <td>
                                                    <div class="btn-group btn-block">
                                                        <button data-toggle="dropdown" class="btn btn-default btn-block dropdown-toggle btn-red-primex" type="button">Actions <span class="caret"></span></button>
                                                        <ul role="menu" class="dropdown-menu">
                                                            <?= (RolesAccessController::checkAccountSettingsUpdate() == true) ? '<li><a data-toggle="modal" href="#jobqueue" onclick="getJobQueueById(' . $jobqueue->ID . ')">Edit</a></li>' : '' ?>
                                                            <?= (RolesAccessController::checkAccountSettingsDelete() == true) ? '<li><a data-toggle="modal" href="#deletejobqueue" onclick="deleteJobQueueById(' . $jobqueue->ID . ', \'' . $jobqueue->Title . '\')">Delete</a></li>' : '' ?>
                                                            
                                                        </ul>
                                                    </div><!-- /btn-group btn-block -->
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--body wrapper end-->

            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="jobqueueLabel" role="dialog" tabindex="-1" id="jobqueue" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                            <h4 class="modal-title">Update Job Queue</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="updateJobQueue" class="form-horizontal adminex-form" method="POST" action="{{ url('accountsettings-branches-jobqueue-update') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                    <input type="hidden" id="updatejobqueue-id" name="update-jobqueue-id" value="" />
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12  col-xs-12">
                                            <div id="updatejobqueue-error" class="form-group p-l-1 p-r-1 hide">
                                                <div id="updatejobqueue-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                            </div>
                                            <div id="updatejobqueue-success" class="form-group p-l-1 p-r-1 hide">
                                                <div id="updatejobqueue-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Title</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="updatejobqueue-title" name="updatejobqueue-title" type="text" class="form-control" placeholder="Enter Job Queue Title">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Service Category</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    @foreach ($servicecategories as $servicecategory)
                                                    <div class="checkbox">
                                                        <label>
                                                            <input id="update-servicecategory-{{ $servicecategory->ID }}" name="update-servicecategories[]" type="checkbox" value="{{ $servicecategory->ID }}" />
                                                            {{ $servicecategory->Name }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Paper Size</label>
                                                <div class="col-xs-7 col-sm-7">
                                                     @foreach ($papersizes as $papersize)
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="update-papersizes[]" id="update-papersize-{{ $papersize->ID }}" value="{{ $papersize->ID }}">
                                                            {{ $papersize->Name }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-4 text-center">
                                            <button id="updatejobqueue-submit" type="submit" class="btn btn-red-primex btn-block">Save</button>
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
            <div aria-hidden="true" aria-labelledby="addserviceLabel" role="dialog" tabindex="-1" id="addservice" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                            <h4 class="modal-title">Add New Service</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="addJobQueue" class="form-horizontal adminex-form" method="POST" action="{{ url('accountsettings-branches-jobqueue-add') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                    <input type="hidden" name="add-branchid" value="{{ $branches->ID }}" />
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12  col-xs-12">
                                            <div id="add-error" class="form-group p-l-1 p-r-1 hide">
                                                <div id="add-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                            </div>
                                            <div id="add-success" class="form-group p-l-1 p-r-1 hide">
                                                <div id="add-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Title</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="add-name" name="add-name" type="text" class="form-control" placeholder="Enter Job Queue Title">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Service Category</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    @foreach ($servicecategories as $servicecategory)
                                                    <div class="checkbox">
                                                        <label>
                                                            <input id="add-servicecategory-{{ $servicecategory->ID }}" name="add-servicecategories[]" type="checkbox" value="{{ $servicecategory->ID }}" />
                                                            {{ $servicecategory->Name }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Paper Size</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    @foreach ($papersizes as $papersize)
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="add-papersizes[]" id="add-papersize-{{ $papersize->ID }}" value="{{ $papersize->ID }}">
                                                            {{ $papersize->Name }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-4 text-center">
                                            <button id="addjobqueue-submit" type="submit" class="btn btn-red-primex btn-block">Save</button>
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
            <div aria-hidden="true" aria-labelledby="updatebranchLabel" role="dialog" tabindex="-1" id="updatebranch" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                            <h4 class="modal-title">Update Branch Details</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="updateBranches" class="form-horizontal adminex-form" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12  col-xs-12">
                                            <div id="update-error" class="form-group p-l-1 p-r-1 hide">
                                                <div id="update-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                            </div>
                                            <div id="update-success" class="form-group p-l-1 p-r-1 hide">
                                                <div id="update-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Branch ID</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <label id="update-id" name="update-id" class="control-label">B01</label>
                                                    <input id="update-id-hidden" name="update-id-hidden" type="hidden" value="">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">SEO Name</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="update-seoName" name="update-seoName" type="text" maxlength="50" class="form-control" placeholder="Enter SEO Name">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Branch Name</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="update-name" name="update-name" type="text" class="form-control" placeholder="Enter Branch Name">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Branch Code</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="update-code" name="update-code" type="text" class="form-control" placeholder="Enter Branch Code">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Registration Number</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="update-registrationNo" name="update-registrationNo" type="text" maxlength="20" class="form-control" placeholder="Enter Registration Number">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Phone</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="update-phoneNo" name="update-phoneNo" type="text" maxlength="14" class="form-control" placeholder="Enter Phone">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Fax Number</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="update-faxNo" name="update-faxNo" type="text" maxlength="14" class="form-control" placeholder="Enter Fax Number">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Address</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <textarea id="update-address" name="update-address" type="text" class="form-control" type="text" placeholder="Enter Address"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Email</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="update-email" name="update-email" type="text" class="form-control" type="email" placeholder="Enter Email">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">GST No</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="update-gstNo" name="update-gstNo" type="text" maxlength="20" class="form-control" type="text" placeholder="Enter GST No">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">GST Rate</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <div class="input-group m-bot15">
                                                        <input id="update-gstRate" name="update-gstRate" type="text" maxlength="5" class="form-control text-right" value="6">
                                                        <span class="input-group-addon ">%</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Website</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <input id="update-website" name="update-website" type="text" class="form-control" type="text" placeholder="Enter Website">
                                                </div>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1">
                                                <label class="col-xs-5 col-sm-5 control-label">Minimum Top Up</label>
                                                <div class="col-xs-7 col-sm-7">
                                                    <div class="input-group m-bot15">
                                                        <span class="input-group-addon">RM</span>
                                                        <input id="update-minProcess" name="update-minProcess" type="text" maxlength="5" class="form-control text-right" value="100">
                                                        <span class="input-group-addon ">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-4 text-center">
                                            <button id="updatebranches-submit" type="submit" class="btn btn-red-primex btn-block">Save</button>
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
            <div aria-hidden="true" aria-labelledby="deletejobqueueLabel" role="dialog" tabindex="-1" id="deletejobqueue" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                            <h4 class="modal-title">Delete Job Queue </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="deleteJobQueue" class="form-horizontal adminex-form" method="POST" action="{{ url('accountsettings-branches-jobqueue-delete') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" id="deletejobqueue-id" name="deletejobqueue-id" value="" />
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12  col-xs-12 text-center">
                                            <span id="deleteConfirm">Are you sure you want to delete (<span id="deletejobqueue-title-2"></span>)?</span>
                                            <span id="deleteDone" class="hide">(<span id="deletejobqueue-title"></span>) successfully deleted!</span>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-4 text-center">
                                            <button id="deleteYes" type="button" class="btn btn-no-primex" data-dismiss="modal" aria-hidden="true">No</button>
                                            <button id="deletejobqueue-submit" type="submit" class="btn btn-red-primex">Yes</button>
                                            <button id="deleteClose" class="btn btn-red-primex hide" type="button" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">Close</button>
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

    var frm = $('#updateBranches');    
    frm.submit(function (e) {
        e.preventDefault();

        var seoname = $('#update-seoname').val();
        var name = $('#update-name').val();
        var code = $('#update-code').val();
        var registrationno = $('#update-registrationno').val();
        var phoneno = $('#update-phoneno').val();
        var faxno = $('#update-faxno').val();
        var address = $('#update-address').val();
        var email = $('#update-email').val();
        var gstno = $('#update-gstno').val();
        var gstrate = $('#update-gstrate').val();
        var website = $('#update-website').val();
        var minprocess = $('#update-minprocess').val();

        if(seoname == '' | code =='' | name =='' | registrationno =='' | phoneno =='' | faxno =='' | address =='' | email =='' | gstno =='' | gstrate =='' | website =='' | minprocess ==''){
            $('#update-error').removeClass('hide');
            $('#update-error-text').html("All fields are required!");
            $('#updatebranches-submit').removeClass('hide');

            return false;
        }

        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                    $('#update-error').addClass('hide');
                    $('#update-success, #updatebranches-submit').removeClass('hide');
                    $('#update-success-text').html(result.message);

                }else{
                    $('#update-success').addClass('hide');
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updatebranches-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });


    var frm2 = $('#addJobQueue');
    frm2.submit(function (e) {
        e.preventDefault();

        var name = $('#add-name').val();
        var servicecategories = false;
        $("input[name='add-servicecategories[]']").map(function(){ 
            if ($(this).prop('checked')) {
                servicecategories = true;
            }
        }).get();
        var papersizes = false;
        $("input[name='add-papersizes[]']").map(function(){ 
            if ($(this).prop('checked')) {
                papersizes = true;
            }
        }).get();

        if(name == '' | servicecategories == false | papersizes == false){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("All fields are required!");
            $('#addjobqueue-submit').removeClass('hide');

            return false;
        }

        $.ajax({
            type: frm2.attr('method'),
            url: frm2.attr('action'),
            data: frm2.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                    $('#add-error').addClass('hide');
                    $('#add-success, #addjobqueue-submit').removeClass('hide');
                    $('#add-success-text').html('Job Queue (' + result.data.jobQueueName + ') successfully added!');

                }else{
                    $('#add-success').addClass('hide');
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addjobqueue-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });


    var frm3 = $('#updateJobQueue');
    frm3.submit(function (e) {
        e.preventDefault();

        var title = $('#updatejobqueue-title').val();
        var papersizeid = $('#updatejobqueue-title').val();

        var servicecategories = false;
        $("input[name='update-servicecategories[]']").map(function(){ 
            if ($(this).prop('checked')) {
                servicecategories = true;
            }
        }).get();

        var papersizes = false;
        $("input[name='update-papersizes[]']").map(function(){ 
            if ($(this).prop('checked')) {
                papersizes = true;
            }
        }).get();

        if(title == '' | servicecategories == false | papersizes == false){
            $('#updatejobqueue-error').removeClass('hide');
            $('#updatejobqueue-error-text').html("All fields are required!");
            $('#updatejobqueue-submit').removeClass('hide');

            return false;
        }

        $.ajax({
            type: frm3.attr('method'),
            url: frm3.attr('action'),
            data: frm3.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                    $('#updatejobqueue-error').addClass('hide');
                    $('#updatejobqueue-success, #updatejobqueue-submit').removeClass('hide');
                    $('#updatejobqueue-success-text').html('Job Queue (' + result.data.jobQueueName + ') successfully updated!');

                }else{
                    $('#updatejobqueue-success').addClass('hide');
                    $('#updatejobqueue-error').removeClass('hide');
                    $('#updatejobqueue-error-text').html(result.message);
                    $('#updatejobqueue-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });

    var frm4 = $('#deleteJobQueue');
    frm4.submit(function (e) {
        e.preventDefault();

        var id = $('#deletejobqueue-id').val();

        $.ajax({
            type: frm4.attr('method'),
            url: frm4.attr('action'),
            data: frm4.serialize(),
            success: function (status) {
                var result = JSON.parse(status);

                if(result.status){
                    $('#deleteConfirm').addClass('hide');
                    $('#deleteDone').removeClass('hide');
                    $('#deleteYes').addClass('hide');
                    $('#deletejobqueue-submit').addClass('hide');
                    $('#deleteClose').removeClass('hide');
                }else{
                    alert(result.message);
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            },
        });
    });


    function getBranchesById(id) {
        //$('#updatecolors').html('');
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };
        $.ajax({
            url: $('#baseURL').val()+'/get-branches-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#update-id-hidden').val(result.branches.ID);
                    $('#update-id').html(result.branches.ID);
                    $('#update-name').val(result.branches.Name);
                    $('#update-seoName').val(result.branches.SEOName);
                    $('#update-code').val(result.branches.Code);
                    $('#update-address').val(result.branches.Address);
                    $('#update-phoneNo').val(result.branches.PhoneNo);
                    $('#update-faxNo').val(result.branches.FaxNo);
                    $('#update-email').val(result.branches.Email);
                    $('#update-minProcess').val(result.branches.MinProcess);
                    $('#update-registrationNo').val(result.branches.RegistrationNo);
                    $('#update-gstNo').val(result.branches.GSTNo);
                    $('#update-gstRate').val(result.branches.GSTRate);
                    $('#update-website').val(result.branches.Website);
                } else{
                    $('#updatebranch').html(result.message);
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }

    function getJobQueueById(id) {
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/get-jobqueue-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#updatejobqueue-id').val(result.jobqueues.ID);
                    $('#updatejobqueue-title').val(result.jobqueues.Title);

                    var len = result.jobqueuescategories.length;

                    for (i = 0; i < len; i++) { 
                        $('#update-servicecategory-' + result.jobqueuescategories[i]['ServiceCategoryID']).prop('checked', true);
                    }

                    $('#update-papersize-' + result.jobqueues.PaperSizeID).prop('checked', true);
                } else{
                    $('#jobqueue').html(result.message);
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }

    function deleteJobQueueById(id, title) {
        $('#deletejobqueue-id').val(id);
        $('#deletejobqueue-title').html(title);
        $('#deletejobqueue-title-2').html(title);
    }
</script>
@endsection 