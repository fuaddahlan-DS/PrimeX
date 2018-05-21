@extends('layouts.app')

@section('content')


         <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Member Name
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="/">Dashboard</a>
                </li>
                <li>
                    <a href="/member">Members</a>
                </li>
                <li class="active"> Member Name </li>
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
                                        <div class="title">Member ID</div>
                                        <div class="desk">{{ $members->Code }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Name</div>
                                        <div class="desk">{{ $members->Name}}</div>
                                    </li>
                                    <li>
                                        <div class="title">Phone Number</div>
                                        <div class="desk">{{ $members->ContactNo }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Email</div>
                                        <div class="desk">{{ $members->Email }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Current Balance</div>
                                        <div class="desk">RM <?php App::make("App\Http\Controllers\MemberController")->getMemberBalance($members->ID); ?></div>
                                    </li> 
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3"> 
                                <div class="row"> 
                                    <div class="col-md-12 col-xs-12 col-sm-12  m-bot15"> 
                                        <a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#topup" onclick="topup({{$members->ID}})"><i class="fa fa-plus m-r-1"></i> Top Up </a> 
                                    </div> 
                                    <div class="col-md-12 col-xs-12 col-sm-12  m-bot15"> 
                                        <a type="button" class="btn btn-blue pull-right btn-block" data-toggle="modal" href="#updatemember" onclick="getMemberDetails({{$members->ID}})"><i class="fa fa-pencil m-r-1"></i> Update Details</a> 
                                    </div> 
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
                                            <a href="#vehicles" data-toggle="tab">Vehicles</a>
                                        </li>
                                        <li class="">
                                            <a href="#service-hist" data-toggle="tab">Service History</a>
                                        </li>
                                        <li class="">
                                            <a href="#topup-hist" data-toggle="tab">Top Up History</a>
                                        </li> 
                                    </ul>
                                </header>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="vehicles">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 p-xs-l-0 p-xs-r-0">
                                                    <section>
                                                        <table class="table table-resp table-bordered">
                                                            <thead class="cf">
                                                            <tr>
                                                                <th>Vehicle Number</th>
                                                                <th>Vehicle Model</th>
                                                                <th>Vehicle Manufacturer</th>
                                                                <th>Vehicle Type</th>
                                                                <th>Color</th>  
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($vehicles as $vehicle)
                                                                <tr>
                                                                    <td>{{ $vehicle->RegistrationNo }}</td>
                                                                    <td>{{ $vehicle->Model }}</td>
                                                                    <td>{{ $vehicle->manufacturerName }}</td>
                                                                    <td>{{ $vehicle->Name }}</td>
                                                                    <td>{{ $vehicle->colorName }}</td> 
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="service-hist">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 p-xs-l-0 p-xs-r-0">
                                                    <section>
                                                        <table class="table table-resp table-bordered">
                                                            <thead class="cf">
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Date</th>
                                                                <th>Car Number</th>
                                                                <th>Credit Used (RM)</th>
                                                                <th>Balance (RM)</th>  
                                                                <th>Remarks</th>
                                                                <th>Branch</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($servicehistories as $servicehistory)
                                                                <tr>
                                                                    <td>{{ $servicehistory->RowNum }}</td>
                                                                    <td>{{ date('d/m/Y', strtotime($servicehistory->SalesDate)) }}</td>
                                                                    <td>{{ $servicehistory->RegistrationNo }}</td>
                                                                    <td>{{ ($servicehistory->PaymentTypeID != 5) ? '0.00' : number_format($servicehistory->CreditUsed, 2) }}</td> 
                                                                    <td>{{ number_format($servicehistory->RunningBalance - $servicehistory->CreditUsed, 2) }}</td>
                                                                    <td>{{ ($servicehistory->PaymentTypeID == 1) ? 'BY CASH' : (($servicehistory->PaymentTypeID == 2) ? 'BY CREDIT CARD' : (($servicehistory->PaymentTypeID == 3) ? 'BY CHEQUE' : (($servicehistory->PaymentTypeID == 4) ? 'BY TRANSFER ONLINE' : 'BY MEMBERSHIP CREDIT'))) }}</td>
                                                                    <td>{{ $servicehistory->Code }}</td> 
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="topup-hist">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 p-xs-l-0 p-xs-r-0">
                                                    <section>
                                                        <table class="table table-resp table-bordered">
                                                            <thead class="cf">
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Date</th> 
                                                                <th>Previous Credit (RM)</th>
                                                                <th>Top Up Amount (RM)</th>
                                                                <th>New Balance (RM)</th>  
                                                                <!--<th>Remarks</th>-->
                                                                <th>Branch</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($topuphistories as $topuphistory)
                                                                <tr>
                                                                    <td>{{ $topuphistory->RowNum }}</td>
                                                                    <td>{{ date('d/m/Y', strtotime($topuphistory->SalesDate)) }}</td> 
                                                                    <td>{{ number_format($topuphistory->RunningBalance - $topuphistory->GrossTotal, 2) }}</td> 
                                                                    <td>{{ number_format($topuphistory->GrossTotal, 2) }}</td>
                                                                    <td>{{ number_format($topuphistory->RunningBalance, 2) }}</td>
                                                                    <!--<td>{{ $totalAmount }}</td>-->
                                                                    <td>{{ $topuphistory->Code }}</td> 
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
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!--body wrapper end-->


        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="topupLabel" role="dialog" tabindex="-1" id="topup" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" id="closeTopUp" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href">&times;</button>
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
                                                    <input id="topup-amount" type="text" class="form-control text-right" value="">
                                                    <span class="input-group-addon ">.00</span>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="form-group ">
                                            <label class="col-xs-5 col-sm-5 control-label">Payment Type</label>
                                            <div class="col-sm-7">
                                                <select class="form-control m-bot15">
                                                @foreach ($paymentTypes as $paymentType)
                                                    @if ($paymentType->id != 5)
                                                    <option value="{{ $paymentType->id }}">{{$paymentType->name}}</option>
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
        <div aria-hidden="true" aria-labelledby="updatememberLabel" role="dialog" tabindex="-1" id="updatemember" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Update Member Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="updateMemberID">
                           <form class="form-horizontal adminex-form" method="get">

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="update-error" class="form-group p-l-1 p-r-1 hide">
                                        <div id="update-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                    </div>
                                    <div id="update-success" class="form-group p-l-1 p-r-1 hide">
                                        <div id="update-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                    </div>
                                    <div id="memberCodeDiv" class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-6 col-xs-5 col-sm-5 control-label">Member ID</label>
                                        <div class="col-xs-6 col-sm-7">
                                            <label id="updateMemberCode" class="control-label"></label>
                                        </div>
                                    </div>

                                    <div class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-5 col-sm-5 control-label">Name</label>
                                        <div class="col-sm-7">
                                            <input type="text" id="update-name" class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div> 

                                    <div class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-5 col-sm-5 control-label">Email</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="update-email" type="email" placeholder="Enter Email">
                                        </div>
                                    </div> 

                                    <div class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-5 col-sm-5 control-label">Phone Number</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="update-number" placeholder="Enter Phone Number">
                                        </div>
                                    </div> 

                                    <div class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-5 col-sm-5 control-label"></label>
                                        <div class="col-sm-7 text-right">
                                            <button id="updatemember-submit" type="button" class="btn btn-blue">Update Member</button>
                                        </div>
                                    </div> 
                                    <div class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-5 col-sm-5 control-label"></label>
                                        <div class="col-sm-7 text-right">
                                            <button id="add-new-car-button" type="button" onclick="clearUpdateCar()" class="btn btn-primary">Clear Vehicle Fields</button>
                                        </div>
                                    </div> 

                                    <div id="updatecar-list" class="col-sm-12 col-xs-12 text-center p-xs-l-0 p-xs-r-0"> 
                                    </div> 

                                    <div id="updatenewcar-list" class="col-sm-12 col-xs-12 text-center"> 
                                    </div>  

                               
                                </div> 

                            <div id="update-car" class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" id="updateCarID">
                                <div class="p-xs-l-1 p-xs-r-1">
                                    <div id="updatecar-error" class="form-group p-l-1 p-r-1 hide">
                                        <div id="updatecar-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                    </div>

                                    <div id="updatecar-success" class="form-group p-l-1 p-r-1 hide">
                                        <div id="updatecar-success-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center success"></div>
                                    </div>

                                    <div class="form-group p-l-1 p-r-1">
                                        <label for="exampleInputEmail1">Vehicle Number</label>
                                        <input id="update-carNumber" class="form-control" placeholder="Enter Number Plate">
                                    </div>

                                    <div class="form-group p-l-1 p-r-1">
                                        <label for="exampleInputEmail1">Vehicle Model</label>
                                        <input id="update-carModel" class="form-control" placeholder="Enter Number Plate">
                                    </div>
                                    
                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label for="exampleInputEmail1">Vehicle Manufacturer</label>
                                        <select id="update-carManufacturer" class="form-control m-bot15">
                                        @foreach ($manufacturers as $manufacturer)
                                            <option id="updateCarManu{{$manufacturer->ID}}" class="updateCarManu" value="{{$manufacturer->ID}}">{{$manufacturer->Name}}</option>
                                        @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label>Vehicle Type</label>
                                        <select id="update-carType" class="form-control m-bot15">
                                            @foreach ($vehicletypes as $vehicletype)
                                                <option id="updateCarType{{$vehicletype->ID}}" class="updateCarType" value="{{$vehicletype->ID}}">{{$vehicletype->Name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label for="exampleInputEmail1">Vehicle Color</label>
                                        <select id="update-carColor" class="form-control m-bot15">
                                            @foreach ($colors as $color)
                                                <option id="updateCarColor{{$color->ID}}" class="updateCarColor" value="{{$color->ID}}">{{$color->Name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                     <div class="form-group"> 
                                        <div class="col-sm-12 text-center">
                                            <button id="updatecar-submit" type="button" class="btn btn-blue hide" >Update Vehicle</button>
                                            <button id="addcar-update-submit" type="button" class="btn btn-blue" >Add Vehicle</button>
                                        </div>
                                    </div> 
  
                            </div> 

                                </div>

                                <hr>


                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <a href="{{url('member-details/' . $members->ID)}}" class="btn btn-red-primex btn-block" >Save</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

@endsection

@section('customJS')
<script type="text/javascript">
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
                    //$('#topup').modal('toggle');
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
                    window.location.href = window.location.href;
                    /*$('#topup-success').removeClass('hide');
                    $('#topup-success-text').html(result.message);
                    $('#topup-submit').removeAttr('disabled');
                    $('#topup-amount').val('');
                    var CB = result.data.amount;
                    $('#topup-currentBalance').html(CB.substring(0, CB.length - 2));*/
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


    $("#updatemember-submit").click(function() { 
        $('#updatemember-submit').addClass('hide');
        $('#update-error, #update-success').addClass('hide');
        var name = $('#update-name').val();
        var number = $('#update-number').val();
        var email = $('#update-email').val();
        var id = $('#updateMemberID').val();

        if(name == '' | number=='' | email==''){
            $('#update-error').removeClass('hide');
            $('#update-error-text').html("All fields are required!");
            $('#updatemember-submit').removeClass('hide');
            return false;
        }

        if(!email.match(/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/)){
            $('#update-error').removeClass('hide');
            $('#update-error-text').html("Invalid email address!");
            $('#updatemember-submit').removeClass('hide');
            return false;
        }
       
        data = {
            'name': name,
            'number': number,
            'email': email,
            'id': id,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/update-member',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#update-success, #updatemember-submit').removeClass('hide');
                    $('#update-success-text').html(result.message);

                }else{
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updatemember-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });        
    });

    $("#addcar-submit").click(function() { 
        $('#addcar-submit').attr('disabled','true');
        $('#addcar-error').addClass('hide');
        var number = $('#carNumber').val();
        var manufacturer = $('#carManufacturer').val();
        var type = $('#carType').val();
        var color = $('#carColor').val();

        if(number == ''){
            $('#addcar-error').removeClass('hide');
            $('#addcar-error-text').html("All fields are required!");
            $('#addcar-submit').removeAttr('disabled');
            return false;
        }
       
        data = {
            'manufacturer': manufacturer,
            'number': number,
            'type': type,
            'memberID': $('#memberID').val(),
            'color': color,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/add-car',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#addcar-list').append('<label class="col-sm-12 col-sm-12 control-label">Car Number: '+result.data.carNumber+' added</label>');
                    $('#carNumber').val('');
                    $('#addcar-submit').removeAttr('disabled');
                }else{
                    $('#addcar-error').removeClass('hide');
                    $('#addcar-error-text').html(result.message);
                    $('#addcar-submit').removeAttr('disabled');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });


    $("#addcar-update-submit").click(function() { 
        $('#addcar-update-submit').attr('disabled','true');
        $('#updatecar-error, #updatecar-success').addClass('hide');
        var number = $('#update-carNumber').val();
        var model = $('#update-carModel').val();
        var manufacturer = $('#update-carManufacturer').val();
        var type = $('#update-carType').val();
        var color = $('#update-carColor').val();
        var id = $('#updateCarID').val();

        if(number == ''){
            $('#updatecar-error').removeClass('hide');
            $('#updatecar-error-text').html("All fields are required!");
            $('#updatecar-submit').removeAttr('disabled');
            return false;
        }
       
        data = {
            'manufacturer': manufacturer,
            'number': number,
            'model': model,
            'type': type,
            'memberID': $('#updateMemberID').val(),
            'color': color,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/add-car-member-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    /*$('#updatenewcar-list').append('<p><label class="col-xs-6 col-sm-6 control-label">Car Number: '+result.data.carNumber+'</label><button onclick="getCarDetails('+result.data.carID+')" type="button" class="btn btn-warning" ><i class="fa fa-pencil m-r-1"></i>  Edit</button></p>');*/
                    $('#updatenewcar-list').append('<p><label class="col-xs-6 col-sm-6 control-label">Vec. Number: '+result.data.carNumber+'</label><button onclick="getCarDetails('+result.data.carID+')" type="button" class="btn btn-warning" ><i class="fa fa-pencil m-r-1"></i>  Edit</button>&nbsp;&nbsp;<button onclick="deleteCarDetails(\''+result.data.carID+'-'+result.data.ClientID+'\')" type="button" class="btn btn-danger"><i class="fa fa-trash-o m-r-1"></i>  Delete</button></p>');
                    $('#update-carNumber').val('');
                    $('#addcar-update-submit').removeAttr('disabled');
                    $('#updatecar-success').removeClass('hide');
                    $('#updatecar-success-text').html(result.message);
                    $('.updateCarManu, .updateCarType, .updateCarColor').removeAttr('selected');
                }else{
                    $('#updatecar-error').removeClass('hide');
                    $('#updatecar-error-text').html(result.message);
                    $('#addcar-update-submit').removeAttr('disabled');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });


    $("#updatecar-submit").click(function() { 
        $('#updatecar-submit').attr('disabled','true');
        $('#updatecar-error, #updatecar-success').addClass('hide');
        var number = $('#update-carNumber').val();
        var manufacturer = $('#update-carManufacturer').val();
        var type = $('#update-carType').val();
        var color = $('#update-carColor').val();
        var id = $('#updateCarID').val();

        if(number == ''){
            $('#updatecar-error').removeClass('hide');
            $('#updatecar-error-text').html("All fields are required!");
            $('#updatecar-submit').removeAttr('disabled');
            return false;
        }
       
        data = {
            'manufacturer': manufacturer,
            'number': number,
            'type': type,
            'color': color,
            'id': id,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/update-car',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#updatecar-success').removeClass('hide');
                    $('#updatecar-success-text').html(result.message);
                    $('#updatecar-submit').removeAttr('disabled');
                }else{
                    $('#updatecar-error').removeClass('hide');
                    $('#updatecar-error-text').html(result.message);
                    $('#updatecar-submit').removeAttr('disabled');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });

    function getMemberDetails(id){
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
                    for(i=0;i<result.cars.length;i++){
                        /*$('#updatecar-list').append('<p><label class="col-xs-6 col-sm-6 control-label">Car Number: '+result.cars[i]['RegistrationNo']+'</label><button onclick="getCarDetails('+result.cars[i]['ID']+')" type="button" class="btn btn-warning" ><i class="fa fa-pencil m-r-1"></i>  Edit</button></p>');*/
                        $('#updatecar-list').append('<p id="' + result.cars[i]['ID'] + '-' + id + '"><label class="col-xs-6 col-sm-6 control-label">Vec. Number: '+result.cars[i]['RegistrationNo']+'</label><button onclick="getCarDetails('+result.cars[i]['ID']+')" type="button" class="btn btn-warning" ><i class="fa fa-pencil m-r-1"></i>  Edit</button>&nbsp;&nbsp;<button onclick="deleteCarDetails(\'' + result.cars[i]['ID'] + '-' + id + '\')" type="button" class="btn btn-danger" ><i class="fa fa-trash-o m-r-1"></i>  Delete</button></p>');
                    }
                    if(result.cars.length==0){
                        $('#update-car').removeClass('hide');
                    }
                    $('#updateMemberID').val(result.member.ID);
                    $('#updateMemberCode').html((result.member.Code != null) ? result.member.Code : result.member2.Code);
                    $('#update-name').val(result.member.Name);
                    $('#update-number').val(result.member.ContactNo);
                    $('#update-email').val(result.member.Email);
                }else{
                    $('#addcar-error').removeClass('hide');
                    $('#addcar-error-text').html(result.message);
                    $('#addcar-submit').removeAttr('disabled');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }

    function getCarDetails(id){
        $('#updatecar-error, #updatecar-success').addClass('hide');
        $("#updatecar-submit").removeClass('hide');
        $("#addcar-update-submit").addClass('hide');
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };
        $.ajax({
            url: $('#baseURL').val()+'/get-car-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                console.log(result)
                if(result.status){
                    $('#update-car').removeClass('hide');
                    $('#updateCarID').val(result.car.ID);
                    $('#update-carNumber').val(result.car.RegistrationNo);
                    $('.updateCarManu').removeAttr('selected');
                    $('#updateCarManu'+result.car.ManufacturerID).attr('selected','true');
                    $('.updateCarType').removeAttr('selected');
                    $('#updateCarType'+result.car.VehicleTypeID).attr('selected','true');
                    $('.updateCarColor').removeAttr('selected');
                    $('#updateCarColor'+result.car.Color).attr('selected','true');
                    
                }else{
                    $('#updatecar-error').removeClass('hide');
                    $('#updatecar-error-text').html(result.message);
                    $('#updatecar-submit').removeAttr('disabled');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }

    function deleteCarDetails(vecClientId) {
        var vehicleId = vecClientId.split('-')[0];
        var clientId = vecClientId.split('-')[1];

        data = {
            '_token': $('input[name=_token]').val(),
            'vehicleid': vehicleId,
            'clientid': clientId
        };

        $.ajax({
            url: $('#baseURL').val()+'/delete-car-details',
            type: 'POST',
            data: data,
            success: function (status) {
                //var result = JSON.parse(status);

                $('#' + vecClientId).remove();
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });

    }

    function clearUpdateCar(){
        $('#update-car').removeClass('hide');
        $('#update-carNumber').val('');
        $('.updateCarManu, .updateCarType, .updateCarColor').removeAttr('selected');
        $("#updatecar-submit").addClass('hide');
        $("#addcar-update-submit").removeClass('hide');
    }

</script>
@endsection