@extends('layouts.app')

@section('content')

<!-- page heading start-->
<div class="page-heading">
    <h3>
        Service Queue
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.html">Service Queue</a>
        </li>
        <li class="active"> Completed </li>
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
                </div>
                <div class="panel-body">
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
                        </div>


                        <div class="symbol">
                            <!--<button type="button" class="btn btn-blue btn-block"  data-dismiss="modal" data-toggle="modal" href="#editwashing-{{ $record->ID }}"><i class="fa fa-pencil"></i></button>-->
                            <form action="{{ URL::route('paidjob') }}" method="post" id="paid_wash_form"  style="margin-top:6px">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" value="{{ $record->ID }}" name="jobID">
                                <button type="button" class="btn btn-blue btn-block" onclick="window.location.href = '/editjob/{{ $record->ClientID }}/{{ $record->ID }}'"><i class="fa fa-pencil"></i></button>
                                <button type="submit" class="btn btn-success btn-block" ><i class="fa fa-usd"></i></button>
                                <button type="button" class="btn btn-warning btn-block" onclick="window.location.href = '/sale/{{ $record->SalesOrderID }}'"><i class="fa fa-print"></i></button>
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
                </div>
                <div class="panel-body">
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
                        </div>


                        <div class="symbol">
                            <!--<button type="button" class="btn btn-blue btn-block" data-dismiss="modal" data-toggle="modal" href="#edittreatment-{{ $record->ID }}"><i class="fa fa-pencil"></i></button>-->
                            <form action="{{ URL::route('paidjob') }}" method="post" id="paid_treat_form"  style="margin-top:6px">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" value="{{ $record->ID }}" name="jobID">
                                <button type="button" class="btn btn-blue btn-block" onclick="window.location.href = '/editjob/{{ $record->ClientID }}/{{ $record->ID }}'"><i class="fa fa-pencil"></i></button>
                                <button type="submit" class="btn btn-success btn-block" ><i class="fa fa-usd"></i></button>
                                <button type="button" class="btn btn-warning btn-block" onclick="window.location.href = '/sale/{{ $record->SalesOrderID }}'"><i class="fa fa-print"></i></button>
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
<!--body wrapper end-->

<!--footer section start-->
<footer>
    2017 &copy; PrimeX Auto Detailing
</footer>
<!--footer section end-->
@endsection

<script type="text/javascript">


</script>