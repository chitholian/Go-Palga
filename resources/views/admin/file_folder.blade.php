@extends('template') @section('title'){{$folder->title}} @stop @section('main') <div class="row"> <div class="col-6"> <div class="box"> <h3 class="title"><a class="btn round" href="{{asset('backend/edit/folder/'.$folder->id)}}">&swArr;</a> <a class="btn round" href="{{asset('backend/add/category/F/'.$folder->id)}}">+</a> Categories</h3> <p><strong>Tags : </strong>{{$folder->tags}}</p> <p><strong>Description : </strong>{{$folder->description}}</p> <ul>@foreach($categories as $category) <li> <h3 class="section"> <a class="btn round" href="{{asset('backend/edit/category/'.$category->id)}}">&swArr;</a> <a class="btn round" href="{{asset('backend/add/folder/'.$category->id)}}">+</a> {{$category->title}} &iff; {{$category->id}}</h3> <ul> @foreach($category->folders as $child) <li><img class="icon-sm" src="{{asset($child->icon->path)}}"/> <a href="{{asset('backend/folder/F/'.$child->id)}}">{{$child->title}}</a> &harr; {{$child->id}}</li> @endforeach </ul> </li> @endforeach</ul> </div> </div> <div class="col-6"> <div class="box"> <h3 class="title"><img src="{{asset($folder->icon->path)}}"/> <a class="btn round" href="{{asset('backend/add/file/'.$folder->id)}}">&uArr;</a> Files </h3> <ul> @foreach($files as $file) <li><a onclick="return deleteFile('{{$file->id}}')" href="#" class="btn round bg-dan">&times;</a> <img src="{{asset($file->thumb->path)}}" class="icon-sm"/> <a href="{{asset('backend/file/'.$file->id)}}">{{$file->title}}</a></li> @endforeach </ul> </div> </div> </div> <script> function deleteFile(id) { if (confirm('Are you sure to delete ?')) { var xhr = new XMLHttpRequest(); xhr.open('DELETE', '{{asset('backend/file')}}/' + id); xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); xhr.setRequestHeader("X-CSRF-TOKEN", "{{csrf_token()}}"); xhr.onreadystatechange = function () { if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) { location.reload(); } else document.write(xhr.responseText) }; xhr.send('_mthod=DELETE') } return false; }</script> @stop