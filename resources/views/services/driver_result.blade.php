
@if(empty($MemberID))
<div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
    No Record Found.
</div>
@else
<div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
    <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Member ID</label></div>
    <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">{{ $MemberID }}</div>
    <input type="hidden" name="driver_id" value="{{ $Client->ID }}" />
</div>

<div class="col-md-12 col-xs-12 col-sm-12 m-xs-b-1">
    <div class="col-md-2 col-xs-6 col-sm-4 p-l-0"><label>Name</label></div>
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
    <div class="col-md-10 col-xs-6 col-sm-8 p-l-0 word-wrap">RM <span id="driverbalance">{{ $MemberBalance }}</span></div>
</div>

<div class="col-md-12 col-xs-12 col-sm-12"> 
    <div class="col-md-3 col-xs-12 col-sm-3 m-t-1 m-bot15">
        <input type="hidden" id="DriverMemberCode" value="{{ $MemberID }}">
        <input type="hidden" id="DriverClientID" value="{{ $Client->ID }}">
        <!--<a type="button" class="btn btn-danger pull-right btn-block" data-toggle="modal" id="driverTopupButton" href="#driver_topup"><i class="fa fa-plus m-r-1"></i> Top Up </a>--> 
    </div> 
</div>
@endif
<script>
    $(document).ready(function () {
    $('#driverTopupButton').click(function () {
            
            $('#driver_member_id').html('&nbsp;&nbsp;Loading..');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '{{ route("getClientDetails") }}',
                data: {
                    ClientID: $("#DriverClientID").val(),
                    MemberCode: $("#DriverMemberCode").val(),
                   
                },
                dataType: 'json',
                success: function (result) {
                    //Success!
                    $('#driver_client_id_val').val(result.ClientID);
                    $('#driver_member_id_val').val(result.MemberID);
                    $('#driver_member_id').text(result.MemberID);
                    $('#driver_client_name').text(result.ClientName);
                    $('#driver_member_balance').text(result.MemberBalance);
                    $('#payment_type').text(result.PaymentTypes);
                    
                   
                },
                error: function (xhr, status) {
                    //window.location.reload();
                },
                complete: function (xhr, status) {
                    //$('#loader').addClass('hide');

                }
            });
        });
          });
        </script>