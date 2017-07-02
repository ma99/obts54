@extends('layouts.app')

@section('content')
	<div class="panel body">
		{{-- @if (isset($payment))
			<ul>
				<li> Ref: {{ $payment->booking_id }} </li>
				<li> Transaction Ref: {{ $payment->transaction_id }} </li>
				<li> Amount: {{ $payment->amount }} </li>
				<li>  Status: {{ $payment->status }} </li>
			</ul>
		@endif	 --}}

		@if ($payment_status == 'success')
			<h1> {{ $payment_status }}  </h1>
			<ul>
				<li> Status: {{ $status }} </li>
				<li> Transaction Ref: {{ $tran_id }} </li>
				<li>  Validation ID: {{ $val_id }}</li>				
				<li> Amount: {{ $store_amount }}</li>
				<li> Amount Including Charge: {{ $amount }}</li>
			</ul>
		@else
			<p> {{ $validation_message }}  </p>			
		@endif	
	</div>
@endsection