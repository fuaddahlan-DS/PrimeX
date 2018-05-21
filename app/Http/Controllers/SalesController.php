<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Service;
use App\Servicecategory;
use App\Salesorder;
use App\Salesorderdetail;
use App\Vehicle;
use App\Vehicletype;
use App\Manufacturers;
use DateTime;
use App\Job;
use App\User;
use App\Jobdetail;
use App\Clientvehiclejoin;
use App\Client;
use App\Color;
use App\Product;
use App\Productprices;
use App\PaymentType;
use App\Member;
use App\DealerCompany;
use App\DealerUser;
use App\Membercreditledger;
use Response;
use Carbon\Carbon;
use App\Receipt;
use App\Receiptdetail;
use PDF;

class SalesController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function SalesList(Request $request) {

        //Search base on request (POST) value
        $input = $request->all();

        if (!empty($input)) {

            if (!empty($input['keyword'])) {
                $input['keyword'] = trim($input['keyword']);
            } else {
                unset($input['keyword']);
            }
        }

        //get total account
        $total_sales = Salesorder::count();
        $sales_order = Salesorder::leftJoin('clients', 'salesorder.ClientID', 'clients.ID')
                ->leftjoin('payment_type', 'salesorder.PaymentTypeID', 'payment_type.id')
                ->leftjoin('users', 'salesorder.ClosedBy', 'users.id')
                ->leftjoin('salesorderdetails', 'salesorder.ID', 'salesorderdetails.SalesOrderID');
        //column
        $sales_order->select(
                'salesorder.ID'
                ,'salesorder.SalesNo'
                ,'salesorder.SalesDate'
                ,'salesorder.VehicleID'
                ,'salesorder.VehicleRegistrationNo'
                 ,'salesorder.GrossTotal'
                , 'clients.Name as ClientName'
                , 'payment_type.name as PaymentName'
                , 'users.name as CloseBy'
        );

        //condition
        if (array_key_exists('keyword', $input)) {
            $sales_order->where(function ($query) use ($input) {
                $query->orWhere('salesorder.SalesNo', 'LIKE', '%' . trim($input['keyword']) . '%')
                        ->orWhere('clients.Name', 'LIKE', '%' . trim($input['keyword']) . '%');
            });
        }
        $sales_order->whereIn('salesorderdetails.ProductCode',['TRM01','WSH01']);
        $sales_order->groupBy('salesorder.ID','SalesNo','SalesDate','VehicleID','VehicleRegistrationNo','GrossTotal','clients.Name','payment_type.name','users.name');
        $sales_order->orderBy('SalesDate', 'DESC');


        $records = $sales_order->paginate(10);
        foreach ($records as $key => &$value) {

            if ($value['VehicleID'] > 0) {
                $VehicleRegNo = Vehicle::getVehicleDetailsByID($value['VehicleID'])->RegistrationNo;
            } else {
                $VehicleRegNo = $value['VehicleRegistrationNo'];
            }


            $value['SalesDate'] = Carbon::parse($value['SalesDate'])->format('d/m/Y');
            $value['VehicleRegNo'] = $VehicleRegNo;
            $value['Services'] = Salesorderdetail::listServices($value['ID']);
            $value['GrossTotal'] = number_format((float) $value['GrossTotal'], 2, '.', '');
        }

        $values = array();
        $values['data'] = array(
            'total_sales' => $total_sales
            , 'records' => $records
            , 'input' => $input
        );

        return view('sales.list', $values);
    }

    public function SearchSales(Request $request) {

        //Search base on request (POST) value
        $input = $request->all();


        $data['vehicle_manufacturers'] = Manufacturers::get();
        $data['vehicle_types'] = Vehicletype::get();
        $data['vehicle_colors'] = Color::get();
        return view('sales.list', $data);
    }

    public function Sale($id) {

        ///SALES PART///
        $sales_order = Salesorder::leftJoin('clients', 'salesorder.ClientID', 'clients.ID')
                ->leftjoin('payment_type', 'salesorder.PaymentTypeID', 'payment_type.id')
                ->leftjoin('users', 'salesorder.ClosedBy', 'users.id');
        //column
        $sales_order->select(
                'salesorder.*'
                , 'clients.Name as ClientName'
                , 'clients.ContactNo'
                , 'clients.ID as ClientID'
                , 'payment_type.name as PaymentName'
                , 'users.name as CloseBy'
        );

        //condition
        $sales_details = $sales_order->Where('salesorder.ID', $id)->first();

        if ($sales_details['VehicleID'] > 0) {
            $VehicleRegNo = Vehicle::getVehicleDetailsByID($sales_details['VehicleID'])->RegistrationNo;
        } else {
            $VehicleRegNo = $sales_details['VehicleRegistrationNo'];
        }
        
        if(!is_null($sales_details['TechnicianID'])){
            $technician = User::getUserDetails($sales_details['TechnicianID'])->name;
        }else{
            $technician = '';
        }
        $sales_details['SalesDate'] = Carbon::parse($sales_details['SalesDate'])->format('d/m/Y');
        $sales_details['VehicleRegistrationNo'] = $VehicleRegNo;
        $sales_details['memberBalance'] = Client::getMemberBalanceByClientID($sales_details['ClientID']);
        $sales_details['TechnicianName'] = $technician;
        $sales_details['SalesAdvisorName'] = User::getUserDetails($sales_details['SalesAdvisorID'])->name;


        ///RECEIPT PART///
        $saleOrder = Salesorder::where('ID', $id)->first();

        $receipt_check = Receipt::where('CrossReferenceNo', $saleOrder->SalesNo)->count();
       
        if ($receipt_check <= 0) {//receipt not exists
            $rid = Receipt::insertGetId(
                            [
                                'ReceiptNo' => '',
                                'ReceiptDate' => Carbon::now()->toDateTimeString(),
                                'CrossReferenceNo' => $saleOrder->SalesNo,
                                'Amount' => $saleOrder->GrossTotal,
                                'BranchID' => Auth::user()->BranchID,
                                'createdBy' => Auth::user()->id,
                            ]
            );
            Receipt::where('id', $rid)
                    ->update(['ReceiptNo' => "RCB" . Auth::user()->BranchID . str_pad($rid, 7, "0", STR_PAD_LEFT)]);

            if ($saleOrder->PaymentTypeID == 4) {//membership
                $PaymentReferenceNo = Client::getMemberCodeByClientID($saleOrder->ClientID);
            } else {
                $PaymentReferenceNo = '';
            }
            Receiptdetail::insert(
                    [
                        'ReceiptID' => $rid,
                        'Amount' => $saleOrder->GrossTotal,
                        'PaymentType' => $saleOrder->PaymentTypeID,
                        'PaymentReferenceNo' => $PaymentReferenceNo,
                    ]
            );
        }
        
        $receipt_details = Receipt::where('CrossReferenceNo', $saleOrder->SalesNo)->first();

        $receipt_details['ReceiptDate'] = Carbon::parse($receipt_details['ReceiptDate'])->format('d/m/Y');

        ///SALES ORDER DETAILS PART//
        $salesOrderDetails = Salesorderdetail::where('SalesOrderID', $sales_details['ID'])->get();
        $NetTotal = 0;
        foreach($salesOrderDetails as $salesOrderDetail){
            $NetTotal = $NetTotal + $salesOrderDetail->Total;
        }
        $sales_details['NetTotal'] = number_format((float) $NetTotal, 2, '.', '');  
        
        //VEHICLES PART
        $clientVehicles = Clientvehiclejoin::select('clientvehiclejoin.*', 'vehicles.RegistrationNo', 'clients.Name', 'clients.ContactNo')
                ->join('vehicles', 'vehicles.ID', '=', 'clientvehiclejoin.VehicleID')
                ->join('clients', 'clients.ID', '=', 'clientvehiclejoin.ClientID')
                ->where('clients.ID', $saleOrder->ClientID)
                ->get();

        //USERS PART//
        $users_list = User::get();
        $sales_advisors = User::where('roleID', 2)->get();
        $technicians = User::where('roleID', 3)->get();
        
        
        //SERVICE PART///
        $servicecategories = Servicecategory::whereIn('ID',[2,3])->get();
        
        
        $values['data'] = array(
            "sales_details" => $sales_details,
            "receipt_details" => $receipt_details,
            "salesOrderDetails" => $salesOrderDetails,
            "clientVehicles" => $clientVehicles,
            "users_list" => $users_list,
            "sales_advisors" => $sales_advisors,
            "technicians" => $technicians,
            "servicecategories" => $servicecategories,
        );


        return view('sales.sale_details', $values);
    }

    public function UpdateSales(Request $request) {

        $input = $request->all();
        //dd($input);
        Salesorder::where('ID', $input['SalesOrderID'])
                    ->update(['vehicleID' => $input['vehicleID'],
                        "VehicleRegistrationNo" => Null,
                         "ClosedBy" => $input['ClosedBy'],
                         "SalesAdvisorID" => $input['SalesAdvisorID'],
                         "TechnicianID" => $input['TechnicianID'],
                         "GST" => $input['GST'],
                         "GrossTotal" => $input['GrossTotal'],
                         "Paid" => $input['Paid'],
                         "Due" => $input['Due'],
                        ]);
            
            
            
            $length = count($input['servicecategory']);
            for ($i = 0; $i < $length; $i++) {
            
            $P = explode("-", $input['servicecategory'][$i]);
            $ProductCode = $P[0];
            $ProductName = $P[1];
                
                
                
            $sodid = Salesorderdetail::where('ID', $input['SalesOrderDetailID'][$i])
                     ->update([
                        'ProductCode' => $ProductCode,
                        'ProductName' => $ProductName,
                        'UnitPrice' => $input['service_price'][$i],
                        //'UnitPriceIncludeGST' => 0,
                        'Quantity' => $input['service_quantity'][$i],
                        'Discount' => $input['service_discount'][$i],
                        //'GSTRate' => 0,
                        //'GSTExempted' => 0,
                        //'GST' => 0,
                        'Total' => $input['service_total'][$i],
                    ]
            );
           
            }
           
        return redirect()->route('sale',['id' => $input['SalesOrderID']]);
    }

    public function PrintSales(Request $request) {

        $input = $request->all();
        $id = $input['SalesOrderID'];
        
        ///SALES PART///
        $sales_order = Salesorder::leftJoin('clients', 'salesorder.ClientID', 'clients.ID')
                ->leftjoin('payment_type', 'salesorder.PaymentTypeID', 'payment_type.id')
                ->leftjoin('users', 'salesorder.ClosedBy', 'users.id');
        //column
        $sales_order->select(
                'salesorder.*'
                , 'clients.Name as ClientName'
                , 'clients.ContactNo'
                , 'clients.ID as ClientID'
                , 'payment_type.name as PaymentName'
                , 'users.name as CloseBy'
        );
 
        //condition
        $sales_details = $sales_order->Where('salesorder.ID', $id)->first();
 
        if ($sales_details['VehicleID'] > 0) {
            $VehicleRegNo = Vehicle::getVehicleDetailsByID($sales_details['VehicleID'])->RegistrationNo;
            $Color = Vehicle::getVehicleDetailsByID($sales_details['VehicleID'])->Color;
            if($Color > 0){
                $Color = Color::find($Color);
                $Color = $Color->Name;
            }else{
                $Color = '-';
            }
             $VehicleManufacturer = Vehicle::getVehicleDetailsByID($sales_details['VehicleID'])->manufacturerName;
             $VehicleModel = Vehicle::getVehicleDetailsByID($sales_details['VehicleID'])->Model;
        } else {
            $VehicleRegNo = $sales_details['VehicleRegistrationNo'];
            $Color = '-';
            $VehicleManufacturer = "-";
            $VehicleModel = "-";
            
            
            
        }
        
        if(!is_null($sales_details['TechnicianID'])){
            $technician = User::getUserDetails($sales_details['TechnicianID'])->name;
        }else{
            $technician = '';
        }
      
        
                
        $sales_details['SalesDate'] = Carbon::parse($sales_details['SalesDate'])->format('d/m/Y');
        $sales_details['VehicleRegistrationNo'] = $VehicleRegNo;
        $sales_details['VehicleManufacturer'] = $VehicleManufacturer;
        $sales_details['VehicleModel'] = $VehicleModel;
        $sales_details['VehicleColor'] = $Color;
        $sales_details['memberBalance'] = Client::getMemberBalanceByClientID($sales_details['ClientID']);
        $sales_details['TechnicianName'] = $technician;
        $sales_details['SalesAdvisorName'] = User::getUserDetails($sales_details['SalesAdvisorID'])->name;


        ///RECEIPT PART///
        $saleOrder = Salesorder::where('ID', $id)->first();

        $receipt_details = Receipt::where('CrossReferenceNo', $saleOrder->SalesNo)->first();

        if (empty($receipt_details)) {//receipt not exists
            $rid = Receipt::insertGetId(
                            [
                                'ReceiptNo' => '',
                                'ReceiptDate' => Carbon::now()->toDateTimeString(),
                                'CrossReferenceNo' => $saleOrder->SalesNo,
                                'Amount' => $saleOrder->GrossTotal,
                                'BranchID' => Auth::user()->BranchID,
                                'createdBy' => Auth::user()->id,
                            ]
            );
            Receipt::where('id', $rid)
                    ->update(['ReceiptNo' => "RCB" . Auth::user()->BranchID . str_pad($rid, 7, "0", STR_PAD_LEFT)]);

            if ($saleOrder->PaymentTypeID == 4) {//membership
                $PaymentReferenceNo = Client::getMemberCodeByClientID($saleOrder->ClientID);
            } else {
                $PaymentReferenceNo = '';
            }
            Receiptdetail::insert(
                    [
                        'ReceiptID' => $rid,
                        'Amount' => $saleOrder->GrossTotal,
                        'PaymentType' => $saleOrder->PaymentTypeID,
                        'PaymentReferenceNo' => $PaymentReferenceNo,
                    ]
            );
        }

        $receipt_details['ReceiptDate'] = Carbon::parse($receipt_details['ReceiptDate'])->format('d/m/Y');

        ///SALES ORDER DETAILS PART//
        $salesOrderDetails = Salesorderdetail::where('SalesOrderID', $sales_details['ID'])->get();
        $NetTotal = 0;
        foreach($salesOrderDetails as $salesOrderDetail){
            $NetTotal = $NetTotal + $salesOrderDetail->Total;
        }
        $sales_details['NetTotal'] = number_format((float) $NetTotal, 2, '.', '');  
        
        //VEHICLES PART
        $clientVehicles = Clientvehiclejoin::select('clientvehiclejoin.*', 'vehicles.RegistrationNo', 'clients.Name', 'clients.ContactNo')
                ->join('vehicles', 'vehicles.ID', '=', 'clientvehiclejoin.VehicleID')
                ->join('clients', 'clients.ID', '=', 'clientvehiclejoin.ClientID')
                ->where('clients.ID', $saleOrder->ClientID)
                ->get();

        //USERS PART//
        $users_list = User::get();
        $sales_advisors = User::where('roleID', 2)->get();
        $technicians = User::where('roleID', 3)->get();
        
        
        //SERVICE PART///
        $servicecategories = Servicecategory::whereIn('ID',[2,3])->get();
        
        
        $values['data'] = array(
            "sales_details" => $sales_details,
            "receipt_details" => $receipt_details,
            "salesOrderDetails" => $salesOrderDetails,
            "clientVehicles" => $clientVehicles,
            "users_list" => $users_list,
            "sales_advisors" => $sales_advisors,
            "technicians" => $technicians,
            "servicecategories" => $servicecategories,
        );
        
        //return view('sales.print', $values);
        
            $pdf = PDF::loadView('sales.print', $values)
                ->setPaper('A4', 'potrait');
            return $pdf->stream();
        return $pdf->download('Receipt - '.$receipt_details['ReceiptNo'].'.pdf');
        
    }

}
