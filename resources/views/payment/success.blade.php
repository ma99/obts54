@extends('layouts.app')

@section('content')
	<div class="panel body">
		@if (isset($payment))
			<ul>
				<li> Ref: {{ $payment->booking_id }} </li>
				<li> Transaction Ref: {{ $payment->transaction_id }} </li>
				<li> Amount: {{ $payment->amount }} </li>
				<li>  Status: {{ $payment->status }} </li>
			</ul>
		@endif	
	</div>
@endsection