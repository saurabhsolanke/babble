@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
          SETTINGS
        </div>
        <div class="card-body">
            <form method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Upload Avatar</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="avatar_file " id="inputGroupFile01">
                      <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    </div>
                </div><br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div> 

@endsection
