<template>
  <div>    
    <section class="content-header">
      <h1>
        Bus Schedule
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">        
        <li>
          <router-link to="/dashboard" exact>
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li> 
        <li class="active">Schedule</li>
      </ol>
    </section>

    <section class="content">      
      <div class="row">
          <!-- <div class="col-md-8 col-md-offset-2"> -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <span class="input-group-btn">
                    <button class="btn btn-success" type="button" @click="expandAddSchedulePanel" v-show="!show">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-warning" type="button" @click="expandAddSchedulePanel" v-show="show">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </span>                
            </div>
            <div class="panel-body" v-show="show">
               <form>
                   <div class="col-sm-4"> 
                   <div class="form-group">
                      <label for="routeId"> Route Ids </label>
                      <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
                      <select v-model="selectedRouteId" class="form-control" name="route_id" id="routeId">
                        <option disabled value="">Please select one</option>
                        <option v-for="availableRoute in availableRouteList">
                          {{ availableRoute.id }}
                        </option>                           
                      </select>
                    </div>
                  </div>

                 <div class="col-sm-4"> 
                   <div class="form-group">
                      <label for="busId"> Bus Ids </label>                    
                      <select v-model="selectedBusId" class="form-control" name="bus_id" id="busId">
                        <option disabled value="">Please select one</option>
                        <option v-for="bus in availableBusList">
                          {{ bus.id }}
                        </option>                           
                      </select>
                    </div>
                 </div>

                 <div class="col-sm-2"> 
                    <div class="form-group">
                       <label for="departure-time">Departure time: </label>
                       <input v-model="departureTime"id="departure-time" type="time" name="departure-time" class="form-control" min="00:00" max="23:00" required>
                    </div>
                 </div>

                 <div class="col-sm-2"> 
                    <div class="form-group">                     
                       <label for="arrival-time">Arrival time: </label>
                       <input v-model="arrivalTime"id="arrival-time" type="time" name="arrival-time" class="form-control" min="00:00" max="23:00" required>
                    </div>
                 </div>

                 <div class="col-sm-12">
                    <div class="panel panel-info" v-show="Object.keys(routeInfo).length > 0">
                      <div class="panel-heading">Route Info</div>
                      <div class="panel-body">
                        <table class="table .table-striped">
                            <thead>
                              <tr>
                                <th>Route Id</th>
                                <th>Departure City</th>
                                <th>Arrival City</th>
                                <th>Distance</th>
                                <th>&nbsp;</th>              
                              </tr>
                            </thead>
                            <tbody>
                              <tr>                              
                                <td>{{ routeInfo.id}}</td>                              
                                <td>{{ routeInfo.departure_city}}</td>                              
                                <td>{{ routeInfo.arrival_city}}</td>                              
                                <td>{{ routeInfo.distance}}</td>
                              </tr>                            
                            </tbody>
                        </table>                                        
                      </div>
                    </div>
                 </div>

                 <div class="col-sm-4">
                    <div class="button-group">
                      <!-- <button v-on:click.prevent="createList()" class="btn btn-primary" :disabled="disableShowButton">Show</button> -->
                      <!-- <button v-on:click.prevent="saveSchedule()" class="btn btn-primary" :disabled="disableSaveButton">Save</button> -->
                      <button v-on:click.prevent="saveSchedule()" class="btn btn-primary" :disabled="!isValid">Save</button>
                      <button v-on:click.prevent="reset()" class="btn btn-primary">Reset</button>
                    </div>
                  </div>

               </form>
            </div>
          </div>
        <!-- </div> -->
      </div>   <!-- /row -->   
      <loader :show="loading"></loader>


      <div class="row view-available-info">
        <div class="panel panel-info">
          <div class="panel-heading">Schedule Info <span> {{ availableScheduleList.length }} </span></div>
          <div class="panel-body">
              <div id="scroll-routes">
                <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Schedulel #</th>
                        <th>Route ID
                              <!-- <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                              </span> -->
                        </th>
                        <th>Bus ID                      
                             <!-- <span type="button" @click="isSortingAvailableBy('division')" :disabled="!disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span> -->
                        </th>
                        <th>Departure Time</th>      
                        <th>Arrival Time</th>     
                        <th>Action</th>                                                         
                        <!-- <th>&nbsp;</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(schedule, index) in availableScheduleList" >                              
                        <td>{{ index+1 }}</td>                              
                        <td>{{ schedule.id }}</td>
                        <td>{{ schedule.rout_id }}</td>
                        <td>{{ schedule.bus_id }}</td>                              
                        <td>{{ schedule.departure_time }}</td>
                        <td>{{ schedule.arrival_time }}</td>
                        <td> 
                            <button v-on:click.prevent="editSchedule(schedule)" class="btn btn-primary">
                              <i class="fa fa-edit fa-fw"></i>Edit
                            </button>  
                            <button v-on:click.prevent="removeSchedule(schedule)" class="btn btn-danger">
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
             <!--  Schedule <strong>{{ schedule.id }} </strong> for Route ID <strong>{{ schedule.rout_id }} </strong> has been  -->
             SCHEDULE
              <strong> {{ actionStatus }} </strong> successfully!
            </show-alert>
          </div>
        </div>
      </div>
      <!-- Modal -->              
      <!-- <modal :show="modal" @close="modal=false"> -->
      <modal v-show="modal" @close="cancelEdit">
        <div class="row">
            <div id="edit-schedule" class="col-sm-10 col-sm-offset-1">
              <div class="panel panel-default">
                <div class="panel-heading">Edit Schedule Info.</div>                
                <div class="panel-body">
                  <span> Last Updated: <strong>{{ schedule.updated_at }} </strong> </span>
                  </br></br>
                  <div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="scheduleId">Schedule ID</label>
                        <input v-model="schedule.id" type="text" class="form-control" id="scheduleId" disabled="true">
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="routeId">Route ID</label>
                        <input v-model="schedule.rout_id" type="text" class="form-control" id="routeId" disabled="true">
                      </div>
                    </div>

                    <div class="col-sm-3"> 
                        <div class="form-group">
                          <label for="busId"> Bus Ids </label>                    
                          <select v-model="schedule.bus_id" class="form-control" name="bus_id" id="busId">
                            <option disabled value="">Please select one</option>
                            <option v-for="bus in availableBusList">
                              {{ bus.id }}
                            </option>                           
                          </select>
                        </div>
                    </div>

                    <div class="col-sm-2"> 
                        <div class="form-group">
                           <label for="departure-time">Departure Time </label>
                           <input v-model="schedule.departure_time" id="departure-time" type="time" name="departure-time" class="form-control" min="00:00" max="23:00" required>
                        </div>
                    </div>

                    <div class="col-sm-2"> 
                        <div class="form-group">                     
                           <label for="arrival-time">Arrival Time </label>
                           <input v-model="schedule.arrival_time" id="arrival-time" type="time" name="arrival-time" class="form-control" min="00:00" max="23:00" required>
                        </div>
                    </div>
                    
                  </div>
                </div>

                <div class="panel-footer">
                      <button class="btn btn-primary" v-on:click.prevent="updateSchedule(schedule)">Save</button>
                      <!-- <button class="btn btn-primary" @click.prevent="modal=false">Cancel</button> -->
                      <button class="btn btn-primary" @click.prevent="cancelEdit()">Cancel</button>
                </div>    

              </div>

            </div>               
        </div>                 
      </modal>
        <!-- /Modal -->
    </section>        
  </div>      
</template>
<script>
    export default {
        data() {
            return {
                actionStatus: '',
                alertType: '',
                arrivalTime: '',
                departureTime: '',
                availableBusList: [],
                availableRouteList: [], 
                availableScheduleList: [], 
                error: '',
                loading: false,
                modal: false,
                //routeIds: [],
                response: '',
                routeInfo: [],                
                selectedBusId: '',
                selectedRouteId: '',
                schedule: {},
                show: false,
                showAlert: false
            }
        },
        watch: {
            selectedRouteId() {
                if (this.selectedRouteId != '') {                   
                    this.fetchRouteInfo(this.selectedRouteId);                
                }
            },

        },        
        mounted() {
            //console.log('Component mounted.')
            //this.fetchBusIds();
            this.fetchAvailableBuses();
            this.fetchAvailableRoutes();
            this.fetchAvailableSchedules();
        },
        computed: {
            isValid() {
                return this.routeId != '' && 
                        this.busId != '' &&
                        this.departureTime != '' &&
                        this.arrivalTime != '' 
              }
            },      
        methods: {
            // fetchBusInfo(busId) {
            //     this.busInfo = [];
            //     this.busInfo = this.availableBusList.find(function (obj) { 
            //         // console.log('iddd=', obj.id);    
            //         // console.log('routeId=', routeId);
            //         return obj.id == busId; });
            // },
            cancelEdit() {
                this.schedule = '';            
                this.modal = false;
            },
            editSchedule(schedule) {
                this.schedule = _.clone(schedule); //cloning or coppy                
                this.modal = true; 
            },
            expandAddSchedulePanel() {
                this.show = !this.show;
            },

            fetchRouteInfo(routeId) {
                this.routeInfo = [];
                this.routeInfo = this.availableRouteList.find(function (obj) { 
                    // console.log('iddd=', obj.id);    
                    // console.log('routeId=', routeId);
                    return obj.id == routeId; });
            },
            
            fetchAvailableBuses() {
                this.loading = true;
                this.availableBusList= [];            
                var vm = this;                
                axios.get('/api/buses')  //--> api/bus?q=xyz        (right)
                    .then(function (response) {                  
                       response.data.error ? vm.error = response.data.error : vm.availableBusList = response.data;                       
                       vm.loading = false;
                });
            },
            fetchAvailableSchedules() {
                this.loading = true;
                this.availableScheduleList= [];            
                var vm = this;                
                axios.get('/api/schedule')  //--> api/bus?q=xyz        (right)
                    .then(function (response) {                  
                       response.data.error ? vm.error = response.data.error : vm.availableScheduleList = response.data;
                       //vm.tempAvailableRouteList = response.data;
                      // vm.SortByIdAvailableRouteList(vm.availableRouteList);
                       vm.loading = false;
                });
            },
            fetchAvailableRoutes() {
                this.loading = true;
                this.availableRouteList= [];            
                var vm = this;                
                axios.get('/api/routes')  //--> api/bus?q=xyz        (right)
                    .then(function (response) {                  
                       response.data.error ? vm.error = response.data.error : vm.availableRouteList = response.data;
                       //vm.tempAvailableRouteList = response.data;
                       vm.SortByIdAvailableRouteList(vm.availableRouteList);
                       vm.loading = false;
                });
            },
            SortByIdAvailableRouteList(arr) {
                arr.sort(function(a, b) {
                  return a.id - b.id;
                });
            },

            removeSchedule(schedule) {  // role id of user/staff in roles table
                var vm = this;            
                //this.routeName = route.departure_city + ' to ' + route.arrival_city;
                swal({
                      title: "Are you sure?",
                      text: "This Route will be Removed from Route List!",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Yes, Remove!",
                      //closeOnConfirm: false,
                      //closeOnCancel: false                       
                    },
                    function() {                       
                            vm.loading = true;
                            vm.response = '';
                            vm.showAlert = false;
                            axios.post('/delete/schedule', {                            
                                schedule_id: schedule.id, 
                            })          
                            .then(function (response) {                                           
                                // response.data.error ? vm.error = response.data.error : vm.availableRouteList = response.data;
                                response.data.error ? vm.error = response.data.error : vm.response = response.data;

                                if (vm.response) {                                
                                    vm.removeScheduleFromAvailableScheduleList(schedule.id); // update the array after removing
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
              },
             
              removeScheduleFromAvailableScheduleList(scheduleId) {
                var indx = this.availableRouteList.findIndex(function(schedule){                 
                     return schedule.id == scheduleId;
                });        
                this.availableScheduleList.splice(indx, 1);
                //return;
              },

            saveSchedule() {
                var vm = this;
                axios.post('/schedule', {
                    route_id: this.selectedRouteId,
                    bus_id: this.selectedBusId,
                    departure_time: this.departureTime,                
                    arrival_time: this.arrivalTime
                })          
                .then(function (response) {
                    //console.log(response.data);
                    response.data.error ? vm.error = response.data.error : vm.response = response.data;
                    if (vm.response) {
                       //console.log(vm.response);
                       //vm.fetchAvailableSchedules();
                       //vm.SortByCityNameAvailableRouteList(vm.availableRouteList);
                       vm.loading = false;
                       //vm.disableSaveButton = true;
                       //vm.routeAddedAlert(vm.selectedDepartureCity, vm.selectedArrivalCity);
                       vm.reset();
                       return;                   
                    }
                    vm.loading = false;
                    //vm.disableSaveButton = true;
                });
            },
            reset() {
                this.selectedBusId = '';
                this.selectedRouteId = '';
                this.arrivalTime = '';
                this.departureTime = '';
                this.routeInfo = '';                                
            },
            updateSchedule(schedule) {
                var vm = this;
                    this.response = '';
                    this.showAlert = false;                                
                    this.loading = true;
                    axios.post('/edit/schedule', {                        
                          schedule: schedule
                        })          
                        .then(function (response) {                                           
                          
                          response.data.error ? vm.error = response.data.error : vm.response = response.data;
                          if (vm.response) {
                              vm.updateScheduleAtAvailableScheduleList(schedule.id, schedule);
                              vm.loading = false;
                              vm.modal = false;
                              vm.actionStatus = 'Udated';
                              vm.alertType = 'info';                          
                              vm.showAlert= true;                                                                        
                          }
                        });
            },

            updateScheduleAtAvailableScheduleList(scheduleId, schedule) {                
                 var indx = this.availableScheduleList.findIndex(function(schedule){                                        
                        return schedule.id == scheduleId;
                 });                                     
                 this.availableScheduleList[indx] = schedule;                 
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
      .arrival {
        @extend span;
        background-color: lightblue;
      }
      .departure {
        @extend span;
        background-color: lightgreen;
      }
    }

    form {
         label {
          padding: 0 5px 0 15px;
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