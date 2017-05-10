@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        welcome to home page of obts
     {{--  <seat cities= "{{ $cities }}" ></seat>        --}}
      <seat-display cities= "{{ $cities }}" inline-template>
          <div>
              {{-- @if (auth()->check())
              <div v-show="false">  @{{ guestUser = false }} </div>
              @endif --}}
              <div class="panel panel-default">
                {{-- <div class="panel-heading">Search Schedule</div> --}}
                <div class="panel-body">
                  <form>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="cityFrom"> From</label>
                        <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
                        <select v-model="selectedCityFrom" class="form-control" id="cityFrom">
                          <option disabled value="">Please select one</option>
                          <option v-for="city in cityList">
                            @{{ city.name }}
                          </option>                           
                        </select>
                      </div>
                    </div>  

                    <div class="col-md-3">  
                      <div class="form-group">
                        <label for="cityTo">To</label>  
                        <select v-model="selectedTo" class="form-control" id="cityTo">
                          <option v-if="!error" disabled value="">Please select one</option>
                          <option v-if="error" disabled value="">@{{ error }}</option>
                          <option v-for="city in cityToList">
                            @{{ city.arrival_city }}                            
                          </option>                          
                        </select>                         
                      </div>
                    </div>
                      
                    <div class="col-md-4">
                      <div class="form-group">  
                          <label for="startDate">Select Date</label> 
                          <div id="sandbox-container">
                            <div class="input-group date">
                              <input name="date" id="startDate" class="form-control" type="text" v-model="startDate" placeholder="select date">
                              <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </span>
                            </div>
                          </div>
                      </div>
                    </div>  

                    <div class="col-md-2">
                      <button v-on:click.prevent="searchBus" class="btn btn-primary btn-search form-control" :disabled="isDisabled">Search &nbsp;
                        <i class="fa fa-search"></i>
                      </button>
                    </div>  
                  </form> 
                </div>
              </div>
                  
              <div v-show="isBusAvailable" class="panel panel-info">
                  <div class="panel-heading">Schedule Details</div>
                  <table class="table table-striped task-table">
                     <!-- Table Headings -->
                      <thead>
                          <th>SL No.</th>                                
                          <th>Dept. Time</th>                                
                          <th>Arr. Time</th>                                
                          <th>Type</th>                                
                          <th>Available Seats</th>                                
                          <th>Fare</th>                                
                          <th>View</th>
                          <th>&nbsp;</th>
                      </thead>

                      <!-- Table Body -->
                      <tbody>
                          <tr v-for="(bus, index) in buses">
                              <td class="table-text">
                                <div> @{{ index + 1 }} </div>
                              </td>

                              <td class="table-text">
                                <div> @{{ bus.departure_time }} </div>
                              </td>
                              <td class="table-text">
                                <div> @{{ bus.arrival_time }} </div>
                              </td>
                              <td class="table-text">
                                <div> @{{ bus.bus_type }} </div>
                              </td>
                              <td class="table-text">
                                <div> @{{ bus.available_seats }} </div>
                              </td>
                              <td class="table-text">
                                <div> @{{ bus.fare }} </div>
                              </td>
                              <td class="table-text">
                                <div> 
                                  <button v-on:click.prevent="viewSeats(bus.schedule_id, bus.bus_id, bus.fare)" class="btn btn-success">View</button> 
                                </div>
                              </td>
                          </tr>                                                            
                      </tbody>
                  </table>
                  <div v-show="busError" class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                      @{{ busError }}
                  </div>
              </div>
              <div class="loading"><i v-show="loading" class="fa fa-spinner fa-pulse fa-3x text-primary"></i></div>
              <div class="col-sm-6 col-sm-offset-2">
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
                        <button v-on:click.prevent="makePayment" class="btn btn-primary">Pay Now</button>
                      </div>  
                  </div>
              </div>                    

              <!-- Modal -->
              <div id="modal" class="modal" v-if="modal">
                  <div class="modal-content">
                      <div class="circle">
                          <span class="close" data-toggle="tooltip" data-placement="top" title="Press esc to close" @click="close">x</span>                  
                      </div>    
                      
                      <div class="alert alert-danger" role="alert" v-if="seatError">
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                          @{{ seatError }}
                      </div>
                      <div class="row">
                        <div id="seat-layout" class="col-sm-6">
                          <div class="row">
                              <div class="col-xs-offset-8">
                                <button :disabled="true">Driver Seat</button>
                              </div>              
                              <button
                                class="col-xs-2"
                                v-bind:class="{ 
                                  active: seat.checked, 
                                  booked: seat.status=='booked'? true : false, 
                                  confirmed: seat.status=='confirmed'? true : false, 
                                  empty: seat.status=='n/a'? true : false,             
                                  'col-xs-offset-2': emptySpace(seat.seat_no) }"
                                v-for="seat in seatList"          
                                @click="toggle(seat)"           
                                :disabled="isDisabledSeatSelection(seat.status)"                   
                              >               
                                @{{ seat.seat_no }} - @{{ seat.status }}                                 
                              </button> 
                          </div>
                          <div v-show="false" class="alert" 
                               v-bind:class="{ 
                                  'alert-info': seatStatus=='available'? true : false, 
                                  'alert-warning': seatStatus=='booked'? true : false, 
                                  'alert-danger': seatStatus=='confirmed'? true : false 
                               }" 
                               id="status-alert"
                          >
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>

                              <strong>@{{ seatNo }} </strong> has been <strong>@{{ seatStatus }} </strong>
                          </div>

                        </div>
                        <div class="col-sm-6">                              
                          <div v-show="isSeatSelected" class="panel panel-primary row">
                            <div class="panel-heading">Selected Seat Info</div>
                            <table class="table table-striped">
                              <thead>
                                <th>Sl.#</th>
                                <th>Seat Selected</th>
                                <th>Price</th>
                                <th>Remove</th>
                                <!-- <th>&nbsp;</th> -->
                              </thead>
                              <tbody>
                                <tr v-for="(seat, index) in selectedSeat">
                                  <td class="table-text">
                                    <div> @{{ index + 1 }} </div>
                                  </td>
                                  <td class="table-text">
                                    <div> @{{ seat.seat_no }} </div>
                                  </td>
                                  <td class="table-text text-primary">
                                     <div> @{{ seat.fare }} </div>
                                  </td>
                                  <td class="table-text">
                                     <div>
                                        <button @click.prevent="removeSeat(seat.seat_no, seat)" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                         <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                        </button>
                                      </div>
                                    </td>                                          
                                </tr>                                      
                                @{{ totalFareForSelectedSeats }}                                       
                              </tbody>
                            </table> 
                            {{-- <span class="total"> Total Amount @{{ totalFare }} </span> --}}
                            <div class="panel-footer total"><strong>Total Amount:</strong> @{{ totalFare }} </div>
                          </div>
                          
                          <div class="row">
                              @if (auth()->check())
                                @include('includes.user')
                               {{--  <div v-show="false">  @{{ guestUser = false }} --}}
                              @else
                                @include('includes.guest')
                              @endif  
                          </div>
                          {{-- <button v-on:click.prevent="seatBooking()" class="btn btn-primary">Continue
                          </button> --}}
                        </div>
                      </div>                           
                  </div>          
              </div> 
            </div>  
    
      </seat-display>       
    </div>
</div>
@endsection
@section('scripts')
   {{--  <script> 
            // Briding with broadcaster
            // import Echo from "laravel-echo"
            // window.Echo = new Echo({
            //     broadcaster: 'pusher',
            //     key: '98b9f6229a65f62bb1da'
            // });

            // Subscribing & listening
           /* Echo.private('mychannel_one')
            .listen('UserRegisteredEvent', function(e) {
                console.log(e.user);
            });*/
            //var userId = 1;
           // Echo.private('App.User.' + userId)
            // Echo.private('App.User.1')
            //     .notification((notification) => {
            //         console.log(notification.type);
            //         console.log(notification.name);
            //         console.log(notification.email);
            // });
          // Echo.channel('mychannel.1')
          //     .listen('SeatStatusUpdatedEvent', function(e) {
          //         console.log(e.seat, e.scheduleId);
          //     });  
            
        </script>  --}}
@endsection  
