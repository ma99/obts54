<template>
    <!-- <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default"> -->
                <div>
                    <form>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="cityFrom"> From</label>
                          <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
                          <select v-model="selected" class="form-control" id="cityFrom">
                            <option disabled value="">Please select one</option>
                            <option v-for="city in cityList">
                              {{ city.name }}
                            </option>                           
                          </select>
                        </div>
                      </div>  

                      <div class="col-md-3">  
                        <div class="form-group">
                          <label for="cityTo">To</label>  
                          <select v-model="selectedTo" class="form-control" id="cityTo">
                            <option v-if="!error" disabled value="">Please select one</option>
                            <option v-if="error" disabled value="">{{ error }}</option>
                            <!-- <span v-if="error"> {{ error }} </span> -->
                            <option v-for="city in cityToList">
                              {{ city.arrival_city }}                            
                            </option>                          
                          </select>                         
                        </div>
                      </div>

                        <!-- <span>Selected: {{ selected }} </span>                       
                        <input v-model="message" placeholder="edit me">
                        <p>Message is: {{ message }} </p> -->
                        <!-- <input type="text" id="startDate" v-model="startDate"> -->
                      <div class="col-md-4">
                        <div class="form-group">  
                            <label for="startDate">Select Date</label> 
                            <div id="sandbox-container">
                              <div class="input-group date">
                                <input id="startDate" class="form-control" type="text" v-model="startDate" placeholder="select date">
                                <span class="input-group-addon">
                                 <!--  <i class="glyphicon glyphicon-th"></i> -->
                                  <i class="glyphicon glyphicon-calendar"></i>
                                </span>
                              </div>
                            </div>
                        </div>
                       </div>  

                      <div class="col-md-2">
                        <button v-on:click.prevent="dataPass" class="btn btn-primary btn-search form-control">Search</button>
                      </div>
                    
                    </form>
                    <div class="panel-body">
                        <table class="table table-striped task-table">

                            <!-- Table Headings -->
                            <thead>
                                <th>SL No.</th>                                
                                <th>Dept. Time</th>                                
                                <th>Arr. Time</th>                                
                                <th>Type</th>                                
                                <th>Available Seats</th>                                
                                <th>Fare</th>                                
                                <th>View</th>
                                <th>&nbsp;</th>
                            </thead>

                            <!-- Table Body -->
                            <tbody>
                               <!--  @foreach ($tasks as $task) -->
                                    <tr v-for="(bus, index) in buses">
                                    
                                        <!-- slNo += 1 -->
                                        <!-- {{ increment }} -->
                                        <!-- {{ showslNo }} -->
                                        <td class="table-text">
                                          <div> {{ index + 1 }} </div>
                                        </td>

                                        <td class="table-text">
                                          <div> {{ bus.departure_time }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> {{ bus.arrival_time }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> {{ bus.bus_type }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> {{ bus.available_seats }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> {{ bus.fare }} </div>
                                        </td>
                                        <td class="table-text">
                                          <div> 
                                            <button class="btn btn-success">View</button> 
                                          </div>
                                        </td>
                                    </tr>
                                    <tr> 
                                      <td class="bg-danger" v-show="busError">
                                       <div> {{ busError }} </div>                                        
                                      </td>
                                    </tr>
                                    <!-- <span class="bg-danger" v-show="busError"> {{ busError }} </span> -->
                                <!-- @endforeach -->
                            </tbody>
                        </table>
            </div>
                    
                  </div>  

                    
                <!-- </div>
            </div>
        </div>
    </div> -->
</template>

<script>
    export default {
      props: ['cities'],
      data() {
          return {   
              startDate: '',               
              selected: '',
              selectedTo: '',             
              message: '',
              error: false,
              busError: false,
              cityList:[],
              cityToList:[],
              buses:[]
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
         //this.arr.push(val);
       }
      },
      // computed: {
      // },
      methods: {
        dataPass() {
          console.log(this.selected);
          this.busError = false;
           
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

        fetchCityToList(cityName) {
          
          this.error = false;
          this.cityToList = [];
          var vm = this;
          axios.get('api/city?q=' + cityName)          
            .then(function (response) {
              //vm.answer = _.capitalize(response.data.answer)
               console.log(response.data);
               response.data.error ? vm.error = response.data.error : vm.cityToList = response.data;
               console.log(vm.error);
               //vm.cityToList = response.data;
               //vm.message= response.data
            });
        },
        showDate() {
            var vm = this;
           // $('#startDate').datepicker({
           //              format: 'dd/mm/yyyy'                     
           //          }).on("changeDate", () => {vm.startDate = $('#startDate').val()});

           $('#sandbox-container .input-group.date').datepicker({
                        format: 'dd/mm/yyyy',
                        startDate: '0d'                     
                    }).on("changeDate", () => {vm.startDate = $('#sandbox-container #startDate').val()});

        },
        testDate() {
          console.log(this.startDate); // the startDate value is ''
        }
      }
      
    }              
</script>

<style>
  @media (min-width: 992px) { 
    .btn-search {
      margin-top: 25px;
    }
  }
</style>