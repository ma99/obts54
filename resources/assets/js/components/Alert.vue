<template>
    <div v-show="false" 
      v-bind:class="{                        
          'alert-danger': (alertType == 'danger') ? true : false,          
          'alert-info': (alertType == 'info') ? true : false,          
          'alert-success': (alertType == 'success') ? true : false,          
          'alert-warning': (alertType == 'warning') ? true : false,          
       }" 
       id="status-alert"
    >
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>

      <slot></slot>

    </div>
</template>

<script>
    export default {      
      props: ['show', 'type'],
      // created() {        
      // },
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
            this.$emit('cancel');
        },
        type() {
          this.alertType = this.type;
        }
      }        
    }
</script>