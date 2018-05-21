@extends('layouts.app')

@section('content')
 <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Sales Order
            </h3> 
            <ul class="breadcrumb">
                <li>
                    <a href="index.html">Dashboard</a>
                </li>
                <li>
                    <a href="#" onclick="return false;">Sales</a>
                </li>
                <li class="active"> Sales Order</li>
            </ul>
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">

            
            <div class="row">
                <form action="{{ URL::route('sales-list') }}" class="transfer" method="post" id="print_form" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="col-md-3 col-xs-12 col-sm-4"> 
                   <!--  <a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" href="#addmember"><i class="fa fa-plus m-r-1"></i> Add Member</a>  -->
                </div> 
                <div class="col-md-4 col-xs-12 col-sm-4 pull-right"> 
                    <div class="input-group m-bot15">
                        <input type="text" class="form-control" name="keyword" placeholder="Search by sales order no. or client name">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div> 
                </form>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <section>
                        <table class="table table-resp table-bordered">
                            <thead class="cf">
                            <tr>
                                <th>Date</th>
                                <th>Sales Order No.</th>
                                <th>Name</th>
                                <th>Vehicle Number</th> 
                                <th>Services</th> 
                                <th>Payment Type</th> 
                                <th class="numeric">Total Amount</th>
                                <th>Closed By</th>
                                <th>&#32;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(empty($data['records']) && $data['records']->count() <= 0)
                             <tr>
                                 <td colspan="9">No Record Found</td>
                             </tr>
                            @else
                            @foreach($data['records'] as $record)   
                                <tr>
                                    <td>{{ $record->SalesDate }}</td>
                                    <td>{{ $record->SalesNo }}</td>
                                    <td>{{ $record->ClientName }}</td>
                                    <td>{{ $record->VehicleRegNo }}</td>
                                    <td><a style="color:#337ab7" href="{{ route("sale",['id' => $record->ID]) }}">{{ $record->Services }}</a></td>
                                    <td>{{ $record->PaymentName }}</td>
                                    <td class="numeric">{{ $record->GrossTotal }}</td> 
                                    <td>{{ $record->CloseBy }}</td> 
                                    <td>
                                        <a type="button" class="btn btn-red-primex pull-right btn-block" href="{{ route("sale",['id' => $record->ID]) }}"> View</a>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                        
                    </section>
                </div>
                
            </div>
            <div class="row">
                                    <!--<div class="col-sm-5">
                                        <div class="dataTables_info" role="status" aria-live="polite">
                                            Showing {{($data['records']->currentpage()-1)*$data['records']->perpage()+1}} to 
                                            {{($data['records']->currentpage()-1)*$data['records']->perpage()+count($data['records'])}}
                                            of  {{$data['records']->total()}} entries
                                        </div>

                                    </div>-->
                                    <div class="col-sm-7">
                                        <div class="dt_processing hide"></div>
                                        <div class="dataTables_paginate paging_simple_numbers" id="pagination-load">
                                            {!! $data['records']->render(); !!}
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

