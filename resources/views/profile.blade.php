@extends('layouts.app')

@section('content')      
<div class="container">
    <div class="card">
        <div class="card-header">
            Profile
        </div>    
        
        
        
        <div class="card-body">
            
            <form enctype="multipart/form-data" action="/profile" method="POST" >


                <div class="row">
                    <div class="col">
                        <img src="/uploads/avatars/{{$user->avatar}}" style="width:250px; height:250px; float:left; border-radius:50%; margin-right:25px;">
                    </div>
                    <div class="col">
                        <h2>{{ $user->name}}'s Profile</h2>
           
                    </div>
                    <div class="col">
                      <h6>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp {{ $user->name}} is a valuable user of babble.</h6> 
                    </div>
                  </div>
                
                <label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Update Profile Image</label>
                <input type="file" name="avatar">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="pull-right btn btn-sm btn-primary">
            
            </form>
          
              

            
        </div>
    </div>
</div> 
</body> 
</html>

@endsection
