<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <form>
                        
                        <select v-model="selected" class="form-control">
                          <option disabled value="">Please select one</option>                        
                          <option v-for="city in cityList">
                            {{ city.name }}
                          </option>                           
                        </select>

                        <select v-model="selectedTo" class="form-control">
                          <option v-if="!error" disabled value="">Please select one</option>
                          <option v-if="error" disabled value="">{{ error }}</option>
                          <!-- <span v-if="error"> {{ error }} </span> -->
                          <option v-for="city in cityToList">
                            {{ city.arrival_city }}                            
                          </option>                          
                        </select> 
                       
                        <span>Selected: {{ selected }} </span>                       
                        <input v-model="message" placeholder="edit me">
                        <p>Message is: {{ message }} </p>
                        <!-- <input type="text" id="startDate" v-model="startDate"> -->
                        
                        <div id="sandbox-container" class ="col-md-5">
                          <div class="input-group date">
                            <input id="startDate" class="form-control" type="text" v-model="startDate" placeholder="select date">
                            <span class="input-group-addon">
                             <!--  <i class="glyphicon glyphicon-th"></i> -->
                              <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                          </div>
                        </div>
                        <p> date is:  {{ startDate }} </p>
                        
                                                 
                        
                      <button v-on:click.prevent="dataPass" class="btn btn-default">Submit</button>
                      
                    </form>
                    <ul class="list-group">
                      <li class="list-group-item" v-for="city in cityToList">
                        {{ city.arrival_city }}                                
                      </li>                      
                      <span v-if="error"> {{ error }} </span>
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
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
              cityList:[],
              cityToList:[]
              

          }
      },
      watch: {
       selected(val) {
          console.log(val);
          this.fetchCityToList(val);          
         //this.arr.push(val);
       }

      },
      methods: {
        dataPass() {
          console.log(this.selected)
          var vm = this
          axios.post('/home', {
              firstName: this.selected,
              lastName: 'Flintstone'
            })          
            .then(function (response) {
              //vm.answer = _.capitalize(response.data.answer)
               console.log(response.data)
               vm.message= response.data
            });
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
                        format: 'dd/mm/yyyy'                     
                    }).on("changeDate", () => {vm.startDate = $('#sandbox-container #startDate').val()});

        }
      },
      mounted() {
           console.log('Seat search Component ready.');
           this.cityList = JSON.parse(this.cities);         
           this.showDate();
         
      }
    }   
           
</script>