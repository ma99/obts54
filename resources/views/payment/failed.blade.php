@extends('layouts.app')

@section('content')
<div class="panel body">
	<h3>Payment failed</h3>
	<h2> {{ $validation_message }} </h2>
	<form action="{{ url('/pay/'.$bookingId) }}">
		 {{ csrf_field() }}
		 <button type="submit" class="btn btn-info">
                <i class="fa fa-btn btn-info"></i>Try Again
         </button>
		<a href= "{{ url('/cancel/'.$bookingId) }}" type="button" value="Cancel" class="btn btn-warning">Cancel</a>
	</form>
</div>
@endsection