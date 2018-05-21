<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

    public static function getClientDetailsByID($id, $param = ['*']) {
        $result = Client::select($param)->whereId($id)->first();
        return $result;
    }

    public static function getMemberCodeByClientID($id) {
        $returnval = '';

        $members = Client::select('members.Code')
                ->leftJoin('members', 'clients.ID', '=', 'members.ClientID')
                ->where('clients.ID', '=', $id)
                ->first();

        if ($members->Code == '') {
            $member = Client::select('members.Code')
                    ->leftJoin('salesorder', 'salesorder.ClientID', '=', 'clients.ID')
                    ->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
                    ->leftJoin('members', 'members.ID', '=', 'membercreditledger.MemberID')
                    ->where('clients.ID', '=', $id)
                    ->first();

            $returnval = $member->Code;
        } else {
            $returnval = $members->Code;
        }


        return $returnval;
    }
    
    public static function getMemberByClientID($id) {
        $returnval = '';

        $members = Client::select('members.*')
                ->leftJoin('members', 'clients.ID', '=', 'members.ClientID')
                ->where('clients.ID', '=', $id)
                ->first();

        if ($members->Code == '') {
            $member = Client::select('members.*')
                    ->leftJoin('salesorder', 'salesorder.ClientID', '=', 'clients.ID')
                    ->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
                    ->leftJoin('members', 'members.ID', '=', 'membercreditledger.MemberID')
                    ->where('clients.ID', '=', $id)
                    ->first();

            $returnval = $member;
        } else {
            $returnval = $members;
        }


        return $returnval;
    }

    public static function getMemberBalanceByClientID($id) {
        $returnval = '';

        $members = Client::select('members.CreditBalance')
                ->leftJoin('members', 'clients.ID', '=', 'members.ClientID')
                ->where('clients.ID', '=', $id)
                ->first();

        if ($members->CreditBalance == '') {
            $member = Client::select('members.CreditBalance')
                    ->leftJoin('salesorder', 'salesorder.ClientID', '=', 'clients.ID')
                    ->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
                    ->leftJoin('members', 'members.ID', '=', 'membercreditledger.MemberID')
                    ->where('clients.ID', '=', $id)
                    ->first();

            $returnval = $member->CreditBalance;
        } else {
            $returnval = $members->CreditBalance;
        }


        return number_format((float) $returnval, 2, '.', '');
    }

    public static function getClientDetailsByMemberID($id, $param = ['*']) {
        $result = Member::select($param)->whereId($id)
                ->join('clients', 'members.clientID', '=', 'clients.ID')
                ->first();
        return $result;
    }

    

}
