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

		<h1> SUCCESS </h1>
		@if (isset($request))
			<ul>
				<li> Status: {{ $request->status }} </li>
				<li> Transaction Ref: {{ $request->tran_id }} </li>
				<li>  Validation ID: {{ $request->val_id }}</li>				
				<li> Amount: {{ $request->store_amount }}</li>
				<li> Amount Including Charge: {{ $request->amount }}</li>
			</ul>
		@endif	
	</div>
@endsection