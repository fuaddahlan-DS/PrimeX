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
        <li class="active"> Add New Job </li>
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
                        <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Car Model</label></div>
                        <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Vehicle->Model }}</div>
                    </div>

                    <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                        <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Customer Name</label></div>
                        <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Client->Name }}</div>
                    </div>
                    
                    <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                        <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Customer Email</label></div>
                        <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Client->Email }}</div>
                    </div>
                    
                    <div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
                        <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Phone Number</label></div>
                        <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $Client->ContactNo }}</div>
                    </div>

                   
                </div>

                <!--<div class="row">
                    &nbsp;
                </div>

                 <div class="row">
                    <div class="col-md-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                        <div class="col-md-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                            <label>Product Code/Name</label>
                        </div>
                        <div class="col-md-6 col-xs-12 p-xs-l-0 p-xs-r-0">
                            {{ $ProductsCode }} / {{ $ProductsName }}
                        </div>
                        
                    </div>
                 </div>-->

                <div class="row">
                    &nbsp;
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                        <div class="col-md-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                            <label>Remarks</label>
                        </div>
                        <div class="col-md-6 col-xs-12 p-xs-l-0 p-xs-r-0">
                            <textarea id="remarks" class="form-control"></textarea>
                        </div>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 p-xs-l-0 p-xs-r-0">
                        <header class="panel-heading custom-tab ">
                            <ul class="nav nav-tabs nav-justified">
                                
                                <li id="pg4" class="active">
                                    <a href="#sd" data-toggle="tab" >Service Details</a>
                                </li> 
                                <li id="pg5" class="">
                                    <a href="#bi" data-toggle="tab" class="disabled">Billing Info</a>
                                </li>
                                <li id="pg6" class="">
                                    <a href="#rfl" data-toggle="tab" class="disabled">Referrals</a>
                                </li>
                            </ul>
                        </header>

                        <div class="panel-body-tabs">
                            <form action="{{ URL::route('add_new_job_by_cash') }}" method="post" id="add_new_job_form" class="form-horizontal adminex-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="CategoryService" value="{{ $CategoryService }}" />
                            <input type="hidden" name="VehicleID" value="{{ $Vehicle->ID }}" />
                            <input type="hidden" name="RegistrationNo" value="{{ $Vehicle->RegistrationNo }}" />
                            <input type="hidden" name="ClientID" value="{{ $Client->ID }}" />
                            <input id="hidRemarks" type="hidden" name="remarks" value="" />
                            <input id="hidProductCode" type="hidden" name="productCode" value="" />
                        
                            <div class="tab-content">
                                

                                <div class="tab-pane active" id="sd">
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
                                    

                                    <div class="row  m-t-1">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <h4>Invoice Information</h4> 
                                        </div>
                                    </div> 
                                    <div id="billpage">
                                   
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group"> 
                                                <div class="col-md-4 col-md-offset-4 text-center">
                                                    <a type="button" class="btn btn-success btn-block" data-toggle="tab" href="#rfl" onclick="gotopage(6)" id="buttonbill"><i class="fa fa-play"></i> Start New Job</a>
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






<meta name="csrf-token" content="{{ csrf_token() }}" />

<script type="text/javascript">
    
    var arr = new Array();
    $(document).ready(function () {
        
        $('#remarks').keyup(function() {
            var remarks = $(this).val();
            $('#hidRemarks').val(remarks);
        });

        $('#productCode').keyup(function() {
            var productCode = $(this).val();
            $('#hidProductCode').val(productCode);
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
                    $('.ownerbalance').text(result.data.amount);
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
                billPage();
            }
        
        
               
        }
    function billPage (){
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '{{ route("getProductDetailsByCash") }}',
                data: {
                    _token: CSRF_TOKEN,
                    productArr: arr,
                   
                },
                dataType: 'html',
                success: function (data) {
                    //Success!
                    //console.log(data);
                    $('#billpage').html(data);
                    $('#buttonbill').removeClass('hide');
                   
                },
                error: function (xhr, status) {
                    //window.location.reload();
                },
                complete: function (xhr, status) {
                    //$('#loader').addClass('hide');

                }
            });
    }   
       
</script>
@endsection

