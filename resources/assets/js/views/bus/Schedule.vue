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
            <div class="panel-heading">Bus Schedule</div>
            <div class="panel-body">
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
                       <input id="departure-time" type="time" name="departure-time" class="form-control" min="00:00" max="23:00" required>
                    </div>
                 </div>

                 <div class="col-sm-2"> 
                    <div class="form-group">                     
                       <label for="arrival-time">Arrival time: </label>
                       <input id="arrival-time" type="time" name="arrival-time" class="form-control" min="00:00" max="23:00" required>
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
                      <button v-on:click.prevent="createList()" class="btn btn-primary" :disabled="disableShowButton">Show</button>
                      <button v-on:click.prevent="reset()" class="btn btn-primary">Reset</button>
                      <button v-on:click.prevent="saveSeatList()" class="btn btn-primary" :disabled="disableSaveButton">Save</button>
                    </div>
                  </div>

               </form>
            </div>
          </div>
        <!-- </div> -->
      </div>      
    </section>        
  </div>      
</template>
<script>
    export default {
        data() {
            return {
                availableBusList: [],
                availableRouteList: [],                               
                disableShowButton: false,
                disableSaveButton: false,
                error: '',
                loading: false,
                //routeIds: [],
                routeInfo: [],
                selectedBusId: '',
                selectedRouteId: '',
            }
        },
        watch: {
            selectedRouteId() {
                this.fetchRouteInfo(this.selectedRouteId);                
            }
        },        
        mounted() {
            //console.log('Component mounted.')
            //this.fetchBusIds();
            this.fetchAvailableBuses();
            this.fetchAvailableRoutes();
        },
        methods: {
            // fetchBusInfo(busId) {
            //     this.busInfo = [];
            //     this.busInfo = this.availableBusList.find(function (obj) { 
            //         // console.log('iddd=', obj.id);    
            //         // console.log('routeId=', routeId);
            //         return obj.id == busId; });
            // },
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
        },
    }
</script>