@extends('layouts.app')

@section('content')
<!-- page heading start-->
<div class="page-heading">
    <h3>
        Sales Order Number
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.html">Dashboard</a>
        </li>
        <li>
            <a href="salesorder.html">Sales Order</a>
        </li>
        <li class="active"> {{ $data['sales_details']->SalesNo }} </li>
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
                                <div class="title">Date</div>
                                <div class="desk">{{ $data['sales_details']->SalesDate }}</div>
                            </li>
                            <li>
                                <div class="title">Sales Order No.</div>
                                <div class="desk">{{ $data['sales_details']->SalesNo }}</div>
                            </li>
                            <li>
                                <div class="title">Name</div>
                                <div class="desk">{{ $data['sales_details']->ClientName }}</div>
                            </li>
                            <li>
                                <div class="title">Vehicle Number</div>
                                <div class="desk">{{ $data['sales_details']->VehicleRegistrationNo }}</div>
                            </li>
                            <li>
                                <div class="title">Current Balance</div>
                                <div class="desk">RM {{ $data['sales_details']->memberBalance }}</div>
                            </li> 
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3"> 
                        <div class="row">  
                            <div class="col-md-12 col-xs-12 col-sm-12  m-bot15"> 
                                <a type="button" class="btn btn-blue pull-right btn-block" data-toggle="modal" href="#updateso"><i class="fa fa-pencil m-r-1"></i> Update Details</a> 
                            </div>
                            <form action="{{ URL::route('print-sale') }}" class="transfer" target="_blank" method="post" id="print_form" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="SalesOrderID" value="{{ $data['sales_details']->ID }}" />
                                <div class="col-md-12 col-xs-12 col-sm-12  m-bot15"> 
                                    <button type="submit" class="btn btn-red-primex pull-right btn-block" ><i class="fa fa-print m-r-1"></i> Print Receipt</button> 
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">  
                    <div class="col-md-12 col-xs-12">
                        <header class="panel-heading custom-tab m-xs-t-0">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a href="#receipt" data-toggle="tab">Receipt</a>
                                </li>
                                <li class="">
                                    <a href="#exprop" data-toggle="tab">Extended Properties</a>
                                </li>  
                            </ul>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="receipt">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Receipt Number</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $data['receipt_details']->ReceiptNo }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Issue Date</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $data['receipt_details']->ReceiptDate }}</div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 p-xs-l-0 p-xs-r-0">
                                            <section>
                                                <table class="table table-resp table-bordered">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th>Payment Type</th>
                                                            <th>Service</th>
                                                            <th>Unit Price</th>
                                                            <th>Closed By</th>  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach( $data['salesOrderDetails'] as $salesOrderDetail)
                                                        <tr>
                                                            <td>{{ strtoupper($data['sales_details']->PaymentName) }}</td>
                                                            <td>{{ $salesOrderDetail->ProductName }}</td>
                                                            <td>RM{{ number_format((float) $salesOrderDetail->UnitPrice, 2, '.', '') }}</td>
                                                            <td>{{ strtoupper($data['sales_details']->CloseBy) }}</td> 
                                                        </tr> 
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="exprop">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Sales Advisor</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $data['sales_details']->SalesAdvisorName }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Technician</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $data['sales_details']->TechnicianName }}</div>
                                        </div> 
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div> 
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

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="updatesoLabel" role="dialog" tabindex="-1" id="updateso" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Update Sales Order</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ URL::route('update-sale') }}" method="post" id="update_sales_form" class="form-horizontal adminex-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="SalesOrderID" value="{{ $data['sales_details']->ID }}" />

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-xs-6 col-xs-5 col-sm-5 control-label">Sales Order No.</label>
                                    <div class="col-xs-6 col-sm-7">
                                        <label class="control-label">{{ $data['sales_details']->SalesNo }}</label>
                                    </div>
                                </div>

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-xs-6 col-xs-5 col-sm-5 control-label">Name</label>
                                    <div class="col-xs-6 col-sm-7">
                                        <label class="control-label">{{ $data['sales_details']->ClientName }}</label>
                                    </div>
                                </div>

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-xs-6 col-xs-5 col-sm-5 control-label">Phone Number</label>
                                    <div class="col-xs-6 col-sm-7">
                                        <label class="control-label">{{ $data['sales_details']->ContactNo }}</label>
                                    </div>
                                </div>

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-xs-6 col-xs-5 col-sm-5 control-label">Date</label>
                                    <div class="col-xs-6 col-sm-7">
                                        <label class="control-label">{{ $data['sales_details']->SalesDate }}</label>
                                    </div>
                                </div>


                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-xs-5 col-sm-5 control-label">Car Number</label>
                                    <div class="col-sm-7">
                                        <select class="form-control m-bot15" name='vehicleID'>
                                            @foreach($data['clientVehicles'] as $clientVehicle)
                                            <option value="{{ $clientVehicle->ID }}">{{ $clientVehicle->RegistrationNo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 


                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-xs-5 col-sm-5 control-label">Closed By</label>
                                    <div class="col-sm-7">
                                        <select class="form-control m-bot15" name="ClosedBy">
                                            @foreach($data['users_list'] as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>  

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-xs-5 col-sm-5 control-label">Sales Advisor</label>
                                    <div class="col-sm-7">
                                        <select class="form-control m-bot15" name="SalesAdvisorID">
                                            @foreach($data['sales_advisors'] as $sales_advisor)
                                            <option value="{{ $sales_advisor->id }}">{{ $sales_advisor->name }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>  

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-xs-5 col-sm-5 control-label">Technician</label>
                                    <div class="col-sm-7">
                                        <select class="form-control m-bot15" name="TechnicianID"> 
                                            @foreach($data['technicians'] as $technician)
                                            <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>  
                            </div>  

                        </div>

                        <hr>

                        <div class="row"> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <section>
                                    <table class="table table-resp table-bordered">
                                        <thead class="cf">
                                            <tr>
                                                <th>Service</th>
                                                <th class="numeric">Unit Price</th>
                                                <th>Quantity</th> 
                                                <th>Discount (%)</th>
                                                <th>Total Amount ($)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['salesOrderDetails'] as $salesOrderDetail)
                                        <input type="hidden" name="SalesOrderDetailID[]" value="{{ $salesOrderDetail->ID }}" />
                                        <tr>
                                            <td>
                                                <select class="form-control m-bot15" name="servicecategory[]">
                                                    @foreach($data['servicecategories'] as $servicecategory)
                                                    <option value="{{ $servicecategory->Code }}-{{ $servicecategory->Name }}" {{ ($salesOrderDetail->ProductCode==$servicecategory->Code ? 'selected' : '') }}>{{ $servicecategory->Code }} - {{ $servicecategory->Name }}</option>
                                                    @endforeach 
                                                </select>
                                            </td>
                                            <td>
                                                <div class="input-group m-bot15">
                                                    <span class="input-group-addon">RM</span>
                                                    <input type="text" class="form-control text-right" value="{{ number_format((float) $salesOrderDetail->UnitPrice, 2, '.', '') }}" name="service_price[]">
                                                    <span class="input-group-addon ">.00</span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Quantity" value="{{ number_format((float) $salesOrderDetail->Quantity, 0,'.', '') }}" name="service_quantity[]">
                                            </td>  
                                            <td>
                                                <input type="text" class="form-control" placeholder="Discount (%)" value="{{ number_format((float) $salesOrderDetail->Discount, 0, '.', '') }}" name="service_discount[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" class="Total Amount ($)" value="{{ number_format((float) $salesOrderDetail->Total, 2, '.', '') }}" name="service_total[]">
                                            </td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </section>
                            </div> 
                        </div>


                        <div class="row">
                            <div class="col-md-4 col-xs-12 pull-right">
                                <form class="form-horizontal adminex-form" method="get">
                                    <div class="form-group p-l-0 p-r-0">
                                        <label class="col-sm-5 col-sm-5 control-label">Net Total</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" value="{{ $data['sales_details']->NetTotal }}" name="NetTotal">
                                        </div>
                                    </div> 

                                    <div class="form-group p-l-0 p-r-0">
                                        <label class="col-sm-5 col-sm-5 control-label">GST (6%)</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" value="{{ number_format((float) $data['sales_details']->GST, 2, '.', '') }}" name="GST">
                                        </div>
                                    </div> 
                                    <div class="form-group p-l-0 p-r-0">
                                        <label class="col-sm-5 col-sm-5 control-label">Total</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="GrossTotal" value="{{ number_format((float) $data['sales_details']->GrossTotal, 2, '.', '') }}">
                                        </div>
                                    </div>

                                    <div class="form-group p-l-0 p-r-0">
                                        <label class="col-sm-5 col-sm-5 control-label">Paid</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" value="{{ $data['sales_details']->Paid }}" name="Paid">
                                        </div>
                                    </div> 

                                    <div class="form-group p-l-0 p-r-0">
                                        <label class="col-sm-5 col-sm-5 control-label">Due</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" value="{{ $data['sales_details']->Due }}" name="Due">
                                        </div>
                                    </div> 

                            </div> 
                        </div>


                        <div class="form-group"> 
                            <div class="col-sm-4 col-sm-offset-4 text-center">
                                <button type="submit" class="btn btn-red-primex btn-block" >Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
<!-- modal -->

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">

    $(document).ready(function () {


    });


</script>
@endsection

