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
                <form>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="divisionName">Departure: Division </label>
                        <select v-model="selectedDivisionForDeparture" class="form-control" id="divisionName">
                            <option disabled value="">Please select one</option>
                            <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                              {{ division.name }}
                            </option>                             
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="departureCity">Departure: City</label>
                        <select v-model="selectedDepartureCity" class="form-control" id="departureCity">
                            <option disabled value="">Please select one</option>
                            <!-- <option v-for="city in departureCityList" v-bind:valaue="{ id: division.id, name: division.name }"> -->
                            <option v-for="city in departureCityList">
                              {{ city.name }}
                            </option>                             
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="divisionName">Arrival: Division</label>
                        <select v-model="selectedDivisionForArrival" class="form-control" id="divisionName">
                            <option disabled value="">Please select one</option>
                            <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                              {{ division.name }}
                            </option>                             
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="arrivalCity">Arrival: City</label>                       
                        <select v-model="selectedArrivalCity" class="form-control" id="arrivalCity">
                            <option disabled value="">Please select one</option>                          
                            <option v-for="city in arrivalCityList">
                              {{ city.name }}
                            </option> 
                        </select>
                      </div>
                    </div>

                   <div class="col-sm-3">
                      <div class="form-group">
                        <label for="routeDistance">Distance</label>
                        <input v-model="routeDistance" type="text" class="form-control" name="route_distance" id="routeDistance" placeholder="Distance">
                      </div>
                    </div>

                   <!--  <div class="col-sm-2">
                      <div class="form-group">
                        <label for="cityCode">City Code</label>
                        <input v-model="selectedCity.id" type="text" class="form-control" name="code" id="cityCode" placeholder="City Code" disabled>
                      </div>
                    </div> -->

                    <div class="col-sm-4">
                      <div class="button-group">
                        <button v-on:click.prevent="saveCities()" class="btn btn-primary" :disabled="disableSaveButton">Save</button>
                        <button v-on:click.prevent="reset()" class="btn btn-primary" :disabled="disableResetButton">Reset</button>
                      </div>
                    </div>                      
                </form>
              </div>
          </div>
      </div>
      
      <loader :show="loading"></loader>

      <div class="row">
        <div class="panel panel-info">
          <div class="panel-heading">Route Info</div>
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
                        <th>Action</th>                                                         
                        <!-- <th>&nbsp;</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(city, index) in availableRouteList" >                              
                        <td>{{ index+1 }}</td>                              
                        <td>{{ city.departure_city }}</td>
                        <td>{{ city.arrival_city }}</td>                              
                        <td>{{ city.distance }}</td>                              
                        <td> 
                            <button v-on:click.prevent="removeCity(city)" class="btn btn-danger">                        
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
              <strong>{{ cityName }} </strong> has been 
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
        data() {
          return {
            actionStatus: '',
            alertType: '',
            arrivalCityList: [],
            cityName: '',
            tempCityList: [],
            availableRouteList: [], 
            departureCityList: [],
            disableSaveButton: true,
            disableResetButton: true,
            disableSorting: true,
            divisionList: [],
            error: '',
            loading: false,
            response: '',
            routeDistance: '',
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
            cityList() {                
                this.disableSaveButton = (this.cityList.length < 1) ? true : false; 
            },
        },
        methods: {
          enableSlimScroll() {
                $('#scroll-cities').slimScroll({
                  color: '#00f',
                  size: '8px',
                  height: '300px',
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
                   vm.loading = false;
                   vm.SortByCityNameAvailableRouteList(vm.availableRouteList);                  
            });
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

          removeCity(city) {  // role id of user/staff in roles table
            var vm = this;
            this.cityName = city.name; 
            swal({
                  title: "Are you sure?",
                  text: "This city will be Removed from Bus Service available City List!",
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
                        axios.post('/delete/city', {                            
                            city_code: city.code, 
                        })          
                        .then(function (response) {                                           
                            // response.data.error ? vm.error = response.data.error : vm.busAvailableToCityList = response.data;
                            response.data.error ? vm.error = response.data.error : vm.response = response.data;

                            if (vm.response) {                                
                                vm.removeCityFromBusAvailableToCityList(city.code); // update the array after removing
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
         
          removeCityFromBusAvailableToCityList(cityCode) {
            var indx = this.busAvailableToCityList.findIndex(function(city){ 
                // here 'city' is array object 
                 return city.code == cityCode;
            });        
            this.busAvailableToCityList.splice(indx, 1);
            //return;
          },
          saveCities() {
            var vm = this;
            //this.loading = true;
            // console.log('cityId',this.selectedCity.id);
            // console.log('cityName',this.selectedCity.name);
            axios.post('/routes', {
                departure_city: this.selectedDepartureCity,
                arrival_city: this.selectedArrivalCity,
                distance: this.routeDistance,
            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                if (vm.response) {
                   //console.log(vm.response);
                   vm.fetchAvailableRoutes();
                   //vm.SortByCityNameAvailableRouteList(vm.busAvailableToCityList);
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
          reset() {
            this.selectedArrivalCity = '';
            this.selectedDepartureCity = '';
            this.selectedDivisionForArrival = '';
            this.selectedDivisionForDeparture = '';
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
                title: '<span style="color:#A5DC86"> <strong>'+ depatureCity +'to'+ arrivalCity +'</strong></span></br> Route Added successfully!',
                //text: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span> Not Available.',
                html: true,
                //type: "info",
                type: "success",
                timer: 1800,
                showConfirmButton: false,
                allowOutsideClick: true,
              });
          }
        }
    }
</script>

<style lang="scss" scoped>
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