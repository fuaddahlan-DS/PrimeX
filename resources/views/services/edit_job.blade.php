@extends('layouts.app')

@section('content')
<style type="text/css">
    a.disabled {
   pointer-events: none;
   cursor: default;
}
</style>
<!-- page heading start-->
<div class="page-heading">
    <h3>
        Service Queue
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="#">Service Queue</a>
        </li>
        <li class="active"> Edit Job </li>
    </ul>

</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">

        <div class="panel padding-2">
            <div class="panel-default">  
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                        <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Car Number</label></div>
                        <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Vehicle->RegistrationNo }}</div>
                    </div>

                    <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                        <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Member ID</label></div>
                        <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $MemberID }}</div>
                    </div>

                    <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                        <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Member Name</label></div>
                        <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Client->Name }}</div>
                    </div>

                    <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                        <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Credit Balance</label></div>
                        <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">RM <span class="ownerbalance">{{ $MemberBalance }}</span></div>
                    </div>
                </div>

                <div class="row">
                    &nbsp;
                </div>

                 <div class="row">
                    <div class="col-md-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                        <div class="col-md-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                            <label>Remarks</label>
                        </div>
                        <div class="col-md-6 col-xs-12 p-xs-l-0 p-xs-r-0">
                            <input type="text" class="form-control" name="remarks" id="remarks" value="{{ $jobs->Remarks }}" />
                        </div>
                        
                    </div>
                 </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                        <header class="panel-heading custom-tab ">
                            <ul class="nav nav-tabs nav-justified">
                                <li id="pg1" class="active">
                                    <a href="#vd" data-toggle="tab">Vehicle Details</a>
                                </li>
                                <li id="pg2" class="">
                                    <a href="#od" data-toggle="tab">Owner Details</a>
                                </li>
                                <li id="pg3" class="">
                                    <a href="#dd" data-toggle="tab">Driver Details</a>
                                </li>
                                <li id="pg4" class="">
                                    <a href="#sd" data-toggle="tab" >Service Details</a>
                                </li> 
                                <li id="pg5" class="">
                                    <a href="#bi" data-toggle="tab">Billing Info</a>
                                </li>
                                <li id="pg6" class="">
                                    <a href="#rfl" data-toggle="tab">Referrals</a>
                                </li>
                            </ul>
                        </header>
                        
                       
                        <div class="panel-body-tabs">
                            <form action="{{ URL::route('update_edit_job') }}" method="post" id="update_edit_job_form" class="form-horizontal adminex-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="CategoryService" value="{{ $CategoryService }}" />
                            <input type="hidden" name="VehicleID" value="{{ $Vehicle->ID }}" />
                            <input type="hidden" name="RegistrationNo" value="{{ $Vehicle->RegistrationNo }}" />
                            <input type="hidden" name="MemberCode" value="{{ $MemberID }}" />
                            <input type="hidden" name="ClientID" value="{{ $Client->ID }}" />

                            <input id="hidRemarks" type="hidden" name="remarks" value="" />
                            <input id="hidProductCode" type="hidden" name="productCode" value="" />
                        
                            <div class="tab-content">
                                <div class="tab-pane active" id="vd">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Number</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Vehicle->RegistrationNo }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Number</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Vehicle->RegistrationNo }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Manufacturer</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Vehicle->manufacturerName }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Color</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $VehicleColor }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Type</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Vehicle->VehicleTypeName }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group"> 
                                                <div class="col-md-4 col-md-offset-4 text-center">
                                                    <a type="button" class="btn btn-success btn-block" data-toggle="tab" href="#od" onclick="gotopage(2)"><i class="fa fa-play"></i> Start New Job</a>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="od">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Member ID</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $MemberID }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Member Name</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Client->Name }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Phone Number</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Client->ContactNo }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Email</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Client->Email }}</div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Credit Balance</label></div>
                                            <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">RM <span class="ownerbalance">{{ $MemberBalance }}</span></div>
                                        </div>

                                        <div class="col-md-12 col-xs-12 col-sm-12"> 
                                            <div class="col-md-3 col-xs-12 col-sm-3 m-t-1 m-bot15"> 
                                                <a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#owner_topup" onclick="updateTopUpOwner()"><i class="fa fa-plus m-r-1"></i> Top Up </a> 
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group"> 
                                                <div class="col-md-4 col-md-offset-4 text-center">
                                                    <a type="button" class="btn btn-success btn-block" data-toggle="tab" href="#dd" onclick="gotopage(3)"><i class="fa fa-play"></i> Start New Job</a>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="tab-pane" id="dd">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Member Name</label></div>
                                            <div class="col-md-4 col-xs-6 col-sm-4 p-l-0">
                                                <div class="input-group m-bot15 m-xs-t-0">
                                                    <input type="text" class="form-control" value="" placeholder="Type member name here.." id="driverName" onkeypress="return srcDriver(event);">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" id="searchDriver"><i class="fa fa-search"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="result_driver">
                                        
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group"> 
                                                <div class="col-md-4 col-md-offset-4 text-center">
                                                    <a type="button" class="btn btn-success btn-block" data-toggle="tab" href="#sd" onclick="gotopage(4)"><i class="fa fa-play"></i> Start New Job</a>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="sd">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <section>
                                                <table class="table table-resp table-bordered">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th>&#32;</th>
                                                            <th>Service Code</th>
                                                            <th>Service Name</th>
                                                            
                                                            <th>Price</th>  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($Services as $service)
                                                        <tr>
                                                            <td height="5">
                                                                <input type="checkbox" class="productCheck" value="{{ $service->ID }}" id="product[]"> 
                                                            </td>
                                                            <td>{{ $service->Code }}</td>
                                                            <td>{{ $service->Name }}</td>
                                                            
                                                            <td>{{ number_format((float) $service->NormalPrice, 2, '.', '') }}</td> 
                                                        </tr>
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group"> 
                                                <div class="col-md-4 col-md-offset-4 text-center">
                                                    <a type="button" class="btn btn-success btn-block" data-toggle="tab" href="#bi" onclick="gotopage(5)"><i class="fa fa-play"></i> Start New Job</a>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="bi">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <section>
                                                <table class="table table-resp">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th>Member ID</th>
                                                            <th>Member Name</th>
                                                            <th>Opening Balance</th>
                                                            <th>Closing Balance</th>
                                                            <th>&#32;</th>  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr> 
                                                            <td id="biMemberId">{{ $MemberID }}</td>
                                                            <td id="biMemberName">{{ $Client->Name }}</td>
                                                            <td>RM <span id="ob22">{{ $MemberBalance }}</span></td>
                                                            <td>RM <span id="ob2" class="ownerbalance2">{{ $MemberBalance }}</span></td>
                                                            <td><a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#owner_topup" onclick="updateTopUpBillInfo();"><i class="fa fa-plus m-r-1"></i> Top Up </a> </td>
                                                        </tr> 
                                                    </tbody>
                                                </table>
                                            </section>
                                        </div>
                                    </div>

                                    <div class="row  m-t-1">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <h4>Invoice Information</h4> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div  class="col-xs-12 col-sm-12 col-md-12">
                                            <label class="col-xs-12 col-sm-12 col-md-12 text-right">Date: {{ date('d/m/Y', strtotime($jobs->StartDate)) }}</label>  
                                        </div>
                                         <div  class="col-xs-12 col-sm-12 col-md-12">
                                            <label class="col-xs-12 col-sm-12 col-md-12 text-right">Invoice Number: INV-BB{{ $jobs->ID }}</label>  
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <section>
                                                <table class="table table-resp">
                                                    <thead class="cf">
                                                    <tr>
                                                        <th>No. </th>
                                                        <th>Service Name</th>
                                                        <th>Unit Price</th>
                                                        <th>Quantity</th>
                                                        <th>Discount</th>  
                                                        <th>Total</th>  
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr> 
                                                            <td>1</td>
                                                            <td>{{ $salesorderdetails->ProductName }}</td>
                                                            <td>RM  {{ number_format($salesorder->GrossTotal - $salesorder->GST, 2, '.', ',') }}</td>
                                                            <td>1</td>
                                                            <td>RM {{ number_format($salesorderdetails->Discount, 2, '.', ',') }}</td>
                                                            <td>RM {{ number_format($salesorder->GrossTotal - $salesorder->GST, 2, '.', ',') }}  </td>
                                                        </tr> 
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
                                                        <input id="net-total" name="net-total" value="{{ number_format($salesorder->GrossTotal - $salesorder->GST, 2, '.', ',') }}" type="text" class="form-control">
                                                    </div>
                                                </div> 

                                                <div class="form-group p-l-0 p-r-0">
                                                    <label class="col-sm-5 col-sm-5 control-label">GST (6%)</label>
                                                    <div class="col-sm-7">
                                                        <input id="gst" name="gst" value="{{ number_format($salesorder->GST, 2, '.', '.') }}" type="text" class="form-control">
                                                    </div>
                                                </div> 

                                                <div class="form-group p-l-0 p-r-0">
                                                    <label class="col-sm-5 col-sm-5 control-label">Paid</label>
                                                    <div class="col-sm-7">
                                                        <input id="paid" name="paid" value="{{ number_format($salesorder->GrossTotal, 2, '.', ',') }}" type="text" class="form-control">
                                                    </div>
                                                </div> 

                                                <div class="form-group p-l-0 p-r-0">
                                                    <label class="col-sm-5 col-sm-5 control-label">Due</label>
                                                    <div class="col-sm-7">
                                                        <input id="due" name="due" value="0.00" type="text" class="form-control">
                                                    </div>
                                                </div> 
                                            </form>
                                        </div> 
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group"> 
                                                <div class="col-md-4 col-md-offset-4 text-center">
                                                    <a type="button" class="btn btn-success btn-block" data-toggle="tab" href="#rfl" onclick="gotopage(6)" id="buttonbill"><i class="fa fa-play"></i> Start New Job</a>
                                                    <br />
                                                    
                                                        <a type="button" class="btn btn-success btn-block" data-toggle="modal" href="#payment-type"><i class="fa fa-usd"></i> </a>

                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="rfl">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12 ">  
                                            <div class="form-group p-l-1 p-r-1 p-b-0">
                                                <label for="exampleInputEmail1">Sales Advisor</label>
                                                <select class="form-control m-bot15" name="salesAdvisor_id">
                                                   @foreach($SalesAdvisors as $SalesAdvisor)
                                                    <option value="{{ $SalesAdvisor->id }}">{{ $SalesAdvisor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1 p-b-0">
                                                <label for="exampleInputEmail1">Techinician</label>
                                                
                                                <select class="form-control m-bot15" name="technician_id">
                                                    @foreach($Technicians as $Technician)
                                                    <option value="{{ $Technician->id }}">{{ $Technician->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>  

                                        <div class="col-md-6 col-sm-6 col-xs-12 ">  
                                            <div class="form-group p-l-1 p-r-1 p-b-0">
                                                <label for="exampleInputEmail1">Dealer Company</label>
                                                <select class="form-control m-bot15" name="dealer_id">
                                                   @foreach($DealerCompanies as $DealerCompany)
                                                    <option value="{{ $DealerCompany->ID }}">{{ $DealerCompany->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group p-l-1 p-r-1 p-b-0">
                                                <label for="exampleInputEmail1">Dealer Sales Person</label>
                                                <select class="form-control m-bot15" name="dealer_user_id">
                                                    @foreach($DealerUsers as $DealerUser)
                                                    <option value="{{ $DealerUser->id }}">{{ $DealerUser->name }} - {{ $DealerUser->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div> 
                                        </div>  
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group"> 
                                                <div class="col-md-4 col-md-offset-4 text-center">
                                                    <button type="submit" class="btn btn-success btn-block" id="SaveNewJob"><i class="fa fa-play"></i> Start New Job</button>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                              </form>
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
<div aria-hidden="true" aria-labelledby="topupLabel" role="dialog" tabindex="-1" id="owner_topup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Top Up</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal adminex-form" method="get"> 
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Member ID</label>
                                    <div class="col-sm-7">
                                        <label id="lMemberId" class="control-label">{{ $MemberID }}</label>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Name</label>
                                    <div class="col-sm-7">
                                        <label id="lMemberName" class="control-label">{{ $Client->Name }}</label>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Current Balance</label>
                                    <div class="col-sm-7">
                                        <label class="control-label">RM <span class="ownerbalance3">{{ $MemberBalance }}</span></label>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Top Up Amount</label>
                                    <div class="col-sm-7">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon">RM</span>
                                            <input type="text" class="form-control text-right" value="100" id="amount">
                                            <span class="input-group-addon ">.00</span>
                                        </div>
                                    </div>
                                </div> 

                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Payment Type</label>
                                    <div class="col-sm-7">
                                        <select class="form-control m-bot15" id="PaymentTypeID">
                                            @foreach($payment_types as $pt)

                                            <option value="{{ $pt->id }}">{{ $pt->name }}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>   
                            </div>  

                            <div class="form-group"> 
                                <div class="col-sm-4 col-sm-offset-4 text-center">
                                    <input type="hidden" id="memberCode" value="{{ $MemberID }}">
                                    <input type="hidden" id="ClientID" value="{{ $Client->ID }}">
                                    <button type="button" class="btn btn-red-primex btn-block" id="do_owner_topup" data-dismiss="modal">Save</button>
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
<div aria-hidden="true" aria-labelledby="topupLabel" role="dialog" tabindex="-1" id="driver_topup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Top Up</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal adminex-form" method="get"> 
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Member ID</label>
                                    <div class="col-sm-7">
                                        <label class="control-label"><span id="driver_member_id"></span></label>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Name</label>
                                    <div class="col-sm-7">
                                        <label class="control-label"><span id="driver_client_name"></span></label>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Current Balance</label>
                                    <div class="col-sm-7">
                                        <label class="control-label">RM <span id="driver_member_balance"></span></label>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Top Up Amount</label>
                                    <div class="col-sm-7">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon">RM</span>
                                            <input type="text" class="form-control text-right" value="100" id="amount">
                                            <span class="input-group-addon ">.00</span>
                                        </div>
                                    </div>
                                </div> 

                                <div class="form-group ">
                                    <label class="col-sm-5 col-sm-5 control-label">Payment Type</label>
                                    <div class="col-sm-7">
                                        <select class="form-control m-bot15" id="PaymentTypeID">
                                            <option value="1">Cash</option>
                                            <option value="2">Credit Card</option>
                                            <option value="3">Cheque</option>
                                            <option value="5">Online Transfer</option>
                                        </select>
                                    </div>
                                </div>   
                            </div>  

                            <div class="form-group"> 
                                <div class="col-sm-4 col-sm-offset-4 text-center">
                                    <input type="hidden" id="driver_member_id_val" value="">
                                    <input type="hidden" id="driver_client_id_val" value="">
                                    <button type="button" class="btn btn-red-primex btn-block" id="do_driver_topup" data-dismiss="modal">Save</button>
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
<div aria-hidden="true" aria-labelledby="payment-type-label" role="dialog" tabindex="-1" id="payment-type" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Payment Type</h4>
            </div>
            <div class="modal-body">
                <form action="{{ URL::route('completejob') }}" method="post" id="complete_wash_form" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" value="{{ $jobid }}" name="jobID">
                    <div class="col-sm-4 col-sm-offset-4 text-center">
                        <select class="form-control">
                            <option selected="selected">Membership Credit</option>
                            <option>Cash</option>
                            <option>Credit Card</option>
                            <option>Cheque</option>
                            <option>Online Transfer</option>
                        </select>
                    </div>
                    <br />
                    <br />
                    <div class="col-sm-4 col-sm-offset-4 text-center">
                        <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-check"></i></button>
                    </div>    
                </form>
            </div> 
        </div>
    </div>
</div>
<!-- modal -->


<meta name="csrf-token" content="{{ csrf_token() }}" />

<script type="text/javascript">
    var arr = new Array();
    $(document).ready(function () {
        
        var CTOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'GET',
            url: '{{ route("getDriver") }}',
            data: {
                _token: CTOKEN,
                jobId : '{{ $jobid }}',
            },
            dataType: 'html',
            success: function (result) {
                //Success!
                $('#result_driver').html(result);
               
            },
            error: function (xhr, status) {
                //window.location.reload();
            },
            complete: function (xhr, status) {
                //$('#loader').addClass('hide');

            }
        });

        var ob2 = parseFloat($('#ob2').html());
        var deduct = parseFloat($('#paid').val());

        $('#ob2').html(ob2 - deduct);

        $('#net-total').keypress(function() {
            var invoice_NetTotal = $('#net-total').val();
            var gst = (6/100) * invoice_NetTotal;

            $('#gst').val(gst.toFixed(2));
            
            var gross = parseFloat(gst.toFixed(2)) + parseFloat(invoice_NetTotal);

            $('#paid').val(gross.toFixed(2));
        });
       
        $('#searchDriver').click(function () {
            $('#result_driver').html('&nbsp;&nbsp;Searching..');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '{{ route("searchClientName") }}',
                data: {
                    _token: CSRF_TOKEN,
                    Name: $("#driverName").val(),
                   
                },
                dataType: 'html',
                success: function (result) {
                    //Success!
                    $('#result_driver').html(result);
                   
                },
                error: function (xhr, status) {
                    //window.location.reload();
                },
                complete: function (xhr, status) {
                    //$('#loader').addClass('hide');

                }
            });
        });
         
        $('#do_owner_topup').click(function () {
            $('.ownerbalance').show('Loading..');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: '{{ route("membertopup") }}',
                data: {
                    _token: CSRF_TOKEN,
                    memberCode: $("#memberCode").val(),
                    amount: $("#amount").val(),
                    PaymentTypeID: $("#PaymentTypeID").val(),
                    ClientID: $("#ClientID").val(),
                },
                dataType: 'json',
                success: function (result) {
                    //Success!
                    var driverId = $("input[name='driver_id']").val();

                    if (driverId == undefined) {
                        $('.ownerbalance').text(result.data.amount);
                    }
                    else {
                        $('#driverbalance').html(result.data.amount);
                    }

                    $('#ob22').text(result.data.amount);

                    var total = parseFloat(result.data.amount);
                    var deduction = parseFloat($("#paid").val());
                    var gross = parseFloat(total - deduction);

                    var paymentType = $('#invoice_payment_type').val();

                    if (paymentType == 5) {
                        $('#ob2').text(gross.toFixed(2));    
                    }
                    
                    toastr.success(result.message);
                },
                error: function (xhr, status) {
                    //window.location.reload();
                },
                complete: function (xhr, status) {
                    //$('#loader').addClass('hide');

                }
            });
        });
        
         $('#do_driver_topup').click(function () {
            $('#driverbalance').show('Loading..');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: '{{ route("membertopup") }}',
                data: {
                    _token: CSRF_TOKEN,
                    memberCode: $("#memberCode").val(),
                    amount: $("#amount").val(),
                    PaymentTypeID: $("#PaymentTypeID").val(),
                    ClientID: $("#ClientID").val(),
                },
                dataType: 'json',
                success: function (result) {
                    //Success!
                    $('#driverbalance').text(result.data.amount);

                    $('.ownerbalance').text(result.data.amount);
                    $('#ob22').text(result.data.amount);

                    var total = parseFloat(result.data.amount);
                    var deduction = parseFloat($("#paid").val());

                    $('#ob2').text(total - deduction);
                    
                    toastr.success(result.message);
                },
                error: function (xhr, status) {
                    //window.location.reload();
                },
                complete: function (xhr, status) {
                    //$('#loader').addClass('hide');

                }
            });
        });
        
        $('.productCheck').change(function (event) {
            
            var checkbox = event.target;
            var productID = event.target.value;
                if (checkbox.checked) {
                arr.push(productID);
            } else {
                arr = arr.filter(function(item) { 
                    return item !== productID
                })
            }
            console.log(arr);
              
        });      
    });

    function gotopage(pg){
            $('li[id^="pg"]').removeClass("active");
            $('#pg'+pg).addClass("active");
            $('#buttonbill').addClass('hide');
            
        
            if(pg==5){
                var driverId = $("input[name='driver_id']").val();

                $('#pg5 a').attr('class', '');

                if (driverId != undefined) {

                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("updateBillingInfo") }}',
                        data: {
                            _token: CSRF_TOKEN,
                            clientId: driverId,
                           
                        },
                        dataType: 'json',
                        success: function (data) {
                            //Success!
                            var memberBalance = data.MemberBalance;
                            memberBalance = parseFloat(memberBalance);

                            $('#biMemberId').html(data.MemberCode);
                            $('#biMemberName').html(data.MemberName);
                            $('#ob22').html(memberBalance.toFixed(2));
                            $('.ownerbalance3').html(memberBalance.toFixed(2));
                            $('#lMemberId').html(data.MemberCode);
                            $('#lMemberName').html(data.MemberName);
                            $('#memberCode').val(data.MemberCode);
                            $('#ClientID').val(data.ClientId);

                            var ob22 = parseFloat($('#ob22').html());
                            var deduct = parseFloat($("input[name='invoice_GrossTotal']").val());

                            var total = ob22 - deduct;

                            $('#ob2').html(total.toFixed(2));                            
                        },
                        error: function (xhr, status) {
                            //window.location.reload();
                        },
                        complete: function (xhr, status) {
                            //$('#loader').addClass('hide');

                        }
                    });
                }                
                
                billPage();
            }    
        }

    function billPage (){
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '{{ route("getProductDetails") }}',
                data: {
                    _token: CSRF_TOKEN,
                    productArr: arr,
                   
                },
                dataType: 'html',
                success: function (data) {
                    //Success!
                    $('#billpage').html(data);
                    $('#buttonbill').removeClass('hide');

                    var ob22 = parseFloat($('#ob22').html());
                    var deduct = parseFloat($("input[name='invoice_GrossTotal']").val());
                    var total = ob22 - deduct;

                    $('#ob2').html(total.toFixed(2));
                   
                },
                error: function (xhr, status) {
                    //window.location.reload();
                },
                complete: function (xhr, status) {
                    //$('#loader').addClass('hide');

                }
            });
    }   

    function srcDriver(e) {
        var keyCode = e.keyCode;

        if (keyCode == 13) {
            e.preventDefault();
            $('#searchDriver').click();
        }        
    }

    function updateTopUpOwner() {
        var balance = $('.ownerbalance').html();
        balance = parseFloat(balance);

        $('.ownerbalance3').html(balance.toFixed(2));

        var memberId = $('#odMemberCode').html();
        $('#lMemberId').html(memberId);

        var memberName = $('#odMemberName').html();
        $('#lMemberName').html(memberName);
    }

    function updateTopUpBillInfo() {
        var driverId = $("input[name='driver_id']").val();

        if (driverId == undefined) {
            //alert('a');
            var balance = $('.ownerbalance').html();
            balance = parseFloat(balance);

            $('.ownerbalance3').html(balance.toFixed(2));

            var memberId = $('#odMemberCode').html();
            $('#lMemberId').html(memberId);

            var memberName = $('#odMemberName').html();
            $('#lMemberName').html(memberName);
        }
        else {
            //alert('b');
            var driverBalance = $('#driverbalance').html();
            driverBalance = parseFloat(driverBalance);

            $('.ownerbalance3').html(driverBalance.toFixed(2));

            var memberId = $('#biMemberId').html();
            $('#lMemberId').html(memberId);

            var memberName = $('#biMemberName').html();
            $('#lMemberName').html(memberName);       
        }     
    }   
       
</script>
@endsection

