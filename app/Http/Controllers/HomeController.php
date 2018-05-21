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
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    private function isValidRole(){
        if(!in_array(Auth::user()->roleID, array(1))){
            return false;
        }
        return true;
    }

    public function index()
    {
        if(!$this->isValidRole())
            return redirect('/');

        // if(request()->has('term')){
        //     $searchTerm = request()->input('term');
        //     $contests = Contests::where('filmTitle', 'like', '%' . $searchTerm . '%')->orWhere('fullName', 'like', '%' . $searchTerm . '%')->orderBy('created_at', 'desc')->paginate(9);
        // }
        // else if(request()->has('filter')){
        //     $contests = Contests::orderBy('votes', 'desc')->where('status',request()->input('filter'))->paginate(12);
        // }
        // else{
        //     $contests = Contests::orderBy('created_at', 'desc')->paginate(9);
        // }
        return view('home');
    }

    public function contestDetails($id)
    {
        if(!$this->isValidRole())
            return redirect('/');

        $contest = Contests::find($id);
        return view('contestDetails', compact('contest'));
    }

    public function shortlist(Request $request)
    {
        if(!$this->isValidRole())
            return redirect('/');

        $data = $request->all();
        try{
            $contest = Contests::where('id', $data['shorlistID'])->first();
            $contest->status = 'shortlisted';
            $contest->save();

            Session::flash('success', $contest->filmTitle.' has been successfully shortlisted.');
        }
        catch (Exception $e) {
            Session::flash('error', 'Failed to shortlist. Error message: '.$e->getMessage());
        }
        return redirect(url('home'));
    }

    public function export()
    {
        if(!$this->isValidRole())
            return redirect('/');

        if(request()->has('type')){
            
            if(request()->input('type') == 'top10')
            {
                $fileName = "The BMW Shorties 2017 Top 10 - ".date('d-m-Y');
                $contests = Contests::orderBy('votes', 'desc')->where('status','shortlisted')->paginate(10);
            }   
            elseif(request()->input('type') == 'all'){
                 $fileName = "The BMW Shorties 2017 All - ".date('d-m-Y');
                 $contests = Contests::orderBy('created_at', 'desc')->get();
            }else{
                return redirect('/');
            }

            // output headers so that the file is downloaded rather than displayed
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename='.$fileName.'.csv');

            // create a file pointer connected to the output stream
            $output = fopen('php://output', 'w');

            // output the column headings
            fputcsv($output, array('Full Name', 'I.C. Number', 'Contact Person', 'Tel ( House )', 'Tel ( Mobile )', 'Email', 'Address', 'Short Film Title', 'Movie File Format', 'YouTube URL', 'Language Medium', 'Duration', 'Synopsis', 'Fun Facts', 'Director', 'Producer', 'Screenplay Writer', 'Script Writer', 'Cinematographer', 'Production Designer', 'Sound Designer', 'Editor', 'Main Casts', 'Casts', 'Others', 'Submission Date', 'Number of Votes'));

            foreach ($contests as $contest) {
                fputcsv($output, array($contest->fullName, "'".$contest->icNumber."'", $contest->contactPerson, "'".$contest->houseNumber."'", "'".$contest->mobileNumber."'", $contest->email, $contest->address, $contest->filmTitle, $contest->filmFileFormat, $contest->youtubeLink, $contest->filmLanguage, $contest->filmDuration, $contest->filmSynopsis, $contest->filmFunFact, $contest->filmDirector, $contest->filmProducer, $contest->filmScreenPlayWritter, $contest->filmScriptWritter, $contest->filmCinematographer, $contest->filmProductionDesigner, $contest->filmSoundDesigner, $contest->filmEditor, $contest->filmMainCasts, $contest->filmCasts, $contest->filmOthers, $contest->created_at, $contest->votes));
            }
            
        }
        //return redirect('/');
    }
}
