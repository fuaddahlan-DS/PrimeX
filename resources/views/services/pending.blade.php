@extends('layouts.app')

@section('content')
<!-- page heading start-->
<div class="page-heading">
    <h3>
        Service Queue
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="#">Service Queue</a>
        </li>
        <li class="active"> Pending </li>
    </ul>

</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">
    <div class="row service-queue">
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Washing Queue 

                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a> 
                    </span>

                    <a type="button" class="btn btn-danger btn-sm-red pull-right" data-toggle="modal" id="washingque" href="#newjob"><i class="fa fa-plus"></i></a> 
                </div>
                <div class="panel-body">
                    <div class="row p-l-1 p-r-1 m-bot-15">
                        <div class="input-group m-bot15 m-xs-t-0">
                            <input type="text" id="search-washing" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="search_w" type="button"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                    @if (empty($records_washing[0]))
                    <div class="panel white">
                        No Record Found
                    </div>
                    @else
                    @foreach($records_washing as $index => $record)
                    <div class="panel white washing_ls">
                        <div class="state-value">
                            <div class="value">{{ $record->car_number }}</div>
                            <div class="title">{{ $record->model }}</div>
                            <div>&nbsp;</div>
                            <div><label>Product Code : </label> {{ $record->productCode }}</div>  
                            <div><label>Remarks : </label> {{ $record->remarks }}</div>  
                        </div>


                        <div class="symbol">
                            <form action="{{ URL::route('completejob') }}" method="post" id="complete_wash_form" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" value="{{ $record->ID }}" name="jobID">
                                <button type="button" class="btn btn-blue btn-block" data-dismiss="modal" data-toggle="modal" onclick="window.location.href = '/editjob/{{ $record->ClientID }}/{{ $record->ID }}'"><i class="fa fa-pencil"></i></button>
                                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-danger btn-block" onclick="alertDeleteJob({{ $record->ID }})"><i class="fa fa-trash-o"></i></button>
                            </form>
                        </div>

                    </div>
                    <!-- Modal -->
                    <div aria-hidden="true" aria-labelledby="editwashing-{{ $record->ID }}" role="dialog" tabindex="-1" id="editwashing-{{ $record->ID }}" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Edit Service</h4>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ URL::route('update_service') }}" method="post" id="update_job" class="form-horizontal adminex-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" name="jobID" value="{{ $record->ID }}" />
                                        <div class="row">
                                            <div class="col-sm-4 col-sm-offset-4 text-center">


                                                <div class="form-group p-l-1 p-r-1">
                                                    <label class="col-sm-5 col-sm-5 control-label">Vehicle Number</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="VehicleNo" value="{{ $record->car_number }}" placeholder="Enter Vehicle Number">
                                                    </div>
                                                </div> 

                                                <div class="form-group p-l-1 p-r-1">
                                                    <label class="col-sm-5 col-sm-5 control-label">Vehicle Model</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" type="email" name="VehicleModel" value="{{ $record->model }}" placeholder="Enter Vehicle Model">
                                                    </div>
                                                </div> 

                                                <!--<div class="form-group p-l-1 p-r-1">
                                                    <label class="col-sm-5 col-sm-5 control-label">Service</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control m-bot15" name="serviceID">
                                                        @foreach($services as $service)
                                                         <option value="{{ $service->ID }}" {{ ($service->ID==3 ? 'selected' : '') }}>{{ $service->Name }}</option>
                                                         @endforeach
                                                        </select>
                                                    </div>
                                                </div> -->


                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="form-group ">
                                                <div class="col-sm-2">
                                                    <!--<button type="button" class="btn btn-red-primex btn-block" onClick="removeWashing({{ $record->ID }})">Remove</button>-->
                                                </div> 
                                                <div class="col-sm-6"></div>

                                                <div class="col-sm-2 ">
                                                    <button type="button" class="btn btn-warning btn-block" class="close" data-dismiss="modal">Cancel</button>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-blue-primex btn-block" >Update</button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ URL::route('removeService') }}" method="post" id="removeWashing">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" name="jobID" value="{{ $record->ID }}" />   
                                        <input type="hidden" name="JobQueueID" value="{{ $record->JobQueueID }}" />
                                        <input type="hidden" name="SalesOrderID" value="{{ $record->SalesOrderID }}" />
                                    </form>

                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- modal -->
                    @endforeach
                    @endif



                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Treatment Queue 

                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a> 
                    </span>

                    <a type="button" class="btn btn-danger btn-sm-red pull-right" data-toggle="modal" id="treatmentque" href="#newjob"><i class="fa fa-plus"></i></a> 
                </div>
                <div class="panel-body">
                    <div class="row p-l-1 p-r-1 m-bot-15">
                        <div class="input-group m-bot15 m-xs-t-0">
                            <input type="text" id="search-treatment" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="search_t" type="button"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>

                    @if (empty($records_treatment[0]))
                    <div class="panel white">
                        No Record Found
                    </div>
                    @else
                    @foreach($records_treatment as $index => $record)
                    <div class="panel white treatment_ls">
                        <div class="state-value">
                            <div class="value">{{ $record->car_number }}</div>
                            <div class="title">{{ $record->model }}</div> 
                            <div>&nbsp;</div>
                            <div><label>Product Code : </label> {{ $record->productCode }}</div>
                            <div><label>Remarks : </label> {{ $record->remarks }}</div>
                        </div>


                        <div class="symbol">
                            <form action="{{ URL::route('completejob') }}" method="post" id="complete_treat_form" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" value="{{ $record->ID }}" name="jobID">
                                <button type="button" class="btn btn-blue btn-block" data-dismiss="modal" data-toggle="modal" onclick="window.location.href = '/editjob/{{ $record->ClientID }}/{{ $record->ID }}'"><i class="fa fa-pencil"></i></button>
                                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-danger btn-block" onclick="alertDeleteJob({{ $record->ID }})"><i class="fa fa-trash-o"></i></button>
                            </form>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div aria-hidden="true" aria-labelledby="edittreatment-{{ $record->ID }}" role="dialog" tabindex="-1" id="edittreatment-{{ $record->ID }}" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Edit Service</h4>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ URL::route('update_service') }}" method="post" id="update_job" class="form-horizontal adminex-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" name="jobID" value="{{ $record->ID }}" />
                                        <div class="row">
                                            <div class="col-sm-4 col-sm-offset-4 text-center">


                                                <div class="form-group p-l-1 p-r-1">
                                                    <label class="col-sm-5 col-sm-5 control-label">Vehicle Number</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="VehicleNo" value="{{ $record->car_number }}" placeholder="Enter Vehicle Number">
                                                    </div>
                                                </div> 

                                                <div class="form-group p-l-1 p-r-1">
                                                    <label class="col-sm-5 col-sm-5 control-label">Vehicle Model</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" type="email" name="VehicleModel" value="{{ $record->model }}" placeholder="Enter Vehicle Model">
                                                    </div>
                                                </div> 

                                                <!--<div class="form-group p-l-1 p-r-1">
                                                    <label class="col-sm-5 col-sm-5 control-label">Service</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control m-bot15" name="serviceID">
                                                        @foreach($services as $service)
                                                         <option value="{{ $service->ID }}" {{ ($service->ID==3 ? 'selected' : '') }}>{{ $service->Name }}</option>
                                                         @endforeach
                                                        </select>
                                                    </div>
                                                </div> -->


                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="form-group ">
                                                <div class="col-sm-2">
                                                    <!--<button type="button" class="btn btn-red-primex btn-block" onClick="removeTreatment({{ $record->ID }})">Remove</button>-->
                                                </div> 
                                                <div class="col-sm-6"></div>

                                                <div class="col-sm-2 ">
                                                    <button type="button" class="btn btn-warning btn-block" class="close" data-dismiss="modal">Cancel</button>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-blue-primex btn-block" >Update</button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ URL::route('removeService') }}" method="post" id="removeTreatment">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" name="jobID" value="{{ $record->ID }}" />   
                                        <input type="hidden" name="JobQueueID" value="{{ $record->JobQueueID }}" />
                                        <input type="hidden" name="SalesOrderID" value="{{ $record->SalesOrderID }}" />
                                    </form>

                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- modal -->
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="newjobLabel" role="dialog" tabindex="-1" id="newjob" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add New Job</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12 border-right border-right-xs-none border-bottom-xs">
                        <form class="form-horizontal adminex-form" method="get">
                            <div class="form-group">
                                <label class="col-sm-5 col-sm-5 control-label">Car Number</label>
                                <div class="col-sm-7">
                                    <input type="text" id="RegistrationNo" class="form-control">
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-sm-5 col-sm-5 control-label">Member Name</label>
                                <div class="col-sm-7">
                                    <input type="text" id="Name" class="form-control">
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-sm-5 col-sm-5 control-label">Member Phone</label>
                                <div class="col-sm-7">
                                    <input type="text" id="ContactNo" class="form-control">
                                </div>
                            </div> 

                            <div class="form-group"> 
                                <div class="col-sm-offset-5 col-sm-7">
                                    <button type="button" class="btn btn-blue btn-block" data-dismiss="modal" data-toggle="modal" id="dosearchingmember" href="#resultModal"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </form>
                    </div> 

                    <div class="col-md-4 col-sm-4 col-xs-12 text-center">

                        <a  type="button" class="btn btn-warning btn-lg big-cash btn-block" href="{{ route("addjobcash") }}"><i class="fa fa-usd"></i> CASH</a> 

                        <hr>

                        <a type="button" class="btn btn-info btn-lg big-cash btn-block" data-dismiss="modal" data-toggle="modal" href="#addmember"><i class="fa fa-user"></i> NEW MEMBER</a> 
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>



<!-- Modal -->
<div aria-hidden="true" aria-labelledby="resultLabel" role="dialog" tabindex="-1" id="resultModal" class="modal fade">
    <div class="modal-dialog" id="resultMember"></div>
</div>
<!-- modal -->

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="newcarLabel" role="dialog" tabindex="-1" id="newcar" class="modal fade">
    <div class="modal-dialog"> 
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add New Car</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12  ">
                        <form class="form-horizontal adminex-form" method="get">
                            <div class="form-group">
                                <label class="col-sm-5 col-sm-5 control-label">Member Name</label>
                                <div class="col-sm-7">
                                    <label class="control-label">AHDESYA HARINDRAN</label>
                                </div>
                            </div>   

                            <div class="form-group">
                                <label class="col-sm-5 col-sm-5 control-label">Car Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"> 
                                <div class="col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 text-center">
                                    <button type="button" class="btn btn-success btn-block" data-dismiss="modal" data-toggle="modal" href="#result">  Save</button>
                                </div>
                            </div> 
                        </form>
                    </div> 
                </div>
            </div>  
        </div>
    </div>
</div>
<!-- modal -->


<!-- Modal -->
<div aria-hidden="true" aria-labelledby="addmemberLabel" role="dialog" tabindex="-1" id="addmember" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add New Member</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ URL::route('addNewMember') }}" method="post" id="add_new_member" class="form-horizontal adminex-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="redirect_page" value="pending" />

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">


                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-sm-5 col-sm-5 control-label">Name</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="ClientName" placeholder="Enter Name">
                                    </div>
                                </div> 

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-sm-5 col-sm-5 control-label">Email</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" type="email" name="Email" placeholder="Enter Email">
                                    </div>
                                </div> 

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-sm-5 col-sm-5 control-label">Phone Number</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="ContactNo" placeholder="Enter Phone Number">
                                    </div>
                                </div> 


                            </div> 

                            <div class="col-md-6 col-sm-6 col-xs-12 ">

                                <div class="p-xs-l-1 p-xs-r-1">

                                    <div class="form-group p-l-1 p-r-1">
                                        <label for="RegistrationNo">Vehicle Number</label>
                                        <input class="form-control"  name="RegistrationNo" placeholder="Enter Number Plate">
                                    </div>
                                    <div class="form-group p-l-1 p-r-1">
                                        <label for="model">Vehicle Model</label>
                                        <input class="form-control"  name="Model" placeholder="Exp: Myvi SE, Saga SE etc..">
                                    </div>

                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label for="Manufacturer">Vehicle Manufacturer</label>
                                        <select class="form-control m-bot15" name="Manufacturer">
                                            @foreach($vehicle_manufacturers as $vehicle_manufacturer)
                                            <option value="{{ $vehicle_manufacturer->ID }}">{{ $vehicle_manufacturer->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label for="VehicleType">Vehicle Type</label>
                                        <select class="form-control m-bot15" name="VehicleType">
                                            @foreach($vehicle_types as $vehicle_type)
                                            <option value="{{ $vehicle_type->ID }}">{{ $vehicle_type->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label for="VehicleColor">Vehicle Color</label>
                                        <select class="form-control m-bot15" name="VehicleColor">
                                            @foreach($vehicle_colors as $vehicle_color)
                                            <option value="{{ $vehicle_color->ID }}">{{ $vehicle_color->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div> 

                        </div>
                        <div class="text-center"><span id="error" class="error" style="color: Red;"></span></div>
                        <hr>

                        <div class="form-group"> 
                            <div class="col-sm-4 col-sm-offset-4 text-center">

                                <button id="addNewMember" type="button" class="btn btn-red-primex btn-block" >Save</button>

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
<div aria-hidden="true" aria-labelledby="topupLabel" role="dialog" tabindex="-1" id="topup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Top Up</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                <input type="hidden" id="topup-memberID">
                    <form class="form-horizontal adminex-form" method="get"> 
                        <div class="col-md-12 col-sm-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                            <div class="col-md-12 col-sm-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                                <div id="topup-error" class="form-group p-l-1 p-r-1 hide">
                                    <div id="topup-error-text" class="col-xs-12 col-xs-12 col-sm-12 text-center error"></div>
                                </div>
                                <div id="topup-success" class="form-group p-l-1 p-r-1 hide">
                                    <div id="topup-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-xs-5 col-sm-5 control-label">Member ID</label>
                                    <div class="col-sm-7">
                                        <label id="topup-memberCode" class="control-label"></label>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-xs-5 col-sm-5 control-label">Name</label>
                                    <div class="col-sm-7">
                                        <label id="topup-memberName" class="control-label"></label>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-xs-5 col-sm-5 control-label">Current Balance</label>
                                    <div class="col-sm-7">
                                        <label>RM</label><label id="topup-currentBalance" class="control-label"></label>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-xs-5 col-sm-5 control-label">Top Up Amount</label>
                                    <div class="col-sm-7">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon">RM</span>
                                            <input id="topup-amount" type="text" class="form-control text-right" value="100">
                                            <span class="input-group-addon ">.00</span>
                                        </div>
                                    </div>
                                </div> 

                                <div class="form-group ">
                                    <label class="col-xs-5 col-sm-5 control-label">Payment Type</label>
                                    <div class="col-sm-7">
                                        <select class="form-control m-bot15">
                                        @foreach ($payment_types as $payment_type)
                                            @if ($payment_type->id != 5)
                                            <option value="{{$payment_type->id}}">{{$payment_type->name}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>   
                            </div>  

                            <div class="form-group"> 
                                <div class="col-sm-4 col-sm-offset-4 text-center">
                                    <button id="topup-submit" type="button" class="btn btn-red-primex btn-block" >Save</button>
                                </div>
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
<div aria-hidden="true" aria-labelledby="deleteLabel" role="dialog" tabindex="-1" id="deleteJob" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cancel Job</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    Are you sure you want to cancel the job?
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnCancelJob" type="button" class="btn btn-success" onclick="">Yes</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->

<meta name="serviceCategory" content="" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
    $(document).ready(function () {
        $('#search-washing').keyup(function () {
            var txt = $('#search-washing').val();
            
            $('.washing_ls').each(function () {
                if ($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != - 1) {
                    $(this).show();
                } 
                else {
                    $(this).hide();
                }
            });
        });
            
        $('#search-treatment').keyup(function () {
            var txt = $('#search-treatment').val();
            
            $('.treatment_ls').each(function () {
                if ($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != - 1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
            
        $('#dosearchingmember').click(function () {
            $('#resultMember').html('Loading..');
            
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var serviceCategory = $('meta[name="serviceCategory"]').attr('content');
            $.ajax({
            type: 'GET',
                    url: '{{ route("member-search") }}',
                    data: {
                    _token: CSRF_TOKEN,
                            CategoryService: serviceCategory,
                            Name: $("#Name").val(),
                            RegistrationNo: $("#RegistrationNo").val(),
                            ContactNo: $("#ContactNo").val(),
                    },
                    dataType: "html",
                    success: function (data) {
                    //Success!

                    $('#resultMember').html(data);
                    },
                    error: function (xhr, status) {
                    //window.location.reload();
                    },
                    complete: function (xhr, status) {
                    //$('#loader').addClass('hide');

                    }
            });
        });
            
        $('#washingque').click(function () {
            $('meta[name=serviceCategory]').attr('content', 3);
        });
            
        $('#treatmentque').click(function () {
            $('meta[name=serviceCategory]').attr('content', 2);
        });
    });


            
    function removeWashing(id){
        var txt;
        var r = confirm("Are you sure you want to remove this service?");
                    
        if (r == true) {
            document.getElementById("removeWashing").submit();
        } else 
        {

        }

    }

    function alertDeleteJob(id) {
        $('#btnCancelJob').attr('onclick', 'deleteJob(' + id + ')');
        $('#deleteJob').modal();
    }

    function deleteJob(id) {
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/removeJob',
            type: 'POST',
            data: data,
            success: function (status) {
                document.location.href = '/service-pending';
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }


    function topup(id){
        $('#updatecar-list, #updatenewcar-list').html('');
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };
        $.ajax({
            url: $('#baseURL').val()+'/get-member-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#topup-memberID').val(result.member.ID);
                    $('#topup-memberCode').html(result.member.Code);
                    $('#topup-memberName').html(result.member.Name);
                    var CB = result.member.CreditBalance;
                    $('#topup-currentBalance').html(CB.substring(0, CB.length - 2));
                }else{
                    $('#topup-error').removeClass('hide');
                    $('#topup-error-text').html(result.message);
                    $('#topup-submit').removeAttr('disabled');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });

    }

    $('#addNewMember').click(function() {
        var name = $("input[name='ClientName']").val();
        var email = $("input[name='Email']").val();
        var contactno = $("input[name='ContactNo']").val();
        var registrationno = $("input[name='RegistrationNo']").val();
        var model = $("input[name='Model']").val();

        if (name == '' || email == '' || contactno == '' || registrationno == '' || model == '') {
            $('#error').text('Please fill all fields');
        }
        else {
            if (ValidateEmail(email) == 'fail') {
                $('#error').text('Invalid email');
            }
            else if (ValidatePhone(contactno) == 'fail') {
                $('#error').text('Invalid phone number');
            }
            else {
                $('#add_new_member').submit();
            }
        }

    });

    function ValidateEmail(mail) 
    {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
            return 'success';
        }

        return 'fail';
    }

    function ValidatePhone(phone) 
    {
        if (/^\d+$/.test(phone)) {
            return 'success';
        }

        return 'fail';
    }

    $("#topup-submit").click(function() { 
        $('#topup-submit').attr('disabled','true');
        $('#topup-error, #topup-success').addClass('hide');
        var amount = $('#topup-amount').val();
        var id = $('#topup-memberID').val();
        var memberCode = $('#topup-memberCode').html();

        if(amount == ''){
            $('#topup-error').removeClass('hide');
            $('#topup-error-text').html("All fields are required!");
            $('#topup-submit').removeAttr('disabled');
            return false;
        }

        if(!amount.match(/^[0-9]{1,7}$/)){
            $('#topup-error').removeClass('hide');
            $('#topup-error-text').html("Invalid amount!");
            $('#topup-submit').removeAttr('disabled');
            return false;
        }
       
        data = {
            'amount': amount,
            'id': id,
            '_token': $('input[name=_token]').val(),
            'memberCode': memberCode,
        };

        $.ajax({
            url: $('#baseURL').val()+'/member-topup',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#topup-success').removeClass('hide');
                    $('#topup-success-text').html(result.message);
                    $('#topup-submit').removeAttr('disabled');
                    $('#topup-amount').val('');
                    var CB = result.data.amount;
                    $('#topup-currentBalance').html(CB.substring(0, CB.length - 2));
                }else{
                    $('#topup-error').removeClass('hide');
                    $('#topup-error-text').html(result.message);
                    $('#topup-submit').removeAttr('disabled');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });
</script>
@endsection

