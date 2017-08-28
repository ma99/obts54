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
              <div v-show="!isSeatBooked" class="panel panel-default">
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
                          <option v-if="!error.city" disabled value="">Please select one</option>
                          <option v-if="error.city" disabled value="">@{{ error.city }}</option>
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
              {{-- SCHEDULE --}}    
              <div v-show="showSchedule" class="panel panel-info">
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
              <loader :show="loading">
                {{-- <div class="loading"><i v-show="loading" class="fa fa-spinner fa-pulse fa-3x text-primary"></i></div> --}}
              </loader>
              <div class="col-sm-6 col-sm-offset-2">
                  {{-- Booked Seat Info --}}
                  @include('includes.booking')
              </div>                    

              <!-- Modal -->
              <modal v-show="modal" @close="close()">                  
                <div class="row">
                  <div id="seat-layout" class="col-sm-6" v-show="!seatError">
                    <div class="panel panel-default">
                      <div class="panel-heading">Seat Plan</div>
                      <div class="row panel-body">
                        <div class="seat-plan-body">
                          <div class="col-xs-offset-8">
                            <button :disabled="true">Driver Seat</button>
                          </div>              
                          <button
                            class="col-xs-2"
                            v-bind:class="{ 
                              'is-active': seat.checked, 
                              booked: seat.status=='booked'? true : false,
                              buying: isSeatBuying(seat.status),
                              {{-- 'fa fa-refresh fa-spin': seat.status=='buying'? true : false,  --}}
                              confirmed: seat.status=='confirmed'? true : false, 
                              empty: seat.status=='n/a'? true : false,             
                              'col-xs-offset-2': emptySpace(index, seat.seat_no) }"
                            v-for="(seat, index) in seatList"          
                            @click="toggle(seat)"           
                            :disabled="isDisabledSeatSelection(seat.status)"                   
                          >               
                            {{-- @{{ seat.seat_no }} - @{{ seat.status }} --}}
                            <span v-show="!isSeatBuying(seat.status)" > @{{ seat.seat_no }} </span>
                            <span v-show="isSeatBuying(seat.status)" class="fa fa-refresh fa-spin text-danger"></span>  
                            {{-- <i v-show="seat.status=='buying' class="fa fa-refresh fa-spin text-danger"></i>   --}}
                          </button> 
                        </div>
                      </div>
                      {{-- panel-footer --}}
                      {{-- <div class="panel-footer">                     --}}
                      <div class="panel-footer">
                        <show-alert :show="showAlert" :type="alertType" @cancel="showAlert=false"> 
                        <!-- altert type can be info/warning/danger -->
                          <strong>@{{ seatNo }} </strong> has been <strong>@{{ seatStatus }} </strong>
                        </show-alert>
                      </div>  
                      
                     {{--  <div v-show="false" class="panel-footer" 
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
                      </div>   --}}                          
                    </div>
                    
                    {{-- <div class="panel panel-success">
                      <div class="panel-heading">Pickup & Dropping</div>
                      <div class="panel-body">
                        @include('includes.stops')
                      </div>
                    </div>   --}}

                  </div>
                  
                  <!-- Seat Plan Not Available -->
                  <div class="col-sm-6" v-show="seatError">
                    <div class="alert alert-warning seat-error" role="alert">
                      <h3> @{{ seatError }}</h3>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <!-- Selected Seat with Price  -->
                    {{-- <div v-show="isSeatSelected" class="panel panel-primary row"> --}}
                    <div v-show="isSeatSelected" class="panel panel-primary">
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
                    
                    <!-- Pickup & Dropping Selection -->
                    <div class="panel panel-success">
                      <div class="panel-heading">Pickup & Dropping</div>
                      <div class="panel-body">
                        @include('includes.stops')
                      </div>
                    </div>  

                    <!-- User/ Guest Info Entry -->
                    {{-- <div class="row"> --}}                        
                        @if (auth()->check())
                          @if (auth()->user()->isNormalUser())
                            @include('includes.user')
                          @else
                            @include('includes.guest')
                          @endif                          
                        @else
                          @include('includes.guest')
                        @endif       
                    {{-- </div> --}}
                    {{-- <button v-on:click.prevent="seatBooking()" class="btn btn-primary">Continue
                    </button> --}}

                  </div>
                </div>    
              </modal> 
            </div>  
    
      </seat-display>       
    </div>
</div>
@endsection