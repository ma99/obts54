<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <form>
                       <select v-model="selected">
                          <option>A</option>
                          <option>B</option>
                          <option>C</option>
                        </select>
                        <span>Selected: {{ selected }} </span>                       
                        <input v-model="message" placeholder="edit me">
                        <p>Message is: {{ message }} </p>
                      <button v-on:click.prevent="dataPass" class="btn btn-default">Submit</button>
                      
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      data() {
          return {                  
              selected: 'A',
              message: ''
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
          console.log('Seat seach Component ready.')
      }
    }   
           
</script>
