<template>
  <div>    
     <section class="content-header">
      <h1>
       Add new route
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/dashboard" exact>
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li>
        <li class="active">route</li>
      </ol>
    </section>

    <section class="content">      
      <div class="row">
          <div class="panel panel-default">
              <div class="panel-heading">
                <!-- Add New City -->
                <span class="input-group-btn">
                    <button class="btn btn-success" type="button" @click="expandAddRoutePanel" v-show="!show">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-warning" type="button" @click="expandAddRoutePanel" v-show="show">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </span>
                
              </div>
              <div class="panel-body" v-show="show">
                <!-- <form> -->
                    <!-- Route -->
                    <div class="col-sm-12">
                      <div class="panel panel-warning">
                        <div class="panel-heading">Enter Route Info</div>
                        <div class="panel-body">
                          <div class="row">
                            <div class="route-info">
                              <span class="departure">Departure</span>                                                          
                              <form class="form-inline">                            
                               <!--  <div class="col-sm-2"> -->
                                  <div class="form-group">
                                    <label for="divisionName">Division </label>
                                    <select v-model="selectedDivisionForDeparture" class="form-control" id="divisionName">
                                        <option disabled value="">Please select one</option>
                                        <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                                          {{ division.name }}
                                        </option>                             
                                    </select>
                                  </div>
                                <!-- </div> -->

                                <!-- <div class="col-sm-3"> -->
                                  <div class="form-group">
                                    <label for="departureCity">City</label>
                                    <select v-model="selectedDepartureCity" class="form-control" id="departureCity">
                                        <option disabled value="">Please select one</option>
                                        <!-- <option v-for="city in departureCityList" v-bind:valaue="{ id: division.id, name: division.name }"> -->
                                        <option v-for="city in departureCityList">
                                          {{ city.name }}
                                        </option>                             
                                    </select>
                                  </div>
                                <!-- </div> -->
                              </form>
                            </div>
                            <div class="route-info">
                              <span class="arrival">Arrival</span>                     
                              <form class="form-inline">   
                                <div class="form-group">
                                  <label for="divisionName">Division</label>
                                  <select v-model="selectedDivisionForArrival" class="form-control" id="divisionName">
                                      <option disabled value="">Please select one</option>
                                      <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                                        {{ division.name }}
                                      </option>                             
                                  </select>
                                </div>        
                                <!-- City-->
                                <div class="form-group">
                                <label for="arrivalCity">City</label>                       
                                  <select v-model="selectedArrivalCity" class="form-control" id="arrivalCity">
                                      <option disabled value="">Please select one</option>
                                      <option v-for="city in arrivalCityList">
                                        {{ city.name }}
                                      </option> 
                                  </select>
                                </div>
                              </form>
                            </div>     
                            <div class="route-distance">
                              <form class="form-inline">
                                <div class="form-group">
                                  <label for="routeDistance">Route Distance</label>
                                  <input v-model="routeDistance" type="text" class="form-control" name="route_distance" id="routeDistance" placeholder="Distance">
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Fare Info -->
                    <div class="col-sm-12">
                      <div class="panel panel-success">
                        <div class="panel-heading">Enter Fare Info</div>
                        <div class="panel-body">
                          <div class="row col-sm-offset-2">
                            <!-- <div class="fare-info"> -->
                              <form>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label for="fareAC">AC</label>
                                    <input v-model="fare.ac" type="text" class="form-control" id="fareAC" placeholder="AC">
                                  </div>
                                </div>

                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label for="fareAC">Non AC</label>
                                    <input v-model="fare.non_ac" type="text" class="form-control" id="fareAC" placeholder="Non AC">
                                  </div>
                                </div>

                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label for="fareDeluxe">Deluxe</label>
                                    <input v-model="fare.deluxe" type="text" class="form-control" id="fareDeluxe" placeholder="Deluxe">
                                  </div>
                                </div>                                                            
                              </form>
                            <!-- </div> -->
                          </div> <!-- row -->
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="button-group">
                        <button v-on:click.prevent="addRoute()" class="btn btn-primary" :disabled="disableSaveButton">Add</button>
                        <button v-on:click.prevent="reset()" class="btn btn-primary" :disabled="disableResetButton">Reset</button>
                      </div>
                    </div>                      
                <!-- </form> -->
              </div>
          </div>
      </div>
      
      <loader :show="loading"></loader>

      <div class="row view-available-info">
        <div class="panel panel-info">
          <div class="panel-heading">Route Info <span> {{ availableRouteList.length }} </span></div>
          <div class="panel-body">
              <div id="scroll-routes">
                <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>From
                              <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                              </span>
                        </th>
                        <th>To                      
                             <!-- <span type="button" @click="isSortingAvailableBy('division')" :disabled="!disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span> -->
                        </th>
                        <th>Distance
                          <span type="button" @click="isSortingAvailableBy('distance')" :disabled="!disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                              </span>
                        </th>
                        <th>
                          Fare
                        </th>
                        <th>
                          Route ID
                        </th>
                        <th>Action</th>                                                         
                        <!-- <th>&nbsp;</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(route, index) in availableRouteList" >                              
                        <td>{{ index+1 }}</td>                              
                        <td>{{ route.departure_city }}</td>
                        <td>{{ route.arrival_city }}</td>                              
                        <td>{{ route.distance }}</td>
                        <td v-if="route.fare == null">N/A</td>                        
                        <td v-else> 
                          AC: {{ route.fare.details.ac }} </br>
                          Non-AC: {{ route.fare.details.non_ac }} </br> 
                          Deluxe: {{ route.fare.details.deluxe }} </br> 
                        </td>                              
                        <td><strong>{{ route.id }}</strong></td>
                        <td> 
                            <button v-on:click.prevent="editRoute(route)" class="btn btn-primary" :disabled="route.fare == null">
                              <i class="fa fa-edit fa-fw"></i>Edit
                            </button>  
                            <button v-on:click.prevent="removeRoute(route)" class="btn btn-danger">
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
            <!-- <show-alert :show="showAlert" :type="alertType" @cancel="showAlert=false">  -->
            <show-alert :show.sync="showAlert" :type="alertType"> 
              <!-- altert type can be info/warning/danger -->
              <strong>{{ routeName }} </strong> has been 
              <strong> {{ actionStatus }} </strong> successfully!
            </show-alert>
          </div>
        </div>
      </div>
      <!-- Modal -->              
      <!-- <modal :show="modal" @close="modal=false"> -->
      <modal v-show="modal" @close="cancelEdit">
        <div class="row">
            <div id="edit-route" class="col-sm-8 col-sm-offset-2">
              <div class="panel panel-default">
                <div class="panel-heading">Edit Fare Info.</div>                
                <div class="panel-body">
                  <span> Last Updated: <strong>{{ lastUpdatedAt }} </strong> </span>
                  </br></br>
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="fareAC">AC</label>
                        <input v-model="fare.ac" type="text" class="form-control" id="fareAC" placeholder="AC">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="fareAC">Non AC</label>
                        <input v-model="fare.non_ac" type="text" class="form-control" id="fareAC" placeholder="Non AC">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="fareDeluxe">Deluxe</label>
                        <input v-model="fare.deluxe" type="text" class="form-control" id="fareDeluxe" placeholder="Deluxe">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="panel-footer">
                      <button class="btn btn-primary" v-on:click.prevent="updateRouteFare()">Save</button>
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
            arrivalCityList: [],
            availableRouteList: [], 
            departureCityList: [],
            disableSaveButton: true,
            disableResetButton: true,
            disableSorting: true,
            divisionList: [],
            error: '',
            fare: {},            
            loading: false,
            lastUpdatedAt: '',
            modal: false,
            tempCityList: [],            
            response: '',
            routeDistance: '',
            routeId: '',
            routeName: '',
            //selectedCityId: '',
            selectedArrivalCity: '',
            //selectedDivisionForDepartureId: '',
            selectedDepartureCity: '',
            selectedDivisionForArrival: '',
            selectedDivisionForDeparture: '',
            show: false,
            showAlert: false,  
          }
        },
        mounted() {           
           this.fetchDivisions();
           this.fetchAvailableRoutes();           
           this.enableSlimScroll();
        },
        watch: {
            selectedDivisionForDeparture() {
                this.fetchCitiesByDivision(this.selectedDivisionForDeparture.id, 'departure'); // this.selectedDivisionForDepartureId
            },
            selectedDivisionForArrival() {
                this.fetchCitiesByDivision(this.selectedDivisionForArrival.id, 'arrival'); // this.selectedDivisionForDepartureId
            },
            arrivalCityList() {
              this.isSaveButtonEnable();
            },
            departureCityList() {    
              this.isSaveButtonEnable();                            
            },
        },
        methods: {
          addRoute() {
            var vm = this;
            //this.loading = true;
            // console.log('cityId',this.selectedCity.id);
            // console.log('cityName',this.selectedCity.name);
            axios.post('/route', {
                departure_city: this.selectedDepartureCity,
                arrival_city: this.selectedArrivalCity,
                distance: this.routeDistance,                
                fare: this.fare
            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                if (vm.response) {
                   //console.log(vm.response);
                   vm.fetchAvailableRoutes();
                   //vm.SortByCityNameAvailableRouteList(vm.availableRouteList);
                   vm.loading = false;
                   vm.disableSaveButton = true;
                   vm.routeAddedAlert(vm.selectedDepartureCity, vm.selectedArrivalCity);
                   vm.reset();
                   return;                   
                }
                vm.loading = false;
                vm.disableSaveButton = true;
            });
          },            
          cancelEdit() {
            this.fare = '';            
            this.modal = false;
          },
          editRoute(route) {  // role id of user/staff in roles table
                console.log('route fare=', route.fare.details);
                //this.fare = route.fare.details;
                this.routeId = route.id;
                this.lastUpdatedAt = route.fare.updated_at;
                this.fare = _.clone(route.fare.details); //cloning or coppy                
                this.modal = true;                
          },
          enableSlimScroll() {
                $('#scroll-routes').slimScroll({
                  color: '#00f',
                  size: '8px',
                  height: '500px',
                  //height: auto,
                  wheelStep: 10                  
                });
          },
          expandAddRoutePanel() {
            this.show = !this.show;
          },
          fetchCitiesByDivision(divisionId, status) {
            this.loading = true;
            this.tempCityList= [];     
            //this.departureCityList = [] ;
            var vm = this;                      
            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
            axios.get('/api/districts?q=' + divisionId)  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                  //response.data.error ? vm.error = response.data.error : vm.departureCityList = response.data;
                  response.data.error ? vm.error = response.data.error : vm.tempCityList = response.data;

                  if (status == 'arrival') {
                    vm.arrivalCityList = vm.tempCityList;
                    vm.loading = false;
                    return;                  
                  }
                  vm.departureCityList = vm.tempCityList;
                  vm.loading = false;

            });
          },
          fetchDivisions() {
            this.loading = true;
            this.divisionList= [];            
            var vm = this;                      
            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
            axios.get('/api/divisions')  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.divisionList = response.data;
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
                   vm.loading = false;
                   vm.SortByCityNameAvailableRouteList(vm.availableRouteList);                  
            });
          },

          isSaveButtonEnable() {

            this.disableSaveButton = ( (this.departureCityList.length < 1) || (this.arrivalCityList.length < 1) ) ? true : false; 
          },
          isSortingAvailableBy(val) {
            if (val== 'name') {
                this.SortByCityNameAvailableRouteList(this.availableRouteList);
                this.disableSorting = true;
                return;
            }
            this.SortByDistanceAvailableRouteList(this.availableRouteList);
            this.disableSorting = false;
          },

          removeRoute(route) {  // role id of user/staff in roles table
            var vm = this;            
            this.routeName = route.departure_city + ' to ' + route.arrival_city;
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
                        axios.post('/delete/route', {                            
                            route_id: route.id, 
                        })          
                        .then(function (response) {                                           
                            // response.data.error ? vm.error = response.data.error : vm.availableRouteList = response.data;
                            response.data.error ? vm.error = response.data.error : vm.response = response.data;

                            if (vm.response) {                                
                                vm.removeRouteFromAvailableRouteList(route.id); // update the array after removing
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
         
          removeRouteFromAvailableRouteList(routeId) {
            var indx = this.availableRouteList.findIndex(function(route){                 
                 return route.id == routeId;
            });        
            this.availableRouteList.splice(indx, 1);
            //return;
          },
          
          reset() {
            this.selectedArrivalCity = '';
            this.selectedDepartureCity = '';
            this.selectedDivisionForArrival = '';
            this.selectedDivisionForDeparture = '';
            this.routeDistance = '';
          },
          SortByCityNameAvailableRouteList(arr) {
            // sort by name            
                arr.sort(function(a, b) {
                  var nameA = a.departure_city.toUpperCase(); // ignore upper and lowercase
                  var nameB = b.departure_city.toUpperCase(); // ignore upper and lowercase
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
          SortByDistanceAvailableRouteList(arr) {
            // sort by distance 
                arr.sort(function(a, b) {
                  return a.distance - b.distance;
                });
          },
          routeAddedAlert(depatureCity, arrivalCity) {
              swal({
                //title: "Sorry! Not Available",
                title: '<span style="color:#A5DC86"> <strong>'+ depatureCity + '&nbsp;' +' to '+ '&nbsp;' + arrivalCity +'</strong></span></br> Route Added successfully!',
                //text: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span> Not Available.',
                html: true,
                //type: "info",
                type: "success",
                timer: 1800,
                showConfirmButton: false,
                allowOutsideClick: true,
              });
          },
          updateRouteFare() {
            var vm = this;
                this.response = '';
                this.showAlert = false;
                //this.staffName = staff.name;                
                this.loading = true;
                axios.post('/update/fare', {
                      route_id: this.routeId,
                      fare: this.fare                      
                    })          
                    .then(function (response) {                                           
                      //response.data.error ? vm.error = response.data.error : vm.staffs = response.data;
                      response.data.error ? vm.error = response.data.error : vm.response = response.data;
                      if (vm.response) {
                          vm.updateFareAtAvailableRouteList(vm.routeId, vm.fare);
                          vm.loading = false;
                          vm.modal = false;
                          vm.actionStatus = 'Udated';
                          vm.alertType = 'info';                          
                          vm.showAlert= true;                                                                        
                      }
                    });
          },

          updateFareAtAvailableRouteList(routeId, fare) {
             var indx = this.availableRouteList.findIndex(function(route){                                        
                    return route.id == routeId;
             });                                     
             this.availableRouteList[indx].fare.details = fare;
             this.routeName = this.availableRouteList[indx].departure_city + ' to ' + this.availableRouteList[indx].arrival_city;
             this.fare = '';
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