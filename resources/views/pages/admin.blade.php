@extends('layouts.app')

@section('content')

@include ('includes.nav')

<div class="container">

    <div class="row">
        welcome to home page of obts
        <router-view></router-view>
    </div>
</div>

@endsection

@section('scripts')   
@endsection  
