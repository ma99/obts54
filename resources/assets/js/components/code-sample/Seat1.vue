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
                       
                        <span>Selected: {{ selected }} </span>                       
                        <input v-model="message" placeholder="edit me">
                        <p>Message is: {{ message }} </p>
                        <select v-model="selectedTo" class="form-control">
                          <option disabled value="">Please select one</option>
                          <option v-for="city in cityListTo">
                            {{ city.name }}
                          </option>                          
                        </select>
                      <button v-on:click.prevent="dataPass" class="btn btn-default">Submit</button>
                      
                    </form>
                    <!-- <ul class="list-group">
                      <li class="list-group-item" v-for="city in cityList">
                        {{ city.name }}                                              
                      </li>
                    </ul> -->
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
              selected: '',
              selectedTo: '',
              message: '',
              cityList:[],
              cityListTo:[],

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
        }
      },
      mounted() {
          console.log('Seat search Component ready.');
          this.cityList = JSON.parse(this.cities);
      }
    }   
           
</script>