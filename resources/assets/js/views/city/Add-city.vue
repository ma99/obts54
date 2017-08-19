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
              <div class="panel-heading">Add New City</div>
              <div class="panel-body">
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
                        <label for="cityName"> City Name </label>                       
                        <select v-model="selectedCity" class="form-control" name="name" id="cityName">
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
          <div class="panel-heading">City Info</div>
          <div class="panel-body">
            <table class="table .table-striped">
                <thead>
                  <tr>
                    <th>Sl. No.</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Division</th>
                    <th>&nbsp;</th>              
                  </tr>
                </thead>
                <tbody>
                  <tr  v-for="(city, index) in busAvailableToCityList" >                              
                    <td>{{ index+1 }}</td>                              
                    <td>{{ city.name }}</td>                              
                    <td>{{ city.id }}</td>                              
                    <td>{{ city.division }}</td>
                  </tr>                            
                </tbody>
            </table>                                        
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
            cityList: [],
            busAvailableToCityList: [], //bus service availble to the cities
            divisionList: [],
            disableSaveButton: true,
            disableResetButton: true,
            error: '',
            loading: false,
            response: '',
            //selectedCityId: '',
            selectedCity: '',
            //selectedDivisionId: '',
            selectedDivision: '',
            

          }
        },
        mounted() {           
           this.fetchDivisions();
           this.fetchBusAvailableToCities();
        },
        watch: {
            selectedDivision() {
                this.fetchCitiesByDivision(this.selectedDivision.id); // this.selectedDivisionId
            },
            cityList() {                
                this.disableSaveButton = (this.cityList.length < 1) ? true : false; 
            }            
        },
        methods: {
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
            });
          },
          saveCities() {
            var vm = this;
            //this.loading = true;
            console.log('cityId',this.selectedCity.id);
            console.log('cityName',this.selectedCity.name);
            axios.post('/cities', {
                city_id: this.selectedCity.id,
                city_name: this.selectedCity.name,
                division: this.selectedDivision.name,
            })          
            .then(function (response) {
                   console.log(response.data);
                    response.data.error ? vm.error = response.data.error : vm.response = response.data;
                   vm.loading = false;
                   vm.disableSaveButton = true;
            });

          },
        }
    }
</script>