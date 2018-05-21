<style>

    .title_tr { border: solid 1px;border-bottom:double 3px; height: 30px; }

    .con_td { border: solid 1px; height: 30px; padding:4px; }

    .p-a-5 { padding: 5px; }
    
    .note-h{ height: 40px;}
</style>   
<table cellpadding="0" cellspacing="0" style=" background:#fff; width:100%" align="center">
    <tr>
        <td>
            <table style="width:100%; margin-top: 15px;font-size:13px;padding-right:35px" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:4%">&nbsp;</td>
                    <td style="width:6%">&nbsp;</td>
                    <td style="width:2%">&nbsp;</td>
                    <td style="width:37%">&nbsp;</td>
                    <td style="width:12%">&nbsp;</td>
                    <td style="width:12%">&nbsp;</td>
                    <td style="width:3%">&nbsp;</td>
                    <td style="width:12%">&nbsp;</td>
                    <td style="width:2%">&nbsp;</td>
                    <td style="width:12%">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" colspan="3" style="">
                        <img src="{{ asset('/images/primex/primexlogo.png') }}" style="width:107px; border:none;" border='0'/>
                    </td>
                    <td colspan="7" style="" valign="top">
                        <font style="font-weight: bold; font-size:32px">PrimeX Auto Detailing</font>
                        <b style="font-size:12px"><!--(Company no. 1096985-X)--></b>
                        <br>
                        <font style="font-size:12px">
                        28, 30, Jalan Mahogani 1,
                        <br>
                        Bandar Botanic, 41200 Klang. Selangor D.E. 
                        <br>
                        Tel no. 03-3318 6537 
                        </font>
                    </td>

                </tr>
                <tr>
                    <td colspan="10" style="height: 90px; text-align: center"><font style="font-weight: bold; font-size:30px">Receipt</font></td>
                </tr>
                <tr>
                    <td colspan="2">
                         Client name
                    </td>
                    <td>:</td>
                    <td>
                        {{ $data['sales_details']->ClientName }}
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">Receipt no.</td>
                    <td>:</td>
                    <td>{{ $data['receipt_details']->ReceiptNo }}</td>
                </tr>
                <tr>
                    <td colspan="2" valign="top">Phone no.</td>
                    <td valign="top">:</td>
                    <td valign="top">{{ $data['sales_details']->ContactNo }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">Date</td>
                    <td>:</td>
                    <td>{{ $data['receipt_details']->ReceiptDate }}</td>
                </tr>
                <tr>
                    <td colspan="2" valign="top">Vehicle reg. no.</td>
                    <td valign="top">:</td>
                    <td valign="top">{{ $data['sales_details']->VehicleRegistrationNo }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">Sales Advisor</td>
                    <td>:</td>
                    <td>{{ $data['sales_details']->SalesAdvisorName }}</td>
                </tr>
                <tr>
                    <td colspan="2" valign="top">Manufacturer</td>
                    <td valign="top">:</td>
                    <td valign="top">{{ $data['sales_details']->VehicleManufacturer }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" valign="top">Model</td>
                    <td valign="top">:</td>
                    <td valign="top">{{ $data['sales_details']->VehicleModel }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" valign="top">Color</td>
                    <td valign="top">:</td>
                    <td valign="top">{{ $data['sales_details']->VehicleColor }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                
               
                <tr>
                    <td colspan="10" style="height:20px">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" class="title_tr"><b>Code</b></td>
                    <td align="center" class="title_tr" colspan="3"><b>Service</b></td>
                    <td align="center" class="title_tr"><b>Unit Price (RM)</b></td>
                    <td align="center" class="title_tr"><b>Quantity</b></td>
                    <td align="center" class="title_tr" colspan="3"><b>Discount (%)</b></td>
                    <td align="center" class="title_tr"><b>Total Amount (RM)</b></td>
                </tr>
                
                @foreach($data['salesOrderDetails'] as $salesOrderDetail)
                <tr>
                    <td class="con_td">{{ $salesOrderDetail->ProductCode }}</td>
                    <td class="con_td" colspan="3">
                       {{ $salesOrderDetail->ProductName }}
                    </td>
                    <td align="right" class="con_td"> {{ number_format((float) $salesOrderDetail->UnitPrice, 2, '.', '') }}</td>
                    <td align="center" class="con_td">{{ number_format((float) $salesOrderDetail->Quantity, 0,'.', '') }}</td>
                    <td align="right" class="con_td" colspan="3">{{ number_format((float) $salesOrderDetail->Discount, 0, '.', '') }}</td>
                    <td align="right" class="con_td">{{ number_format((float) $salesOrderDetail->Total, 2, '.', '') }}</td>
                </tr>  
               
                @endforeach
                <tr>
                    <td colspan="6"></td>
                    <td class="con_td" colspan="3">Sub Total</td>
                    <td align="right" class="con_td">{{ $data['sales_details']->NetTotal }}</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td class="con_td" colspan="3">GST 6%</td>
                    <td align="right" class="con_td">{{ number_format((float) $data['sales_details']->GST, 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td class="con_td" style="border-bottom: double 3px;border-top: double 3px" colspan="3">Total</td>
                    <td align="right" class="con_td" style="border-bottom: double 3px;border-top: double 3px">{{ number_format((float) $data['sales_details']->GrossTotal, 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td class="con_td" style="border-bottom: double 3px;border-top: double 3px" colspan="3">Paid</td>
                    <td align="right" class="con_td" style="border-bottom: double 3px;border-top: double 3px">{{ $data['sales_details']->Paid }}</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td class="con_td" style="border-bottom: double 3px;border-top: double 3px" colspan="3">Due</td>
                    <td align="right" class="con_td" style="border-bottom: double 3px;border-top: double 3px">{{ $data['sales_details']->Due }}</td>
                </tr>
                <tr>
                    <td colspan="10" style="height:20px">Thank You For Your Business.</td>
                </tr>
             
                <tr>
                    <td colspan="10" style="height:20px"></td>
                </tr>
               
            </table>
           
        </td>        
    </tr>
</table>
<script>
    $(document).ready(function () {
        initdatepicker();
    });
</script>

