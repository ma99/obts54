<template>
  <div>    
    <section class="content-header">
      <h1>
       Bus Management
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">        
        <li>
          <router-link to="/dashboard" exact>
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li> 
        <li class="active">Admin Staff</li>
      </ol>
    </section>

    <section class="content">      
      <div class="row">
          
          <!-- <div class="col-md-8 col-md-offset-1"> -->
          <!-- <div class="col-md-8 col-md-offset-1"> -->
            <div class="panel panel-default">
              <div class="panel-heading">
              <span class="input-group-btn">
                    <button class="btn btn-success" type="button" @click="expandAddBusPanel" v-show="!show">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-warning" type="button" @click="expandAddBusPanel" v-show="show">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </span>                
            </div>
              <div class="panel-body" v-show="show">
                <form> 

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="regNumber">Registration #</label>
                      <input v-model.lazy="regNumber" type="text" class="form-control" id="regNumber" placeholder="Registration Number">
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="numberPlate">Number plate #</label>
                      <input v-model="numberPlate" type="text" class="form-control" id="numberPlate" placeholder="Number Plate" :disabled="isDisabled">
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="numberOfSeat">Total Seat #</label>
                      <input v-model="numberOfSeat" type="number" min="1" max="50" value="36" class="form-control" id="numberOfSeat" placeholder="Number of Seat" :disabled="isDisabled">
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="busType">Bus Type #</label>
                        <select v-model="selectedBusType" class="form-control" id="busType">
                            <option disabled value="">Please select one</option>
                            <option v-for="option in options" v-bind:value="option.value">
                                {{ option.text }}
                            </option>                                              
                        </select>                      
                    </div>
                  </div>

                  <div class="col-sm-5">
                    <div class="form-group">
                      <label for="busDescription">Description</label>
                      <textarea v-model="busDescription" type="text" min="1" max="50" value="36" class="form-control" id="busDescription" placeholder="Description" :disabled="isDisabled"></textarea>
                    </div>
                  </div>


                  <div class="col-sm-4">
                    <div class="button-group">
                      <!-- <button v-on:click.prevent="createList()" class="btn btn-primary" :disabled="disableShowButton">Show</button> -->
                      <button v-on:click.prevent="addBus()" class="btn btn-primary" :disabled="!isValid">Add</button>
                      <button v-on:click.prevent="reset()" class="btn btn-primary">Reset</button>
                    </div>
                  </div>
                </form>  
              </div>
            </div>
          <!-- </div> -->

      </div>
      
      <loader :show="loading"></loader>

      <div class="row view-available-info">
        <div class="panel panel-info">
          <div class="panel-heading">Bus Info <span> {{ availableBusList.length }} </span></div>
          <div class="panel-body">
              <div id="scroll-routes">
                <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Bus ID
                            <span type="button" @click="sortByIdOf('bus')" :disabled="disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span>
                        </th>                           
                        <th>Reg. Number
                            <span type="button" @click="sortByIdOf('registration')" :disabled="!disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span>
                        </th>
                        <th>Number Plate</th>
                        <th>Type</th>      
                        <th>Total Seat</th>     
                        <th>Seat Plan</th>     
                        <th>Descriptin</th>                                                         
                        <th>Action</th>                                                         
                        <!-- <th>&nbsp;</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(bus, index) in availableBusList" >                              
                        <td>{{ index+1 }}</td>                              
                        <td>{{ bus.id }}</td>
                        <td>{{ bus.reg_no }}</td>
                        <td>{{ bus.number_plate }}</td>                              
                        <td>{{ bus.type }}</td>
                        <td>{{ bus.total_seats }}</td>
                        <!-- <td >{{ bus.seat_plan }}</td> -->
                        <td v-if="bus.seat_plan == 0"><strong>N/A</strong></td>
                        <td v-else><strong>Available</strong></td>
                        <td>{{ bus.description }}</td>
                        <td> 
                            <button v-on:click.prevent="editBus(bus)" class="btn btn-primary">
                              <i class="fa fa-edit fa-fw"></i>Edit
                            </button>  
                            <button v-on:click.prevent="removeBus(bus)" class="btn btn-danger">
                              <i class="fa fa-trash fa-fw"></i>Remove
                            </button> 
                        </td>                        
                      </tr>                            
                    </tbody>
                </table>      
              </div>
          </div>
          <!-- {{-- panel-footer --}} -->
          <div class="panel-footer">                                
            <show-alert :show.sync="showAlert" :type="alertType">             
             Bus
              <strong> {{ actionStatus }} </strong> successfully!
            </show-alert>
          </div>
        </div>
      </div>

           
    </section>        
  </div>      
</template>
<script>
    export default {
        // mounted() {
        //     console.log('Component mounted.')
        // }
        data() {
                return {                    
                    actionStatus: '',
                    alertType: '',
                    availableBusList: [],
                    disableShowButton: false,
                    //disableSaveButton: true,
                    disableSorting: true,
                    error: '',                                              
                    response: '',                                        
                    isDisabled: false,                    
                    loading: false,
                    //bus
                    regNumber: '',
                    numberPlate: '',
                    numberOfSeat: '',
                    busDescription: '',
                    selectedBusType: '',
                    showAlert: false,
                    show: false,                    
                    options: [
                      { text: 'AC', value: 'ac' },
                      { text: 'AC-Deluxe', value: 'ac-deluxe' },
                      { text: 'Deluxe', value: 'deluxe' },
                      { text: 'Non-AC', value: 'Non-AC' }
                    ]
                    
                }

                },
                watch: {
                    regNumber() {
                        var aa = this.isRegNumberAvailableInBusList(this.availableBusList, this.regNumber);
                        if (aa) {
                             alert('Registration Number already exist');
                        }

                    }
                },      
                mounted() {
                    // this.fetchBusIds();
                    // this.createIndexList();  
                    this.fetchAvailableBuses();                
                },
                computed: {
                    isValid() {
                        return this.regNumber != '' && 
                                this.numberPlate != '' &&
                                this.numberOfSeat != '' &&
                                this.selectedBusType != '' &&
                                this.busDescription != '' 
                     }
                }, 
                methods: {
                    
                    addBus() {
                        var vm = this;
                        axios.post('/bus', {
                            reg_no: this.regNumber,
                            number_plate: this.numberPlate,
                            type: this.selectedBusType,                
                            total_seats: this.numberOfSeat,
                            description: this.busDescription
                        })          
                        .then(function (response) {
                            //console.log(response.data);
                            response.data.error ? vm.error = response.data.error : vm.response = response.data;
                            if (vm.response) {
                               //console.log(vm.response);
                               vm.fetchAvailableBuses();
                               //vm.SortByCityNameAvailableRouteList(vm.availableRouteList);
                               vm.loading = false;                      
                               //vm.scheduleAddedAlert(vm.selectedRouteId, vm.selectedBusId);
                               vm.reset();
                               return;                   
                            }
                            vm.loading = false;
                            //vm.disableSaveButton = true;
                        });
                    },
                    expandAddBusPanel() {
                        this.show = !this.show;
                    },

                    fetchAvailableBuses() {
                        this.loading = true;
                        this.availableBusList= [];            
                        var vm = this;                
                        axios.get('/api/buses')  //--> api/bus?q=xyz        (right)
                            .then(function (response) {                  
                               response.data.error ? vm.error = response.data.error : vm.availableBusList = response.data;
                               vm.sortByBusId(vm.availableBusList);                       
                               vm.loading = false;
                        });
                    },
                    
                    isRegNumberAvailableInBusList(arr, val){
                        //var vm = this;
                         return arr.some(function(bus) {
                            return val === bus.reg_no;
                        });
                    },
                    sortByIdOf(val) {
                        if (val== 'bus') { 
                            this.sortByBusId(this.availableBusList);
                            this.disableSorting = true;
                            return ;
                        }
                        this.sortByRegNumber(this.availableBusList);
                        this.disableSorting = false;
                    },

                    sortByBusId(arr) {
                        arr.sort(function(a, b) {
                              return a.id - b.id;
                            });
                    },

                    sortByRegNumber(arr) {
                        arr.sort(function(a, b) {
                            var nameA = a.reg_no; //.toUpperCase(); // ignore upper and lowercase
                            var nameB = b.reg_no; //.toUpperCase // ignore upper and lowercase
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
                    /*removeBus(bus) {  // role id of user/staff in roles table
                        var vm = this;            
                        //this.routeName = route.departure_city + ' to ' + route.arrival_city;
                        swal({
                              title: "Are you sure?",
                              text: "This BUS will be Removed!",
                              //type: "warning",
                              icon: "warning",
                              // showCancelButton: true,
                              // confirmButtonColor: "#DD6B55",
                              // confirmButtonText: "Yes, Remove!",
                              //closeOnConfirm: false,
                              //closeOnCancel: false 
                              cancel: {
                                text: "Cancel",
                                // value: null,
                                // visible: false,
                                // className: "",
                                // closeModal: true,
                              },
                              confirm: {
                                text: "Yes, Remove!",
                                value: true,
                                visible: true,
                                className: "",
                                //closeModal: true
                              }        

                            },
                            function() {                       
                                    vm.loading = true;
                                    vm.response = '';
                                    vm.showAlert = false;
                                    axios.post('/delete/bus', {    
                                        bus_id: bus.id, 
                                    })          
                                    .then(function (response) {                 
                                       
                                        response.data.error ? vm.error = response.data.error : vm.response = response.data;

                                        if (vm.response) {                                
                                            vm.removeBusFromAvailableBusList(bus.id); // update the array after removing
                                            vm.loading = false;
                                            vm.actionStatus = 'Removed';
                                            vm.alertType = 'danger';
                                            vm.showAlert= true;
                                            return;                                                      
                                        }                            
                                        vm.loading = false;

                                    });    
                                    //swal("Deleted!", "Staff has been Removed.", "success");                      
                                
                            });
                    },*/

            /*removeBus(bus) {  // role id of user/staff in roles table
                        var vm = this;            
                        //this.routeName = route.departure_city + ' to ' + route.arrival_city;
                        //swal("This BUS will be Removed!", {
                        swal({
                            title: "Are you sure?",
                            text: "This BUS will be Removed!",
                            icon: "warning",
                            dangerMode: true,
                            buttons: {
                                cancel: "cancel",
                                confirm: {
                                  text: "Remove It!",
                                  value: "remove",
                                },                                
                            },
                        
                        })
                        .then((value) => {
                            switch (value) {
                           
                              case "cancel":
                                break;                             
                           
                              case "remove":        
                                vm.loading = true;
                                vm.response = '';
                                vm.showAlert = false;

                                axios.post('/delete/bus', {    
                                    bus_id: bus.id, 
                                })          
                                .then(function (response) {                 
                                   
                                    response.data.error ? vm.error = response.data.error : vm.response = response.data;

                                    if (vm.response) {                                
                                        vm.removeBusFromAvailableBusList(bus.id); // update the array after removing
                                        vm.loading = false;
                                        vm.actionStatus = 'Removed';
                                        vm.alertType = 'danger';
                                        vm.showAlert= true;
                                        return;                                                      
                                    }                            
                                    vm.loading = false;

                                });   
                                  
                                break;
                           
                              default:
                                // swal("Got away safely!");
                                break;
                            }
                        });                           
                    },*/


            removeBus(bus) { 
                var vm = this;
                swal({
                  title: "Are you sure?",
                  text: "This BUS will be Removed!",
                  icon: "error",                 
                  dangerMode: true,
                  buttons: {
                      cancel: "cancel",
                      confirm: {
                        text: "Remove It!",
                        value: true,
                      },                                
                  },
                })
                .then((value) => {
                  if (value) {

                    vm.loading = true;
                    vm.response = '';
                    vm.showAlert = false;

                    axios.post('/delete/bus', {    
                        bus_id: bus.id, 
                    })          
                    .then(function (response) {               
                        response.data.error ? vm.error = response.data.error : vm.response = response.data;
                        if (vm.response) {                                
                            vm.removeBusFromAvailableBusList(bus.id); // update the array after removing
                            vm.loading = false;
                            vm.actionStatus = 'Removed';
                            vm.alertType = 'danger';
                            vm.showAlert= true;
                            return;                                                      
                        }                            
                        vm.loading = false;
                    }); 
                    
                  } 
                  
                }); 
            },
            removeBusFromAvailableBusList(busId) {
                var indx = this.availableBusList.findIndex(function(bus){                 
                     return bus.id == busId;
                });        
                this.availableBusList.splice(indx, 1);
                //return;
            },
                    reset() {                       
                        this.isDisabled = false;
                        // this.disableShowButton = false;
                        // this.disableSaveButton= true;
                        this.regNumber = '' ; 
                        this.numberPlate = '';
                        this.numberOfSeat = '';
                        this.selectedBusType = '';
                        this.busDescription = '';    
                    }
        }
    }
</script>
<style lang="scss" scoped>
    // .view-route-info .panel-heading span {
    .view-available-info .panel-heading span {
      background-color: yellow;
      font-weight: 600;
      float: right;
      padding: 2px 6px;
      color: royalblue;
    }
    .route-info {
      border: 1px dashed lightblue;
      padding: 25px 10px;
      margin: 25px 25px 50px 25px;
      position: relative;
      text-align: center;      

      span {
        /* background-color: lightblue; */
        display: block;
        font-weight: 600;
        letter-spacing: 1px;        
        left: 14px;
        top: -16px;
        position: absolute;
        padding: 5px 10px;
        width: 90px;
      }
      
    }
   
    .route-distance {
      margin: -15px 10px 10px 15px;
    }     
    #scroll-routes {
        span {
            cursor: pointer;
            margin-left: 5px;
        }
        span[disabled] {
            cursor: not-allowed;
            opacity: 0.65;
        }
    } 

</style>