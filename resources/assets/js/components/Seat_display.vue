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
              seatList: [],
              totalFare: 0,
              totalSeats: 0,              
              // end seat display
              scheduleId:'',
              busId:'',
              guestUser: true

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
          //this.fetchPickupPointList(val);   // Pickup Area List based On From City       
         //this.arr.push(val);
       },
       /*selectedTo(val) {
          console.log(val);
          this.fetchDropingPointList(val);   // Drop Area List based On To City
       }*/
      },
      computed: {
        totalFareForSelectedSeats() {          
          var fare = 0;
          let len = this.selectedSeat.length;
          for (var i=0; i<len; i++){
            fare = fare + parseInt(this.selectedSeat[i].fare, 10);
          }
          console.log('total fare:', fare);
          console.log('total seats:', len);
          this.totalFare = fare; 
          this.totalSeats = len;         
        },

        isBusAvailable() {
          let len = this.buses.length;
          return ( len >0 ) ? true : false;  //true show table
        },

        showSelectedSeatList() {
          let len = this.selectedSeat.length;
          return ( len >0 ) ? true : false;
        },
      },
      methods: {
        close() {
                this.modal = false;                
                this.selectedSeat = [];                
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

        viewSeats(scheduleId, busId, busFare) {
          console.log('schId=', scheduleId);
          console.log('busId=', busId);

          this.scheduleId = scheduleId;
          this.busId = busId;
         
          this.loading = true;
          var vm = this;
          axios.get('/viewseats', {
              params: {
                from: this.selected,
                to: this.selectedTo,
                date: this.startDate,
                schedule_id: scheduleId,
                bus_id: busId,
                bus_fare: busFare,
              }  
            })          
            .then(function (response) {             
                console.log(response.data);
                response.data.error ? vm.seatError = response.data.error : vm.seatList = response.data;
                vm.loading = false;
                vm.modal = true;

            });
        },

        seatBooking() {
          this.loading = true;
          this.buses = []; // hide table
          var vm = this;
          axios.post('/seatbooking', {
              bus_id: this.busId,
              date: this.startDate,
              schedule_id: this.scheduleId,
              selected_seats:this.selectedSeat,
              total_seats: this.totalSeats,
              total_fare: this.totalFare
          })          
          .then(function (response) {
               console.log(response.data)
               vm.selectedSeat= [];
               vm.loading = false;
               vm.modal = false;
               // response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
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
                        startDate: '0d',
                        todayHighlight: true,
                        autoclose: true
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
                //this.addSeat(seat.seat_no); // to selectedSeat array               
                this.addSeat(seat); // to selectedSeat array               
                return ;
              }
              //console.log('seat NOT checked=', seat.checked);               
              this.removeSeat(seat.seat_no, seat); // to selectedSeat array                            
        },
        addSeat(seat) {
          //console.log('+', seatNo);
          this.selectedSeat.push({
          seat_no: seat.seat_no,
          fare: seat.fare,
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
        // totalFareForSelectedSeats(seat) {
        //   console.log('Seatfare=', seat.fare);
        //   let fare;
        //   fare = parseInt(seat.fare, 10) + this.totalFare;
        //   this.totalFare = fare;
        //   console.log('fare=', fare);
        //  return fare;
        // }
      }
      
    }              
</script>

<style>
  @media (min-width: 992px) { 
    .btn-search {
      margin-top: 25px;
    }
    #app .alert {
      margin-top: 65px;
    }
  }
  @media (max-width: 991px) { 
    #app .alert {
      margin-top: 15px;
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
      padding: 35px 20px 30px;
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
  #modal .row  {
    background-color: #e5ecff;
  }
/* end seat display */
</style>