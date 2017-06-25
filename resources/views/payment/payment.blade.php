@extends('layouts.app')

@section('content')
	<div class="panel body">
		{{-- // Common setup for API credentials --}}
		{{-- <form id="payment_gw" name="payment_gw" method="POST" action="https://sandbox.sslcommerz.com/gwprocess/v3/process.php"> --}}
		<form id="payment_gw" name="payment_gw" method="POST" action="{{ $gwUrl }}">
			<input type="hidden" name="total_amount" value="1150.00" />
			<input type="hidden" name="store_id" value="testbox" />
			{{-- <input type="hidden" name="tran_id" value="594e9719c2e59" /> --}}
			<input type="hidden" name="tran_id" value="{{ $bookingId }}" />
			{{-- <input type="hidden" name="success_url" value="{{ route('success', ['booking' => $bookingId]) }}" /> --}}
			<input type="hidden" name="success_url" value="{{ route('success') }}" />
			<input type="hidden" name="fail_url" value="{{ route('fail') }}" />
			<input type="hidden" name="cancel_url" value="{{ route('cancel') }}" />
			<input type="hidden" name="version" value="3.00" />	

			<!-- Customer Information !-->
			<input type="hidden" name="cus_name" value="ABC XYZ">
			<input type="hidden" name="cus_email" value="abc.xyz@mail.com">	
			
			<!-- SUBMIT REQUEST  !-->
			<input type="submit" name="submit" value="Pay Now" />
		</form>
	</div>
@endsection