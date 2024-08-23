@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Users</div>

                
                    <example-component />
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Post</div>

                
                <post-component />
              
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Comments</div>

             
                <comment-component />
              
            </div>
        </div>
    </div>
</div>
@endsection
