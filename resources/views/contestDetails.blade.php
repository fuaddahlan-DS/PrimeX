@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
       <!-- <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>-->
        <div><a href="{{url('home')}}">Home</a> > <a href="{{url('contest-details')}}/{{$contest->id}}">Details</a></div><br>
    </div>
    <div class="row">
        <?php 
            $video = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width=\"100%\" height=\"500\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>",$contest->youtubeLink);
            echo $video;
        ?>
        <!-- <h1 class="text-center">{{$contest->filmTitle}}</h1> -->
    </div>
    <br>
    <div class="row">
        <hr style="background-color: grey; height: 1px; border: 0;">
        <h1 class="text-center">Short Film's Details</h1>
        <hr style="background-color: grey; height: 1px; border: 0;">
        <div class="col-sm-12 col-md-6">
            <table style="font-size: 150%;">
                <tr>
                    <td class="text-center" colspan=2><img width="75%" src="{{url($contest->filmPosterPath)}}" alt="poster" /><br>&nbsp;<br> </td>
                </tr>
                <tr>
                    <td colspan=2 style="font-weight: bold;">Synopsis: </td>
                </tr>
                <tr>
                    <td colspan=2>{{$contest->filmSynopsis}} </td>
                </tr>
                <tr><td colspan=2>&nbsp;</td></tr>
                <tr>
                    <td colspan=2 style="font-weight: bold;">Fun Facts: </td>
                </tr>
                <tr>
                    <td colspan=2>
                    @php
                       $facts = (explode(";;",$contest->filmFunFact));
                       $i=1;
                    @endphp
                    @foreach($facts as $fact)
                    {{$i}}. {{$fact}}<br>
                    @php($i++)
                    @endforeach

                    </td>
                </tr>      
            </table>
        </div>

        <div class="col-sm-12 col-md-6">
            <table style="font-size: 150%;">
                <tr>
                    <td style="font-weight: bold;">Title </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmTitle}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">File Format </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmFileFormat}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Language </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmLanguage}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Duration </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmDuration}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Director </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmDirector}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Producer  </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmProducer}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Screenplay Writter </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmScreenPlayWritter}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Script Writter </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmScriptWritter}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Cinematographer </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmCinematographer}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Production Designer </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmProductionDesigner}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Sound Designer </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmSoundDesigner}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Editor </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmEditor}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Main Casts </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmMainCasts}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Casts </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmCasts}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Others </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->filmOthers}}</td>
                </tr>  
                <tr>
                    <td colspan=2 style="font-weight: bold;">Youtube URL: </td>
                </tr>
                <tr>
                    <td colspan=2><a target="_blank" href="{{$contest->youtubeLink}}">{{$contest->youtubeLink}}</a></td>
                </tr>     
            </table>
        </div>

    </div>
    <br><br><br>
    <div class="row">
        <hr style="background-color: grey; height: 1px; border: 0;">
        <h1 class="text-center">Participant's Details</h1>
        <hr style="background-color: grey; height: 1px; border: 0;">
        <div class="col-sm-12 col-md-6">
            <table style="font-size: 150%;">
                <tr>
                    <td style="font-weight: bold;">Full Name </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->fullName}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">IC Number </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->icNumber}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Contact Person </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->contactPerson}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Mobile Number </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->mobileNumber}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">House Number </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->houseNumber}}</td>
                </tr>
            </table>
        </div>

        <div class="col-sm-12 col-md-6">
            <table style="font-size: 150%;">
                <tr>
                    <td style="font-weight: bold;">Email Address </td><td>&nbsp;&nbsp;&nbsp;: {{$contest->email}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Registered at </td><td>&nbsp;&nbsp;&nbsp;: {{date('M j, Y', strtotime($contest->created_at))}}</td>
                </tr>
                <tr>
                    <td colspan=2 style="font-weight: bold;">Address: </td>
                </tr>
                <tr>
                    <td colspan=2>{{$contest->address}}</td>
                </tr>
            </table>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>



</div>
@endsection
