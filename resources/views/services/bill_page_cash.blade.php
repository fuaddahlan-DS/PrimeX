<div class="row">
    <div  class="col-xs-12 col-sm-12 col-md-12">
        <label class="col-xs-12 col-sm-12 col-md-12 text-right">Date: {{ $date }}</label>  
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
                   
                    @if(empty($result))
                    <tr> 
                        <td colspan="6">
                            No Record Found
                        </td>
                    </tr>
                    @else
                    @foreach($result as $list)
                    <input type="hidden" name="invoice_productID[]" value="{{ $list['ID'] }}">
                    <input type="hidden" name="invoice_productCode[]" value="{{ $list['Code'] }}">
                    <input type="hidden" name="invoice_productName[]" value="{{ $list['Name'] }}">
                    <input type="hidden" name="invoice_productNormalPrice[]" value="{{ number_format((float) $list['NormalPrice'], 2, '.', '') }}">
                    <input type="hidden" name="invoice_productDiscount[]" value="{{ $list['Discount'] }}">
                    <input type="hidden" name="invoice_productTotal[]" value="{{ $list['Total'] }}">
                    <tr> 
                        <td>{{ $list['Code'] }}</td>
                        <td>{{ $list['Name'] }}</td>
                        <td>{{ number_format((float) $list['NormalPrice'], 2, '.', '') }}</td>
                        <td> 1<input type="hidden" name="invoice_product_quantity[]" value="1">
                            <!--<select class="" name="invoice_product_quantity[]" id="quantity">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                            </select>-->
                        </td>
                        <td>{{ $list['Discount'] }}</td>
                        <td>{{ $list['Total'] }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-xs-12 pull-right">
        
            <div class="form-group p-l-0 p-r-0">
                <label class="col-sm-5 col-sm-5 control-label">Net Total</label>
                <div class="col-sm-7">
                    <input id="invoice_NetTotal" type="text" class="form-control" name="invoice_NetTotal" value="{{ $NetTotal }}" onkeypress="changeValues();">
                </div>
            </div> 

            <div class="form-group p-l-0 p-r-0">
                <label class="col-sm-5 col-sm-5 control-label">GST (6%)</label>
                <div class="col-sm-7">
                    <input id="gst" type="text" class="form-control" name="invoice_GST" value="{{ $GST }}">
                </div>
            </div> 
            <div class="form-group p-l-0 p-r-0">
                <label class="col-sm-5 col-sm-5 control-label">Total</label>
                <div class="col-sm-7">
                    <input id="gross" type="text" class="form-control" name="invoice_GrossTotal" value="{{ $GrossTotal }}">
                </div>
            </div>

            <div class="form-group p-l-0 p-r-0">
                <label class="col-xs-5 col-sm-5 control-label">Payment Type</label>
                <div class="col-sm-7">
                    <select class="form-control" name="invoice_payment_type">
                        <option value="1" selected="selected">Cash</option>
                        <option value="2">Credit Card</option>
                        <option value="3">Cheque</option>
                        <option value="4">Online Transfer</option>
                    </select>
                </div>
            </div>   

            <div class="form-group p-l-0 p-r-0 m-b-6">
                <label class="col-sm-5 col-sm-5 control-label">Paid</label>
                <div class="col-sm-7">
                    <input id="paid" type="text" name="invoice_paid" value="{{ $Paid }}" class="form-control">
                </div>
            </div> 

            <div class="form-group p-l-0 p-r-0">
                <label class="col-sm-5 col-sm-5 control-label">Due</label>
                <div class="col-sm-7">
                    <input type="text" name="invoice_due" value="{{ $Due }}" class="form-control">
                </div>
            </div> 
        
    </div> 
</div>

<script>
    function changeValues() {
        var invoice_NetTotal = $('#invoice_NetTotal').val();
        var gst = (6/100) * invoice_NetTotal;

        $('#gst').val(gst.toFixed(2));
        
        var gross = parseFloat(gst.toFixed(2)) + parseFloat(invoice_NetTotal);

        $('#gross').val(gross.toFixed(2));
        $('#paid').val(gross.toFixed(2));
    }
</script>