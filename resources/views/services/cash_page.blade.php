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
                    <form action="{{ URL::route('finduser') }}" method="post" id="finduser_form" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <h4 class="h3-red">Cash Sale</h4>
                        </div>
                        @if ($errors->has('RegistrationNo'))
                            <span class="help-block col-md-offset-3" style="color:red">
                                {{ $errors->first('RegistrationNo') }}
                            </span>
                        @endif
                        <div class="col-md-12 col-xs-12 col-sm-12 m-bot15">
                            <div class="col-md-2 col-xs-4 col-sm-4 p-l-0"><label>Car Number</label></div>
                            <div class="col-md-4 col-xs-8 col-sm-8 p-l-0"> 
                                <input type="text" name="RegistrationNo" class="form-control" placeholder="Enter Number Plate" value="{!! (!empty($data['input']['RegistrationNo']) ? $data['input']['RegistrationNo'] : old('RegistrationNo')) !!}">
                            </div>
                        </div> 
                        @if ($errors->has('VehicleModel'))
                            <span class="help-block col-md-offset-3" style="color:red">
                                {{ $errors->first('VehicleModel') }}
                            </span>
                        @endif
                        <div class="col-md-12 col-xs-12 col-sm-12 m-bot15">
                            <div class="col-md-2 col-xs-4 col-sm-4 p-l-0"><label>Car Model</label></div>
                            <div class="col-md-4 col-xs-8 col-sm-8 p-l-0"> 
                                <input type="text" name="VehicleModel" class="form-control" placeholder="Exp: Myvi SE, Saga SE etc.." value="{!! (!empty($data['input']['VehicleModel']) ? $data['input']['VehicleModel'] : old('VehicleModel')) !!}">
                            </div>
                        </div>
                        @if ($errors->has('Name'))
                            <span class="help-block col-md-offset-3" style="color:red">
                                {{ $errors->first('Name') }}
                            </span>
                        @endif
                        <div class="col-md-12 col-xs-12 col-sm-12 m-bot15">
                            <div class="col-md-2 col-xs-4 col-sm-4 p-l-0"><label>Customer Name</label></div>
                            <div class="col-md-4 col-xs-8 col-sm-8 p-l-0"> 
                                <input type="text" name="Name" class="form-control" placeholder="Enter Customer Name" value="{!! (!empty($data['input']['Name']) ? $data['input']['Name'] : old('Name')) !!}">
                            </div>
                        </div>
                        @if ($errors->has('Email'))
                            <span class="help-block col-md-offset-3" style="color:red">
                                {{ $errors->first('Email') }}
                            </span>
                        @endif
                        <div class="col-md-12 col-xs-12 col-sm-12 m-bot15">
                            <div class="col-md-2 col-xs-4 col-sm-4 p-l-0"><label>Customer Email</label></div>
                            <div class="col-md-4 col-xs-8 col-sm-8 p-l-0"> 
                                <input type="text" name="Email" class="form-control" placeholder="Enter Customer Email" value="{!! (!empty($data['input']['Email']) ? $data['input']['Email'] : old('Email')) !!}">
                            </div>
                        </div>
                        @if ($errors->has('ContactNo'))
                            <span class="help-block col-md-offset-3" style="color:red">
                                {{ $errors->first('ContactNo') }}
                            </span>
                        @endif
                        <div class="col-md-12 col-xs-12 col-sm-12 m-bot15">
                            <div class="col-md-2 col-xs-4 col-sm-4 p-l-0"><label>Phone Number</label></div>
                            <div class="col-md-4 col-xs-8 col-sm-8 p-l-0"> 
                                <input type="text" name="ContactNo" class="form-control" placeholder="Enter Phone Number" value="{!! (!empty($data['input']['ContactNo']) ? $data['input']['ContactNo'] : old('ContactNo')) !!}">
                            </div>
                        </div>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group"> 
                            <div class="col-md-2 col-md-offset-2">
                                <button class="btn btn-success btn-block" type="Submit">Submit</button>
                            </div>
                        </div> 
                    </div>
                </div>

                </form>


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


    $(document).ready(function () {


    });


</script>
@endsection

