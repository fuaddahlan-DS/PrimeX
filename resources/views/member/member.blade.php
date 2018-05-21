@extends('layouts.app')

@section('content')
        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Members
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('home')}}">Dashboard</a>
                </li>
                <li class="active"> All Members </li>
            </ul>
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">

            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-4"> 
                    <a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addmember"><i class="fa fa-plus m-r-1"></i> Add Member</a> 
                </div> 
                <div class="col-md-4 col-xs-12 col-sm-4 pull-right"> 
                    <div class="input-group m-bot15">
                        <form method="get" action="">
                            <input type="text" name="search" class="form-control" style="width: 89% important;">
                            <span class="input-group-btn inline">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </form>
                    </div>
                </div> 
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <section>
                        <table class="table table-resp table-bordered">
                            <thead class="cf">
                            <tr>
                                <th>Member ID</th>
                                <th>Member Name</th>
                                <th>Phone Number</th>
                                <th>Email</th> 
                                <th class="numeric">Balance</th>
                                <th>&#32;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td><?php App::make("App\Http\Controllers\MemberController")->getMemberCode($member->ID); ?></td>
                                    <td>{{ $member->Name }}</td>
                                    <td>{{ $member->ContactNo }}</td>
                                    <td>{{ $member->Email }}</td>
                                    <td class="numeric"><?php App::make("App\Http\Controllers\MemberController")->getMemberBalance($member->ID); ?></td> 
                                    <td>
                                        <div class="btn-group btn-block">
                                            <button data-toggle="dropdown" class="btn btn-default btn-block dropdown-toggle btn-red-primex" type="button">Actions <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="/member-details/{{$member->ID}}">Details</a></li>
                                                <li><a data-toggle="modal" href="#topup" onclick="topup({{$member->ID}})">Top Up</a></li>
                                                <li><a data-toggle="modal" href="#updatemember" onclick="getMemberDetails({{$member->ID}})">Update</a></li> 
                                            </ul>
                                        </div><!-- /btn-group btn-block -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </section>
                    @php
                    $paginationLink = $members->links('vendor.pagination.bootstrap-4');
                    if(request()->has('search'))
                        $paginationLink = $members->appends(['search' => request()->input('search')])->links('vendor.pagination.bootstrap-4');
                    @endphp
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        {{$paginationLink}}
                    </div>
                </div>
            </div>

        </div>
        <!--body wrapper end-->
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
                            <input type="hidden" id="memberID">
                           <form class="form-horizontal adminex-form" method="get">

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="add-error" class="form-group p-l-1 p-r-1 hide">
                                        <div id="add-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                    </div>
                                    <div id="memberCodeDiv" class="form-group p-l-1 p-r-1 hide">
                                        <label class="col-xs-6 col-xs-5 col-sm-5 control-label">Member ID</label>
                                        <div class="col-xs-6 col-sm-7">
                                            <label id="memberCode" class="control-label">M02</label>
                                        </div>
                                    </div>

                                    <div class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-5 col-sm-5 control-label">Name</label>
                                        <div class="col-sm-7">
                                            <input type="text" id="add-name" class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div> 

                                    <div class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-5 col-sm-5 control-label">Email</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="add-email" type="email" placeholder="Enter Email">
                                        </div>
                                    </div> 

                                    <div class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-5 col-sm-5 control-label">Phone Number</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="add-number" placeholder="Enter Phone Number">
                                        </div>
                                    </div> 

                                    <div class="form-group p-l-1 p-r-1">
                                        <label class="col-xs-5 col-sm-5 control-label"></label>
                                        <div class="col-sm-7 text-right">
                                            <button id="addmember-submit" type="button" id="add-submit" class="btn btn-blue" >Add Member</button>
                                        </div>
                                    </div> 

                                     <div id="addcar-list" class="col-sm-12 col-xs-12 text-center"> 
                                    </div>  
                               
                                </div> 

                            <div id="add-car" class="col-md-6 col-sm-6 col-xs-12 hide">

                                <div class="p-xs-l-1 p-xs-r-1">
                                    <div id="addcar-error" class="form-group p-l-1 p-r-1 hide">
                                        <div id="addcar-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                    </div>

                                    <div class="form-group p-l-1 p-r-1">
                                        <label for="exampleInputEmail1">Vehicle Number</label>
                                        <input id="carNumber" class="form-control" placeholder="Enter Number Plate">
                                    </div> 
                                    
                                    <div class="form-group p-l-1 p-r-1">
                                        <label for="exampleInputEmail1">Vehicle Model</label>
                                        <input id="carModel" class="form-control" placeholder="Exp: Myvi SE, Saga SE etc..">
                                    </div> 

                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label for="exampleInputEmail1">Vehicle Manufacturer</label>
                                        <select id="carManufacturer" class="form-control m-bot15">
                                        @foreach ($manufacturers as $manufacturer)
                                            <option value="{{$manufacturer->ID}}">{{$manufacturer->Name}}</option>
                                        @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label>Vehicle Type</label>
                                        <select id="carType" class="form-control m-bot15">
                                            @foreach ($vehicletypes as $vehicletype)
                                                <option value="{{$vehicletype->ID}}">{{$vehicletype->Name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label for="exampleInputEmail1">Vehicle Color</label>
                                        <select id="carColor" class="form-control m-bot15">
                                            @foreach ($colors as $color)
                                                <option value="{{$color->ID}}">{{$color->Name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                     <div class="form-group"> 
                                        <div class="col-sm-12 text-center">
                                            <button id="addcar-submit" type="button" class="btn btn-blue" >Add Vehicle</button>
                                        </div>
                                    </div> 
  
                            </div> 

                                </div>

                                <hr>


                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <a href="{{url('member')}}" class="btn btn-red-primex btn-block" >Save</a>
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href">&times;</button>
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
                                                    <option value="{{$paymentType->id}}">{{$paymentType->name}}</option>
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
                                        <input id="update-carModel" class="form-control" placeholder="Exp: Myvi SE, Saga SE etc..">
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
                                        <a href="{{url('member')}}" class="btn btn-red-primex btn-block" >Save</a>
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
    $("#addmember-submit").click(function() { 
        $('#addmember-submit').addClass('hide');
        $('#add-error').addClass('hide');
        var name = $('#add-name').val();
        var number = $('#add-number').val();
        var email = $('#add-email').val();

        if(name == '' | number=='' | email==''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("All fields are required!");
            $('#addmember-submit').removeClass('hide');
            return false;
        }

        if(!email.match(/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/)){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("Invalid email address!");
            $('#addmember-submit').removeClass('hide');
            return false;
        }
       
        data = {
            'name': name,
            'number': number,
            'email': email,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/add-member',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#memberCode').html(result.data.memberCode);
                    $('#memberID').val(result.data.memberID);
                    $('#memberCodeDiv').removeClass('hide');
                    $('#add-car').removeClass('hide');
                    $('#add-name, #add-number, #add-email').attr('readonly','true');

                }else{
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addmember-submit').removeClass('hide');
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
        var model = $('#carModel').val();
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
            'model': model,
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
                    $('#addcar-list').append('<label class="col-sm-12 col-sm-12 control-label">Vehicle Number: '+result.data.carNumber+' added</label>');
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
                    $('#updatenewcar-list').append('<p><label class="col-xs-6 col-sm-6 control-label">Vehicle Number: '+result.data.carNumber+'</label><button onclick="getCarDetails('+result.data.carID+')" type="button" class="btn btn-warning" ><i class="fa fa-pencil m-r-1"></i>  Edit</button>&nbsp;&nbsp;<button onclick="deleteCarDetails(\''+result.data.carID+'-'+result.data.ClientID+'\')" type="button" class="btn btn-danger"><i class="fa fa-trash-o m-r-1"></i>  Delete</button></p>');
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

</script>
@endsection