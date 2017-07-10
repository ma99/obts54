@extends('layouts.app')

@section('content')
	<div class="row">
	    <div class="col-md-8 col-md-offset-2">
	    <div class="panel panel-default">
	      <div class="panel-heading">Payment Cancelled</div>
	      <div class="panel body">
			<h3>Payment Cancelled</h3>
			{{-- <h2> {{ $validation_message }} </h2> --}}
			
			<div id="payment">				
				{{-- <form action="{{ url('/pay/'.$bookingId) }}"> --}}
				<form action="{{ url('/pay/') }}">
					 {{ csrf_field() }}
					 <button type="submit" class="btn btn-info">
			            Try Again
			         </button>
					{{-- <a href= "{{ url('/cancel/'.$bookingId) }}" type="button" value="Cancel" class="btn btn-warning">Cancell</a> --}}
				</form>
			
				{{-- <form action="{{ url('/cancel/'.$bookingId) }}"> --}}
				<form action="{{ url('/cancel/') }}">
					 {{ csrf_field() }}
					 <button type="submit" class="btn btn-warning">
			            Cancel
			         </button>		
				</form>
			</div>
			
		  </div>
	    </div>
	  </div>
	</div>   

@endsection