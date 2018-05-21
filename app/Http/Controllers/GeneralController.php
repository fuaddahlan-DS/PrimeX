<?php
/**********************************************
*                BMW Shorties                 *
* Back-End Developer  :  rudiliucs1@gmail.com *
*         Copyright © 2017 Rudi Liu           *
*       https://github.com/rudiliu            *
***********************************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contests;
use Session;
use Mail;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    function sentEmailNotification($data, $template, $subject, $toEmail, $toName){
        try {
            $data['fromEmail'] = 'admin@bmwshorties.com.my';
            $data['fromName'] = 'The BMW Shorties';
            $data['subject'] =  $subject;
            $data['toEmail'] = $toEmail;
            $data['toName'] = $toName;

            $result = Mail::send($template, ['data' => $data], function ($message) use ($data){
                $message->from($data['fromEmail'], $data['fromName']);
                $message->to($data['toEmail'], $data['toName']);
                $message->replyTo($data['fromEmail'], $data['fromName']);
                $message->subject($data['subject']);
                $message->getSwiftMessage();
            });
        } catch (Exception $e) {
            if( count(Mail::failures()) > 0 ) {

               $result = "There was one or more failures. They were: <br />";

               foreach(Mail::failures as $email_address) {
                   $result .=  " - $email_address";
                }

            } else {
                $result =  true;
            }
        }


        return $result;
    }


}
