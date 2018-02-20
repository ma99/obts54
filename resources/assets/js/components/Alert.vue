<template>
    <div v-show="show" class="alert-style"
      v-bind:class="{                        
          'alert-danger': (alertType == 'danger') ? true : false,          
          'alert-info': (alertType == 'info') ? true : false,          
          'alert-success': (alertType == 'success') ? true : false,          
          'alert-warning': (alertType == 'warning') ? true : false,          
       }" 
       id="status-alert"
    >
      <button  v-on:click="close()" type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>

      <slot></slot>

    </div>
</template>

<script>
    export default {      
      props: ['show', 'type'],      
      data() {
        return {
          alertType: '',
        }
      },

      methods: {
        showAlert() {
          $("#status-alert").alert();
          $("#status-alert").fadeTo(2000, 500)
          .slideUp(500, function(){
              $("#status-alert").slideUp(500);
          });   
        },
        close() {
          this.$emit('update:show', false);          
        }         
      },
      mounted() {
          console.log('show alert Component mounted.');
          //this.alertTypeSelection;
          this.alertType = this.type;
      },
      watch: {
        show() {            
            this.showAlert();            
        },
        type() {
          this.alertType = this.type;
        }
      }        
    }
</script>
<style lang="scss" scoped>
  .alert-style {
    font-size: 1rem;
    padding: 0.625rem;  
  }
</style>