<template>
  <div>    
     <section class="content-header">
      <h1>
       Add new stop
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/dashboard" exact>
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li>
        <li class="active">stop</li>
      </ol>
    </section>

    <section class="content">      
      <div class="row">
          <div class="panel panel-default">
              <div class="panel-heading">
                <!-- Add New City -->
                <span class="input-group-btn">
                    <button class="btn btn-success" type="button" @click="expandAddCityPanel" v-show="!show">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-warning" type="button" @click="expandAddCityPanel" v-show="show">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </span>
                
              </div>
              <div class="panel-body" v-show="show">
                <form>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="divisionName">Division Name</label>
                        <select v-model="selectedDivision" class="form-control" id="divisionName">
                            <option disabled value="">Please select one</option>
                            <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                              {{ division.name }}
                            </option>                             
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="cityName">City Name </label>                       
                        <select v-model="selectedCity" class="form-control" id="cityName">
                            <option disabled value="">Please select one</option>                          
                            <option v-for="city in cityList" v-bind:value="{ id: city.id, name: city.name }">
                              {{ city.name }}
                            </option> 
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="cityCode">City Code</label>
                        <input v-model="selectedCity.id" type="text" class="form-control" name="code" id="cityCode" placeholder="City Code" disabled>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="routeDistance">Stop Name</label>
                        <input v-model="stopName" type="text" class="form-control" name="route_distance" id="routeDistance" placeholder="Stop Name">
                      </div>                      
                    </div>

                    <div class="col-sm-1">
                      <button v-on:click.prevent="addStop()" class="btn btn-primary" :disabled="isButtonDisable('add')">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                      </button>                   
                    </div>                    

                  </form>

                  <div v-show="stopList.length > 0" class="col-sm-12">
                     <!-- stops list -->
                      <div class="panel panel-primary">
                      <div class="panel-heading">Stop's List</div>
                      <div class="panel-body">
                          <div id="scroll-stops">
                            <table class="table table-striped table-hover">
                                <thead>
                                  <tr>
                                    <th>Sl. No.</th>
                                    <th>Name
                                         <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                            <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                        </span>
                                    </th>
                                    <th>City Id
                                      <span type="button" @click="isSortingAvailableBy('city_id')" :disabled="!disableSorting">
                                            <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                        </span>
                                    </th>                        
                                    <th>Action</th>                                                         
                                    <!-- <th>&nbsp;</th> -->
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr  v-for="(stop, index) in stopList" >                              
                                    <td>{{ index+1 }}</td>                              
                                    <td>{{ stop.name }}</td>                              
                                    <td>{{ stop.city_id }}</td>                              
                                    <!-- <td>{{ city.division }}</td> -->
                                    <td> 
                                        <button v-on:click.prevent="removeStopFromStopLis(index)" class="btn btn-danger">
                                          <i class="fa fa-times fa-fw"></i>
                                        </button>  
                                    </td>                        
                                  </tr>                            
                                </tbody>
                            </table>      
                          </div>
                      </div>                     
                    </div>
                  </div>  
                  <div class="col-sm-4">
                    <div class="button-group">
                      <button v-on:click.prevent="saveStops()" class="btn btn-primary" :disabled="isButtonDisable('save')">Save</button>
                      <button v-on:click.prevent="reset()" class="btn btn-primary" :disabled="isButtonDisable('reset')">Reset</button>
                    </div>
                  </div>                                      
              </div>
          </div>         
      </div> <!-- row -->
      
      <loader :show="loading"></loader>

      <div class="row view-available-info">
        <div class="panel panel-info">
          <div class="panel-heading">Available Stops <span> {{ availableStopList.length }} </span></div>
          <div class="panel-body">
              <div id="scroll-cities">
                <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Name
                             <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span>
                        </th>
                        <th>City Id
                          <span type="button" @click="isSortingAvailableBy('city_id')" :disabled="!disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span>
                        </th>                        
                        <th>Action</th>                                                         
                        <!-- <th>&nbsp;</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(stop, index) in availableStopList" >                              
                        <td>{{ index+1 }}</td>                              
                        <td>{{ stop.name }}</td>                              
                        <td>{{ stop.city_id }}</td>                              
                        <!-- <td>{{ city.division }}</td> -->
                        <td> 
                            <button v-on:click.prevent="removeStop(stop, index)" class="btn btn-danger">
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
              <strong>{{ deletedStopName }} </strong> has been 
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
            availableStopList: [],
            cityList: [],
            cityName: '',            
            deletedStopName: '',
            divisionList: [],
            disableSorting: true,
            error: '',
            loading: false,
            response: '',            
            selectedCity: '',            
            selectedDivision: '',
            show: false,
            showAlert: false,
            stopList: [],
            stopName: '',
          }
        },
        mounted() {           
           this.fetchDivisions();                 
           this.fetchAvailableStopList();           
           this.enableSlimScroll();
        },
        watch: {
            selectedDivision() {
                this.fetchCitiesByDivision(this.selectedDivision.id); // this.selectedDivisionId
            },
            cityList() {                
                this.disableSaveButton = (this.cityList.length < 1) ? true : false; 
            },           
        },
        methods: {
          addStop() {
            var vm = this;
            this.stopList.push({
              city_id: vm.selectedCity.id,
              name: vm.stopName
            });
            this.stopName = '';           
          },
          enableSlimScroll() {
                $('#scroll-cities',).slimScroll({
                  color: '#00f',
                  size: '8px',
                  height: '500px',
                  //height: auto,
                  wheelStep: 10                  
                });

                $('#scroll-stops',).slimScroll({
                  color: '#00f',
                  size: '8px',
                  height: '200px',
                  //height: auto,
                  wheelStep: 10                  
                });
          },
          expandAddCityPanel() {
            this.show = !this.show;
          },
          fetchCitiesByDivision(divisionId) {
            this.loading = true;                     
            var vm = this;                      
            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
            axios.get('/api/districts?q=' + divisionId)  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.cityList = response.data;
                   vm.loading = false;                  
            });
          },
          fetchDivisions() {
            this.loading = true;
            this.divisionList= [];            
            var vm = this;               
            axios.get('/api/divisions')  
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.divisionList = response.data;
                   vm.loading = false;                  
            });
          },
          fetchAvailableStopList() {
            this.loading = true;
            this.availableStopList= [];            
            var vm = this;                
            axios.get('/api/stops') 
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.availableStopList = response.data;
                   vm.loading = false;
                   vm.SortByStopNameAvailableStopList(vm.availableStopList);                  
            });
          },
          isButtonDisable(btnType) { 
            switch (btnType) {
                case 'add':
                    return ( this.stopName == '' || this.selectedCity == '' || this.selectedDivision == '') ? true : false;           
                    break;
                case 'reset':
                    return ( this.stopName == '' && this.selectedCity == '' && this.selectedDivision == '') ? true : false; 
                    break;          
                case 'save':
                    return (this.stopList.length < 1) ? true : false;         
                    break;                  
                default:
                    return true;
            }
          },
          isSortingAvailableBy(val) {
            if (val== 'name') {
                this.SortByStopNameAvailableStopList(this.availableStopList);
                this.disableSorting = true;
                return;
            }
            this.SortByCityCodeAvailableStopList(this.availableStopList);
            this.disableSorting = false;
          },

          removeStop(stop, index) {  // role id of user/staff in roles table
            var vm = this;
            this.deletedStopName = stop.name; 
            swal({
              title: "Are you sure?",
              text: "This STOP will be Removed!",
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
                axios.post('/delete/stop', {                            
                    stop_id: stop.id, 
                })          
                .then(function (response) {                           
                    response.data.error ? vm.error = response.data.error : vm.response = response.data;

                    if (vm.response) {                                
                        vm.removeStopFromAvailableStopList(index); // update the array after removing                                
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
         
          removeStopFromAvailableStopList(index) {
            // var indx = this.busAvailableToCityList.findIndex(function(city){ 
            //     // here 'city' is array object 
            //      return city.code == cityCode;
            // });        
            this.availableStopList.splice(index, 1);            
            //return;
          },
          
          removeStopFromStopLis(index) {
            this.stopList.splice(index, 1);
          },

          saveStops() {
            var vm = this;
            //this.loading = true;            
            axios.post('/stops', {
                city_id: this.selectedCity.id,                
                stop_list: this.stopList
            })          
            .then(function (response) {                
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                if (vm.response) {                   
                   vm.fetchAvailableStopList();
                   vm.SortByStopNameAvailableStopList(vm.availableStopList);
                   vm.stopList = [],
                   vm.loading = false;
                   vm.disableSaveButton = true;
                   vm.cityAddedAlert(vm.selectedCity.name);
                   vm.reset();
                   return;                   
                }
                vm.loading = false;
                vm.disableSaveButton = true;
            });
          },
          reset() {
            this.selectedCity = '';
            this.selectedDivision = '';
            this.stopName = '';
          },
          SortByStopNameAvailableStopList(arr) {
            // sort by name            
                arr.sort(function(a, b) {
                  var nameA = a.name.toUpperCase(); // ignore upper and lowercase
                  var nameB = b.name.toUpperCase(); // ignore upper and lowercase
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
          SortByCityCodeAvailableStopList(arr) {
            arr.sort(function(a, b) {
                  return a.city_id - b.city_id;
                });
          },
          cityAddedAlert(cityName) {
              swal({
                //title: "Sorry! Not Available",
                title: 'Bus Stops for '+cityName+' ',
                text: "Added successfully!",
                //text: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span> Not Available.',
                //html: true,
                //type: "info",
                icon: "success",
                timer: 2000,
                closeOnClickOutside: true,
              });
          }
        }
    }
</script>

<style lang="scss" scoped>
     .view-available-info .panel-heading span {
      background-color: yellow;
      font-weight: 600;
      float: right;
      padding: 2px 6px;
      color: royalblue;
    }
    #scroll-cities {
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