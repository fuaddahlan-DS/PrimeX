<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Member extends Model
{   
    public $timestamps = false;
    
    public static function TopupCredit($data) {
        try {
            

            $member = Member::select('members.CreditBalance', 'members.ID AS MemberID')
                    ->where('members.Code', $data['memberCode'])
                    ->first();

            

            $id = Salesorder::insertGetId(
                    [
                        'GrossTotal' => $data['amount'],
                        'Paid' => $data['amount'],
                        'Due' => 0,
                        'VehicleID' => 0,
                        'PaymentTypeID' => $data['PaymentTypeID'],
                        'ClientID' => $data['ClientID'],
                        'GSTRate' => 0,
                        'BranchID' => Auth::user()->BranchID,
                        'CreatedBy' => Auth::user()->id,
                        'ClosedBy' => Auth::user()->id,
                    ]
            );

            $salesCode = 'SO' . Auth::user()->BranchID . str_pad($id, 9, "0", STR_PAD_LEFT);

            Salesorder::where('id', $id)
                    ->update(['SalesNo' => $salesCode]);

            //$totalAmount = (float)$data['amount']+$member->CreditBalance;
            $totalAmount = (float) $data['amount'] + (float) $member->CreditBalance;

            $id2 = Membercreditledger::insertGetId(
                    [
                        'MemberID' => $member->MemberID,
                        'SalesOrderID' => $id,
                        'CreditUsed' => 0.0000,
                        'RunningBalance' => $data['amount'],
                    ]
            );

            Member::where('members.Code', $data['memberCode'])
                    ->update(['members.CreditBalance' => $totalAmount]);



            $result = (object) array(
                'status' => true,
                'message' => 'Topup successfully added!',
                'data' => array('amount' => number_format((float) $totalAmount, 2, '.', ''), 'salesCode' => $salesCode, 'salesID' => $id, 'memberID' => $data['ClientID']),
            );
        } catch (Exception $ex) {
            $result = (object) array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
        return $result;
    }
}
