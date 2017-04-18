<template>
    <!-- <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default"> -->
                <div>
                    <form>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="cityFrom"> From</label>
                          <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
                          <select v-model="selected" class="form-control" id="cityFrom">
                            <option disabled value="">Please select one</option>
                            <option v-for="city in cityList">
                              {{ city.name }}
                            </option>                           
                          </select>
                        </div>
                      </div>  

                      <div class="col-md-3">  
                        <div class="form-group">
                          <label for="cityTo">To</label>  
                          <select v-model="selectedTo" class="form-control" id="cityTo">
                            <option v-if="!error" disabled value="">Please select one</option>
                            <option v-if="error" disabled value="">{{ error }}</option>
                            <!-- <span v-if="error"> {{ error }} </span> -->
                            <option v-for="city in cityToList">
                              {{ city.arrival_city }}                            
                            </option>                          
                          </select>                         
                        </div>
                      </div>

                        <!-- <span>Selected: {{ selected }} </span>                       
                        <input v-model="message" placeholder="edit me">
                        <p>Message is: {{ message }} </p> -->
                        <!-- <input type="text" id="startDate" v-model="startDate"> -->
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
                        <button v-on:click.prevent="searchBus" class="btn btn-primary btn-search form-control">Search &nbsp;
                          <i class="fa fa-search"></i>
                        </button>
                       <!--  <button v-on:click.prevent="viewSeats(1,2)" class="btn btn-primary btn-search form-control">Search</button> -->
                      </div>                     
                    
                    </form>                    

                    <div class="panel-body">
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
                               <!--  @foreach ($tasks as $task) -->
                                    <tr v-for="(bus, index) in buses">
                                    
                                        <!-- slNo += 1 -->
                                        <!-- {{ increment }} -->
                                        <!-- {{ showslNo }} -->
                                        <td class="table-text">
                                          <div> {{ index + 1 }} </div>
                                        </td>

                                        <td class="table-text">
                                          <div> {{ bus.departure_time }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> {{ bus.arrival_time }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> {{ bus.bus_type }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> {{ bus.available_seats }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> {{ bus.fare }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> 
                                            <button v-on:click.prevent="viewSeats(bus.schedule_id, bus.bus_id)" class="btn btn-success">View</button> 
                                          </div>
                                        </td>
                                    </tr>
                                    <tr class="bg-danger" v-show="busError"> 
                                      <div> {{ busError }} </div> 
                                    </tr>
                                    <!-- <span class="bg-danger" v-show="busError"> {{ busError }} </span> -->
                                <!-- @endforeach -->
                            </tbody>
                        </table>
                    </div>
                    <div class="loading"><i v-show="loading" class="fa fa-spinner fa-pulse fa-3x text-primary"></i></div>

                    <!-- Modal -->
                    <div id="modal" class="modal" v-if="modal">
                        <div class="modal-content">
                            <div class="circle">
                                <span class="close" data-toggle="tooltip" data-placement="top" title="Press esc to close" @click="close">x</span>                  
                            </div>    
                            
                            <div class="alert alert-danger" role="alert" v-if="seatError">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                {{ seatError }}
                            </div>
                            <div class="row">
                                <div class="col-xs-offset-9">
                                  <button :disabled="true">Driver Seat</button>
                                </div>              
                                <button 
                                  class="col-xs-2"
                                  v-bind:class="{ 
                                  active : seat.checked, 
                                  booked: seat.status=='booked'? true : false, 
                                  confirmed: seat.status=='confirmed'? true : false, 
                                  empty: seat.status=='n/a'? true : false,             
                                  'col-xs-offset-2': emptySpace(seat.seat_no) }"
                                  v-for="seat in seatList"          
                                  @click="toggle(seat)"           
                                  :disabled="isDisabledSeatSelection(seat.status)"                   
                                >               
                                  {{ seat.seat_no }} - {{ seat.status }}
                                </button>     
                               <!--  <button v-for="seat in seatList">  {{ seat.seat_no }} - {{ seat.status }} </button> -->
                            </div>

                            <!-- <div id="products" class="row list-group">
                                <div class="item col-xs-4 col-lg-4" v-for="product in products">
                                    <div class="thumbnail">
                                        <img class="group list-group-image" :src="product.image" :alt="product.title" />
                                        
                                        <div class="caption">
                                            <h4 class="group inner list-group-item-heading">{{ product.title }}</h4>
                                            <p class="group inner list-group-item-text">{{ product.description }}</p>
                                            <div class="row">
                                                <div class="col-xs-12 col-md-6">
                                                    <p class="lead">${{ product.price }}</p>
                                                </div>
                                                <div class="col-xs-12 col-md-6">
                                                    <a class="btn btn-success" href="#">Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           </div> -->
                        </div>          
                    </div> 
                    
                  </div>  

                    
                <!-- </div>
            </div>
        </div>
    </div> -->
</template>

<script>
    export default {
      props: ['cities'],
      
      data() {
          return {   
              startDate: '',               
              selected: '',
              selectedTo: '',             
              message: '',
              modal: false,
              loading: false,
              error: false,
              busError: false,
              cityList:[],
              cityToList:[],
              buses:[],
              // seat display
              seatChar:["A","B", "C" , "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"],                             
              seatNo: '',
              seatError: false,                                 
              selectedSeat: [],
              seatList: []
              // end seat display
          }
      },
      
      mounted() {
           console.log('Seat search Component ready.');
           this.cityList = JSON.parse(this.cities);         
           this.showDate();
         
      },

      watch: {
       selected(val) {
          console.log(val);
          this.fetchCityToList(val);          
         //this.arr.push(val);
       }
      },
      // computed: {
      // },
      methods: {
        close() {
                this.modal = false;
                //this.query = '';
        },
        searchBus() {         
          console.log(this.startDate);

          this.busError = false;
          this.loading = true;
           
          var vm = this;
          this.buses ='';
          axios.get('/search', {
              params: {
                firstName: this.selected,
                from: this.selected,
                to: this.selectedTo,
                date: this.startDate,              
              }  
            })          
            .then(function (response) {             
               console.log(response.data);
               response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
               vm.loading = false;
            });
         
          /* for POST
            axios.post('/search', {
              firstName: this.selected,
              from: this.selected,
              to: this.selectedTo,
              date: this.startDate,
              lastName: 'Flintstone'
            })          
            .then(function (response) {
               console.log(response.data)
               response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
            });
            */
        },

        viewSeats(scheduleId, busId) {
          console.log('schId=', scheduleId);
          console.log('busId=', busId);
          this.loading = true;
          var vm = this;
          axios.get('/viewseats', {
              params: {
                from: this.selected,
                to: this.selectedTo,
                date: this.startDate,
                schedule_id: scheduleId,
                bus_id: busId,
              }  
            })          
            .then(function (response) {             
                console.log(response.data);
                response.data.error ? vm.seatError = response.data.error : vm.seatList = response.data;
                vm.loading = false;
                vm.modal = true;

            });
        },

        fetchCityToList(cityName) {
          
          this.error = false;
          this.loading = true;
          this.cityToList = [];
          var vm = this;
          axios.get('api/city?q=' + cityName)          
            .then(function (response) {
              //vm.answer = _.capitalize(response.data.answer)
              // console.log(response.data);
               response.data.error ? vm.error = response.data.error : vm.cityToList = response.data;
               vm.loading = false;
              // console.log(vm.error);
               //vm.cityToList = response.data;
               //vm.message= response.data
            });
        },
        showDate() {
          var vm = this;
          $('#sandbox-container .input-group.date').datepicker({
                        format: 'dd-mm-yyyy',                        
                        startDate: '0d'                     
                    }).on("changeDate", () => {vm.startDate = $('#sandbox-container #startDate').val()});

        },
        testDate() {
          console.log(this.startDate); // the startDate value is ''
        },
        
        /*** seat display methods ******/

        emptySpace(seatNo) {           
            
            if ( this.isFiveCol(seatNo) ) {
              return false; // no need empty space between columns
            }
            var seatNumber = parseInt(seatNo.match(/\d+/),10);            
            return ( (seatNumber % 3) == 0 ) ? true : false;

        },
        isFiveCol(seatNo) {
          
          var seatListLength =  this.seatList.length;
          var numberOfRow = (seatListLength-1) /4; //2
          var lastRowChar = this.seatChar[numberOfRow-1] || ''; //B
          lastRowChar = lastRowChar.trim();
          
          var seatChar = seatNo.substr(0, 1); //extract char from seat no
          return ( lastRowChar == seatChar ) ? true : false ;
        },
        toggle(seat) {
          // console.log('clicked');
          // console.log(seat.no);
          seat.checked = !seat.checked;                         
              if (seat.checked) {
                //console.log('seat checked=', seat.checked);
                this.addSeat(seat.seat_no); // to selectedSeat array               
                return ;
              }
              //console.log('seat NOT checked=', seat.checked);               
              this.removeSeat(seat.seat_no, seat); // to selectedSeat array                            
        },
        addSeat(seatNo) {
          //console.log('+', seatNo);
          this.selectedSeat.push({
          seat_no: seatNo,
          status: 'booked' //'selected'
          });
        },
        removeSeat(seatNo, seat) {
          //console.log('-', seatNo);
          //var indx = this.selectedSeat.indexOf(seatNo);  
          /*
          'findIndex' callback is invoked with three arguments: 
          1.the value of the element, 
          2. the index of the element, and 
          3. the Array object being traversed.
          ref: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/findIndex 
          */      
          var indx = this.selectedSeat.findIndex(function(seat){ 
            // here 'seat' is array object of selectedSeat array
             return seat.seat_no == seatNo;
          });
        //console.log(indx);
          this.selectedSeat.splice(indx, 1);
          return;
        },
        isDisabledSeatSelection(seatStatus) {
          //console.log('disableSelection=', seatStatus);
          return ( seatStatus == 'booked' || 
               seatStatus == 'confirmed' || seatStatus == 'n/a' ) ? true : false;
        }
        // end display methods
      }
      
    }              
</script>

<style>
  @media (min-width: 992px) { 
    .btn-search {
      margin-top: 25px;
    }
  }
  .loading {
    text-align: center;
  }
  /* The Modal (background) */
  .modal {
      display: block; 
      position: fixed; /* Stay in place */
      z-index: 111; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  /* Modal Content/Box */
  .modal-content {
      background-color: #fefefe;
      margin: 160px auto; /* 15% from the top and centered */
      /*padding: 20px;*/
      padding: 35px 20px 2px;
      border: 1px solid #888;
      width: 89%; /* Could be more or less, depending on screen size */
  }

    /* circle*/
   .circle {
      float: right;
      margin-top: -28px;
      position: relative;
      width: 24px; 
      height: 24px; 
      background: #ebccd1; 
      border-radius: 12px; 
      -moz-border-radius: 15px; 
      -webkit-border-radius: 15px; 
      
  }
  /* The Close Button */
  .close {
      color: #aaa;
      /*float: right;*/
      margin-left: 7px;
      font-size: 20px;
      font-weight: bold;
      position: absolute;
      /*margin-top: -18px;*/
  }    

  .close:hover,
  .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
  }
  /* seat display */
  .active {
    background-color: green;
  }     
  .booked {
    background-color: yellow; 
  }
  .confirmed {
    background-color: red;
  }
  .empty {
    background-color: white;
    border-width: 0;
      /*color: #0a0a0a;*/
    color:white;        
  }
  #modal button {       
    height: 50px;
    margin: 10px 10px 0 0;
  }
  #modal button.col-xs-2 {
      width: 16.76666667%;          
  }
  #modal button.col-xs-offset-2 {
      margin-left: 17.666667%;
  }
  #modal button.is-white {
      background-color: white;
      border-width: 0;
      color: #0a0a0a;
  }
/* end seat display */
</style>