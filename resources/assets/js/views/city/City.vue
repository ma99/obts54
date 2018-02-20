<template>
  <div>    
     <section class="content-header">
      <h1>
       Add new city
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/dashboard" exact>
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li>
        <li class="active">city</li>
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
          <div class="panel-heading">Service Available City Info</div>
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
                        <th>Code</th>
                        <th>Division                            
                             <span type="button" @click="isSortingAvailableBy('division')" :disabled="!disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span>
                        </th>
                        <th>Action</th>                                                         
                        <!-- <th>&nbsp;</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(city, index) in busAvailableToCityList" >                              
                        <td>{{ index+1 }}</td>                              
                        <td>{{ city.name }}</td>                              
                        <td>{{ city.code }}</td>                              
                        <td>{{ city.division }}</td>
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
            cityList: [],
            cityName: '',
            busAvailableToCityList: [], //bus service availble to the cities
            divisionList: [],
            disableSaveButton: true,
            disableResetButton: true,
            disableSorting: true,
            error: '',
            loading: false,
            response: '',
            //selectedCityId: '',
            selectedCity: '',
            //selectedDivisionId: '',
            selectedDivision: '',
            show: false,
            showAlert: false,  
          }
        },
        mounted() {           
           this.fetchDivisions();
           this.fetchBusAvailableToCities();           
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
          enableSlimScroll() {
                $('#scroll-cities').slimScroll({
                  color: '#00f',
                  size: '8px',
                  height: '500px', //300px
                  //height: auto,
                  wheelStep: 10                  
                });
          },
          expandAddCityPanel() {
            this.show = !this.show;
          },
          fetchCitiesByDivision(divisionId) {
            this.loading = true;
            //this.cityList= [];            
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
            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
            axios.get('/api/divisions')  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.divisionList = response.data;
                   vm.loading = false;                  
            });
          },
          fetchBusAvailableToCities() {
            this.loading = true;
            this.busAvailableToCityList= [];            
            var vm = this;                
            axios.get('/api/cities')  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.busAvailableToCityList = response.data;
                   vm.loading = false;
                   vm.SortByCityNameBusAvailableToCityList(vm.busAvailableToCityList);                  
            });
          },
          isSortingAvailableBy(val) {
            if (val== 'name') {
                this.SortByCityNameBusAvailableToCityList(this.busAvailableToCityList);
                this.disableSorting = true;
                return;
            }
            this.SortByDivisionBusAvailableToCityList(this.busAvailableToCityList);
            this.disableSorting = false;
          },

          removeCity(city) {  // role id of user/staff in roles table
            var vm = this;
            this.cityName = city.name; 
            swal({
              title: "Are you sure?",
              text: "This CITY will be Removed!",
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
                
              } 
              
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
            console.log('cityId',this.selectedCity.id);
            console.log('cityName',this.selectedCity.name);
            axios.post('/cities', {
                city_id: this.selectedCity.id,
                city_name: this.selectedCity.name,
                division_name: this.selectedDivision.name,
            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                if (vm.response) {
                   //console.log(vm.response);
                   vm.fetchBusAvailableToCities();
                   vm.SortByCityNameBusAvailableToCityList(vm.busAvailableToCityList);
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
          },
          SortByCityNameBusAvailableToCityList(arr) {
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
          SortByDivisionBusAvailableToCityList(arr) {
            // sort by name            
                arr.sort(function(a, b) {
                  var nameA = a.division.toUpperCase(); // ignore upper and lowercase
                  var nameB = b.division.toUpperCase(); // ignore upper and lowercase
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
          cityAddedAlert(cityName) {
              swal({
                //title: "Sorry! Not Available",
                //title: '<span style="color:#A5DC86"> <strong>'+cityName+'</strong></span></br> Added successfully!',
                title: cityName,
                text: 'Added successfully!', 
                //text: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span> Not Available.',
                //html: true,
                //type: "info",
                icon: "success",
                timer: 2000,
                closeOnClickOutside: false,
              });
          }
        }
    }
</script>

<style lang="scss" scoped>
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