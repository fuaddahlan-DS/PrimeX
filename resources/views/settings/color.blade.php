<?php
    use App\Http\Controllers\RolesAccessController;
?>

@extends('layouts.app')

@section('customCSS')
  <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
@endsection

@section('content')
         <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Color
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('home')}}">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Settings</a>
                </li>
                <li class="active"> Colors </li>
            </ul>
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper"> 
            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-4"> 
                    <?= (RolesAccessController::checkSettingsCreate() == true) ? '<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addcolor"><i class="fa fa-plus m-r-1"></i> Add New Color</a>' : '' ?>                     
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
                    <section >
                        <table class="table table-resp table-bordered">
                            <thead class="cf">
                            <tr>
                                <th>Color ID</th>
                                <th>Color Name</th>
                                <th>Color</th> 
                                <th>HEX Code</th> 
                                <th>&#32;</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($colors as $color)
                                <tr>
                                    <td>{{ $color->ID }}</td>
                                    <td>{{ $color->Name }}</td>
                                    <td>
                                        <div class="panel m-b-0"><div class="panel-body" style="background-color: {{ $color->Code }};"></div></div>
                                    </td>
                                    <td>{{ $color->Code }}</td>
                                    <td>
                                        <?= (RolesAccessController::checkSettingsUpdate() == true) ? '<a type="button" class="btn btn-blue-primex pull-right btn-block" data-toggle="modal" href="#updatecolor" onclick="getColorDetails(' . $color->ID . ')">Edit</a>' : '' ?>
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                    @php
                    $paginationLink = $colors->links('vendor.pagination.bootstrap-4');
                    if(request()->has('search'))
                        $paginationLink = $colors->appends(['search' => request()->input('search')])->links('vendor.pagination.bootstrap-4');
                    @endphp
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        {{$paginationLink}}
                    </div>
                </div>
            </div>
           
        </div>
        <!--body wrapper end-->


        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="addcolorLabel" role="dialog" tabindex="-1" id="addcolor" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                        <h4 class="modal-title">Add New Color</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal adminex-form" method="get">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="add-error" class="form-group p-l-1 p-r-1 hide">
                                            <div id="add-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                        </div>
                                        <div id="add-success" class="form-group p-l-1 p-r-1 hide">
                                            <div id="add-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Color Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="add-name" name="name" type="text" class="form-control" placeholder="Enter Color Name">
                                            </div>
                                        </div> 
 
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Color Picker Code</label>
                                            <div class="col-xs-7 col-sm-7"> 
                                               <div data-color-format="rgb" data-color="rgb(255, 146, 180)" class="input-append colorpicker-default color">
                                                    <input id="add-code" name="code" type="text" readonly="" value="" class="form-control">
                                                      <span class=" input-group-btn add-on">
                                                          <button class="btn btn-default" type="button" style="padding: 8px">
                                                              <i style="background-color: rgb(124, 66, 84);"></i>
                                                          </button>
                                                      </span>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>   
                                </div>

                                <hr> 

                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button id="addcolor-submit" type="button" class="btn btn-red-primex btn-block">Save</button>
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
        <div aria-hidden="true" aria-labelledby="updatecolorLabel" role="dialog" tabindex="-1" id="updatecolor" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = window.location.href;">&times;</button>
                        <h4 class="modal-title">Update Color</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="updateColorID">
                             <form class="form-horizontal adminex-form" method="get">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="update-error" class="form-group p-l-1 p-r-1 hide">
                                            <div id="update-error-text" class="col-xs-12 col-xs-12 col-sm-12 error text-center error"></div>
                                        </div>
                                        <div id="update-success" class="form-group p-l-1 p-r-1 hide">
                                            <div id="update-success-text" class="col-xs-12 col-xs-12 col-sm-12 text-center success"></div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Color ID</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <label id="update-id" class="control-label"></label>
                                            </div>
                                        </div>

                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Color Name</label>
                                            <div class="col-xs-7 col-sm-7">
                                                <input id="update-name" name="name" type="text" class="form-control" placeholder="Enter Color Name">
                                            </div>
                                        </div> 
 
                                        <div class="form-group p-l-1 p-r-1">
                                            <label class="col-xs-5 col-sm-5 control-label">Color Picker Code</label>
                                            <div class="col-xs-7 col-sm-7"> 
                                               <div data-color-format="rgb" data-color="rgb(255, 146, 180)" class="input-append colorpicker-default color">
                                                    <input id="update-code" name="code" type="text" readonly="" value="" class="form-control">
                                                      <span class=" input-group-btn add-on">
                                                          <button class="btn btn-default" type="button" style="padding: 8px">
                                                              <i style="background-color: rgb(124, 66, 84);"></i>
                                                          </button>
                                                      </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="updatecolors" class="col-sm-12 col-xs-12 text-center"> 
                                        </div> 
                                    </div>   
                                </div>

                                <hr> 
                                
                                <div class="form-group"> 
                                    <div class="col-sm-4 col-sm-offset-4 text-center">
                                        <button id="updatecolor-submit" type="button" class="btn btn-red-primex btn-block" >Save</button>
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
<!--pickers plugins-->
<script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--pickers initialization-->
<script src="js/pickers-init.js"></script>

<script type="text/javascript">
	$("#addcolor-submit").click(function() { 
        $('#addcolor-submit').addClass('hide');
        $('#add-error, #add-success').addClass('hide');
        var name = $('#add-name').val();
        var code = $('#add-code').val();

        if(name == '' | code==''){
            $('#add-error').removeClass('hide');
            $('#add-error-text').html("Name and Code are required!");
            $('#addcolor-submit').removeClass('hide');
            return false;
        }

        data = {
            'name': name,
            'code': code,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/add-color',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#add-success, #addcolor-submit').removeClass('hide');
                    $('#add-success-text').html('Color record ('+result.data.colorName+') successfully added!');

                }else{
                    $('#add-error').removeClass('hide');
                    $('#add-error-text').html(result.message);
                    $('#addcolor-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });



    $("#updatecolor-submit").click(function() { 
        $('#updatecolor-submit').addClass('hide');
        $('#update-error, #update-success').addClass('hide');
        var name = $('#update-name').val();
        var code = $('#update-code').val();
        var id = $('#updateColorID').val();

        if(name == '' | code==''){
            $('#update-error').removeClass('hide');
            $('#update-error-text').html("Name and Code are required!");
            $('#updatecolor-submit').removeClass('hide');
            return false;
        }

        data = {
            'name': name,
            'code': code,
            'id': id,
            '_token': $('input[name=_token]').val(),
        };

        $.ajax({
            url: $('#baseURL').val()+'/update-color',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                    $('#update-success, #updatecolor-submit').removeClass('hide');
                    $('#update-success-text').html(result.message);

                }else{
                    $('#update-error').removeClass('hide');
                    $('#update-error-text').html(result.message);
                    $('#updatecolor-submit').removeClass('hide');
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
        
    });


    function getColorDetails(id){
        $('#updatecolors').html('');
        data = {
            'id': id,
            '_token': $('input[name=_token]').val(),
        };
        $.ajax({
            url: $('#baseURL').val()+'/get-color-details',
            type: 'POST',
            data: data,
            success: function (status) {
                var result = JSON.parse(status);
                //console.log(result)
                if(result.status){
                	$('#updateColorID').val(result.colors.ID);
                	$('#update-id').html(result.colors.ID);
                	$('#update-name').val(result.colors.Name);
                    $('#update-code').val(result.colors.Code);
                }else{
                    $('#updatecolor').html(result.message);
                }
            },
            error: function(jqXHR, exception){
                ajax_error_handling(jqXHR, exception);
            }
        });
    }
</script>
@endsection        