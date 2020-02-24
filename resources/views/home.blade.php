@extends('layouts.app')

@section('content')
{{-- <img src="C:\Users\lenovo\Downloads\p.jpg"> --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper">
                {{-- Usrs list --}}
                <ul class="users">
                    @foreach ($users as $user )
                        <li class="user" id="{{ $user->id }}">
                            @if ($user->unread)
                            <span class="pending">{{ $user->unread }}</span>
                            @endif
                            <div class="media">
                                <div class="media-left">
                                    <img src="/uploads/avatars/{{$user->avatar}}" style="width:50px; height:50px; float:left; border-radius:50%; margin-right:5px;" alt ="" class="media-object">
                                </div> 
                                
                                <div class="media-body">
                                    <p class="name">{{ $user->name }}</p>
                                    {{-- <p class="email">{{ $user->email }}</p> --}}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Messages --}}        
        <div class="col-md-8" id="messages"> 
            
        </div>
</div> 

@endsection
