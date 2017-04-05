@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        welcome to home page of obts
      <seat cities= "{{ $cities }}" ></seat>       
    </div>
</div>
@endsection
