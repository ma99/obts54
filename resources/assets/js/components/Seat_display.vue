<script>
    export default {
      props: ['cities'],
      
      data() {
          return {
              alertType: '',
              bookedSeatInfo: { },
              busId:'',
              busError: false,
              buses:[],
              cityList:[],
              cityToList:[],
              error: false,
              loading: false,
              message: '',
              modal: false,
              showAlert: false, // for alert Component
              showSearch: true,              
              scheduleId:'',
              startDate: '',               
              selectedCityFrom: '',
              selectedTo: '',
              selectedPickupPoint: '',
              selectedDroppingPoint: '',
              url: 'seatbooking',             
              // seat display
              seatChar:["A","B", "C" , "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"],                             
              seatNo: '',
              seatStatus: '',              
              seatError: false,                                 
              selectedSeat: [],
              seatList: [],
              pickupList: [],
              droppingList: [],
              totalFare: 0,
              totalSeats: 0,              
              // end seat display
              //guestUser: true,              
              form: new Form({  //data as object
                name: '',
                email:'',
                phone:'',
                //non form data
                bus_id: '',
                date: '',
                schedule_id: '',
                selected_seats: '',
                total_seats: '',
                total_fare: '',
                pickup_point: '',
                dropping_point:'',
              })
          }
      },
      
      mounted() {
           console.log('Seat search Component ready.');           
           this.cityList = JSON.parse(this.cities);         
           this.showDate();           
           // Echo.channel('mychannel.1')
           //    .listen('SeatStatusUpdatedEvent', function(e) {
           //        console.log(e.seat, e.scheduleId);
           //    });
            Echo.channel('mychannel.1')
              .listen('SeatStatusUpdatedEvent', this.updateSeatStatus); 
      },
      watch: {
       seatStatus() {        
        var type = this.seatStatus;
        switch (type) {
          case 'available':
            this.alertType = 'success';           
            break;
          case 'booked':
           this.alertType = 'warning';
            break;          
          case 'confirmed':
            this.alertType = 'danger';           
            break;  
          case 'cancelled':
            this.alertType = 'info';
            break;
          default:
            console.log('Sorry, we are out of ' + type + '.');
        }
       }, 
       selectedCityFrom() {
          //console.log();
          this.fetchCityToList(this.selectedCityFrom);          
          this.fetchPickupPointList(this.selectedCityFrom);   // Pickup Area List based On From City       
          
         //this.arr.push(val);
       },
       selectedTo() {
          this.fetchDroppingPointList(this.selectedTo);   // Pickup Area List based On From City       
       },      
       /*selectedTo(val) {
          console.log(val);
          this.fetchDropingPointList(val);   // Drop Area List based On To City
       }*/
      //  selectedSeat() {
      //     // sort the array
      //     this.selectedSeat.sort(function(a, b) {
      //     var nameA = a.seat_no.toUpperCase(); // ignore upper and lowercase
      //     var nameB = b.seat_no.toUpperCase(); // ignore upper and lowercase
      //     if (nameA < nameB) {
      //       return -1;
      //     }
      //     if (nameA > nameB) {
      //       return 1;
      //     }

      //     // names must be equal
      //     return 0;
      //   });
      // }
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

        isDisabled(){
          //return ( this.selected=='' || this.selectedTo=='' || this.startDate='' ) ? true : false;
          // if ( this.selected == "" || this.selectedTo == "" || this.startDate =='' ){
          //   return true;
          // }
          // return false ;
          return ( this.selectedCityFrom == "" || this.selectedTo == "" || this.startDate =='' ) ? true : false;
       },

        //showSelectedSeatList() {
        isSeatSelected() {
          let len = this.selectedSeat.length;
          return ( len >0 ) ? true : false;
        },
        isSeatBooked() {
          //Object.keys(this.bookedSeatInfo).length;
          //let len = this.bookedSeatInfo.length;
          let len = Object.keys(this.bookedSeatInfo).length;
          //return ( len >0 ) ? true : false;
          if (len >0) {
            this.showSearch = false;
            return true;
          } 
          return false;
        },
      },
      methods: {
        close() {
                this.modal = false;
                this.loading = false;                
                this.selectedSeat = [];
                if(this.form.errors) {
                  this.form.errors.clear();                
                }
        },
        isSeatBuying(seatStatus){
          return seatStatus=='buying' ? true : false;
        },
        updateSeatStatus(evnt) {          
          var seatNo = evnt.seat.seat_no;
          console.log('seaaatno=', seatNo);
          //var vm = this;
          if ( this.scheduleId == evnt.scheduleId && this.startDate == evnt.date) {
            
              var indx = this.seatList.findIndex(function(seat){ 
                // here 'seat' is array object of selectedSeat array
                return seat.seat_no == seatNo;
              });

             // this.seatList[indx].status = "booked"; //prev
            this.seatList[indx].status = evnt.seat.status;
            this.seatNo = seatNo;
            this.seatStatus = evnt.seat.status;
            //this.showAlert();
            this.showAlert = true;


            
          // this.seatList.push({
          //     seat_no: seat.seat_no,              
          //     status: seat.status
          // });
          }
          console.log(evnt.seat.seat_no, evnt.scheduleId, evnt.date);
        },
        // showAlert() {
        //         $("#status-alert").alert();
        //         $("#status-alert").fadeTo(2000, 500)
        //         .slideUp(500, function(){
        //             $("#status-alert").slideUp(500);
        //         });   
        // },        
        searchBus() {         
          console.log(this.startDate);

          this.busError = false;
          this.loading = true;
           
          var vm = this;
          this.buses ='';
          axios.get('/search', {
              params: {                
                from: this.selectedCityFrom,
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
                from: this.selectedCityFrom,
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

        seatBookingByGuest() {
          //this.loading = true;
          //this.buses = []; // hide table
          var vm = this; 
          //this.changeStatusOfSelectedSeat(this.selectedSeat); 
          console.log('modified selected seat'); 
          console.log(this.selectedSeat); 

          swal({
              title: "Are you sure?",
              text: "This will register a BOOKING for you",
              type: "info",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, Book!",
              //closeOnConfirm: false,
              //closeOnCancel: false                        
            },
            function() {  
              vm.loading = true;
              vm.buses = []; // hide table
              vm.changeStatusOfSelectedSeat(vm.selectedSeat); 
              // // non form data  
              vm.form.bus_id = vm.busId;
              vm.form.date = vm.startDate;
              vm.form.schedule_id = vm.scheduleId;
              vm.form.selected_seats = vm.selectedSeat;
              vm.form.total_seats = vm.totalSeats;
              vm.form.total_fare = vm.totalFare; 
              vm.form.pickup_point = vm.selectedPickupPoint; 
              vm.form.dropping_point = vm.selectedDroppingPoint; 


            vm.form.post(vm.url)
                  //.then(response => alert('Wahoo!'));
            .then(function (response) {
               //console.log(response.data)
               vm.selectedSeat= [];                                  
               vm.bookedSeatInfo = response;
               vm.modal = false;
               vm.loading = false;
               //console.log('res=', response);
            })
            .catch(function (error) {
              console.log(error);
              vm.loading = false;
            });
          // end of non form data
          });

            // // non form data  
            // this.form.bus_id = this.busId;
            // this.form.date = this.startDate;
            // this.form.schedule_id = this.scheduleId;
            // this.form.selected_seats = this.selectedSeat;
            // this.form.total_seats = this.totalSeats;
            // this.form.total_fare = this.totalFare; 


            // this.form.post(this.url)
            //       //.then(response => alert('Wahoo!'));
            // .then(function (response) {
            //    //console.log(response.data)
            //    vm.selectedSeat= [];                                  
            //    vm.bookedSeatInfo = response;
            //    vm.modal = false;
            //    vm.loading = false;
            //    //console.log('res=', response);
            // })
            // .catch(function (error) {
            //   console.log(error);
            //   vm.loading = false;
            // });
          // end of non form data
          // swal({
          //   title: "Are you sure?",
          //   text: "This will register a BOOKING for you",
          //   type: "info",
          //   showCancelButton: true,
          //   confirmButtonColor: "#DD6B55",
          //   confirmButtonText: "Yes, Book!",
          //   //closeOnConfirm: false,
          //   //closeOnCancel: false                       
          // },
          // function() {                       
           
          //         //swal("Deleted!", "Staff has been Removed.", "success");                      
              
          // });
          
          
          /*
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
          */
        },
        seatBookingByUser() {
          //this.loading = true;
          //this.buses = []; // hide table
          var vm = this; 
          //this.changeStatusOfSelectedSeat(this.selectedSeat);         
          swal({
              title: "Are you sure?",
              text: "This will register a BOOKING for you",
              type: "info",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, Book!",
              //closeOnConfirm: false,
              //closeOnCancel: false                        
            },
            function() {  
              vm.loading = true;
              vm.buses = []; // hide table
              vm.changeStatusOfSelectedSeat(vm.selectedSeat);               

              axios.post(vm.url, {
                bus_id: vm.busId,
                date: vm.startDate,
                schedule_id: vm.scheduleId,
                selected_seats:vm.selectedSeat,
                total_seats: vm.totalSeats,
                total_fare: vm.totalFare,
                pickup_point:  vm.selectedPickupPoint,
                dropping_point: vm.selectedDroppingPoint 
              })                           
              .then(function (response) {
                 //console.log(response.data)
                 vm.selectedSeat= [];
                 vm.bookedSeatInfo = response.data;
                 vm.loading = false;
                 vm.modal = false;
                 // response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
              })
              .catch(function (error) {
                console.log(error);
                vm.loading = false;
              });
          
          });
          
          /*axios.post(this.url, {
              bus_id: this.busId,
              date: this.startDate,
              schedule_id: this.scheduleId,
              selected_seats:this.selectedSeat,
              total_seats: this.totalSeats,
              total_fare: this.totalFare
          })          
          .then(function (response) {
               console.log(response)
               vm.selectedSeat= [];
               vm.bookedSeatInfo = response.data;
               vm.loading = false;
               vm.modal = false;
               // response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
          });*/
          
        },
        changeStatusOfSelectedSeat(selectedSeat) {
          var vm = this;
          selectedSeat.forEach( function(seat){
            seat.status = (vm.url == 'seatbooking') ? 'booked' : 'buying';
          });

        },
        // makePayment() {
        //   this.loading = true;
        //   var vm = this;
        //   var code = '30303';          
        //   axios.get('api/zipcode?q=' + code)
        //       .then(function (response) {
        //        console.log(response.data)
        //        // vm.selectedSeat= [];
        //        vm.loading = false;
        //        //vm.modal = false;
        //        // response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
        //   });

        // },

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

        fetchPickupPointList(cityName) {

          this.error = false;
          this.loading = true;
          this.pickupList = [];
          var vm = this;
          axios.get('api/pickup?q=' + cityName)          
            .then(function (response) {
              //vm.answer = _.capitalize(response.data.answer)
              // console.log(response.data);
               response.data.error ? vm.error = response.data.error : vm.pickupList = response.data;
               vm.loading = false;
              // console.log(vm.error);
               //vm.cityToList = response.data;
               //vm.message= response.data
            });

        },

        fetchDroppingPointList(cityName) {

          this.error = false;
          this.loading = true;
          this.droppingList = [];
          var vm = this;
          axios.get('api/dropping?q=' + cityName)          
            .then(function (response) {
              //vm.answer = _.capitalize(response.data.answer)
              // console.log(response.data);
               response.data.error ? vm.error = response.data.error : vm.droppingList = response.data;
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
          this.sortSelectedSeat();
        },
        sortSelectedSeat(){
          this.selectedSeat.sort(function(a, b) {
            var nameA = a.seat_no.toUpperCase(); // ignore upper and lowercase
            var nameB = b.seat_no.toUpperCase(); // ignore upper and lowercase
            if (nameA < nameB) {
              return -1;
            }
            if (nameA > nameB) {
              return 1;
            }

            // names must be equal
            return 0;
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
          
          this.removeSeatCheckedStatus(seatNo, seat); // checked = false 
          // var indx = this.seatList.findIndex(function(seat){ 
          //       // here 'seat' is array object of selectedSeat array
          //       return seat.seat_no == seatNo;
          //     });

          //     this.seatList[indx].checked = false;
          //

          var indx = this.selectedSeat.findIndex(function(seat){ 
            // here 'seat' is array object of selectedSeat array
             return seat.seat_no == seatNo;
          });
        //console.log(indx);
          this.selectedSeat.splice(indx, 1);
          return;
        },
        removeSeatCheckedStatus(seatNo, seat){
          var indx = this.seatList.findIndex(function(seat){ 
                // here 'seat' is array object of selectedSeat array
                return seat.seat_no == seatNo;
              });
              this.seatList[indx].checked = false;               
        },
        isDisabledSeatSelection(seatStatus) {
          //console.log('disableSelection=', seatStatus);
          return ( seatStatus == 'booked' || 
              seatStatus == 'buying' ||
              seatStatus == 'confirmed' || 
              seatStatus == 'n/a' ) 
              ? 
              true : false;
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

<style lang="scss" scoped>
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

  /*[v-cloak] { display:none; }*/
  
  .loading {
    text-align: center;
    z-index: 11111;
  }
  /* The Modal (background) */
  .modal {
      display: block; 
      position: fixed; /* Stay in place */
      z-index: 11111; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }
  
  /* seat display */
  .is-active {
    background-color: green;
  }     
  .booked {
    background-color: yellow; 
  }
  .buying {
    background-color: orange; 
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
  
  
  /*#modal button {       
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
  }*/

  // seat-layout

  /* #seat-layout .seat-plan-body button {       
    height: 50px;
    margin: 10px 10px 0 0;
  }
  #seat-layout button.col-xs-2 {
      width: 16.76666667%;          
  }
  #seat-layout button.col-xs-offset-2 {
      margin-left: 17.666667%;
  }
  #seat-layout button.is-white {
      background-color: white;
      border-width: 0;
      color: #0a0a0a;
  }
  .seat-plan-body {
    padding-left: 20px;
  } */

  #seat-layout {
    .seat-plan-body {
      padding-left: 20px;
       button {       
          height: 50px;
          margin: 10px 10px 0 0;
           &.col-xs-2 {
                width: 16.76666667%;          
            }
          &.col-xs-offset-2 {
              margin-left: 17.666667%;
          }
          &.is-white {
              background-color: #fff; 
              border-width: 0;
              color: #0a0a0a;
          }
        }   
    }
  }  
  /*#modal .row  {
    background-color: #e5ecff;
  }*/  
/* end seat display */
</style>