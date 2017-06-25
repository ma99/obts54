<div v-show="isSeatBooked" class="panel panel-info row">
  <div class="panel-heading">Booking Information</div>
    <p>Dear <strong> @{{ bookedSeatInfo.name}} </strong>! Your Booking Request has been completed. </p>
  <div class="panel-body">                            
          <div class="col-sm-8">
            Booking Ref: <strong>@{{ bookedSeatInfo.booking_id}}</strong>
          </div>
          <div class="col-sm-8">
            Seat No: <strong>@{{ bookedSeatInfo.seat_no}}</strong>
          </div>
          <div class="col-sm-8">
            Date: <strong>@{{ bookedSeatInfo.date}}</strong>
          </div>
  </div>
  <div class="panel-footer">
    

    {{-- <button href="{{ route('payment', ['booking' => $bookingId]) }}" type="button" class="btn btn-primary">Pay Now</button> --}}
    {{-- <button href="{{ url('pay/'.$bookingId) }}" type="button" class="btn btn-primary">Pay Now</button> --}}
    <a :href="'/pay/' + bookedSeatInfo.booking_id" type="button" class="btn btn-primary">Pay Now</a>
  </div>  
</div>