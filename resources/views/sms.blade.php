@extends('template') @section('title'){{$sms->title}}@stop @section('icon'){{asset('favicon.ico')}}@stop @section('main') <div class="row"> <div class="col-2"> <ul class="box"> <li class="title">&infintie; SMS Properties &infintie;</li> <li><em>Views &xrArr; </em> {{$sms->views}}</li> <li><em>Length &xrArr; </em> {{strlen($sms->body)}}</li> </ul> <div class="box"> <h3 class="title">&boxbox; Advertisements &boxbox;</h3> Write your google ads </div> </div> <div class="col-10"> <div class="row"> <div class="col-8"> <blockquote class="quote">{{$sms->body}}</blockquote> </div> <div class="col-4"> Advertisement goes here. </div> </div> </div> </div> @stop 