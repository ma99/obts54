<template>
  <div id="modal" class="modal">
    <div class="modal-content">
      <div class="circle">
          <span class="close" data-toggle="tooltip" data-placement="top" title="Press esc to close" @click="close">x</span>                  
      </div>         
      <slot></slot>      
    </div>          
  </div>   
</template>

<script>
    export default {            
      created() {
          document.addEventListener("keydown", (e) => {
            if (e.keyCode == 27) {
              this.close();
            }
          });
        },
      mounted() {
          console.log('model component mounted.')
      },
      methods: {
        close() {                
                this.$emit('close');
            },
      }      
    }
</script>
<style lang="scss" scoped>
    /* The Modal (background) */
      .modal {
          display: block; 
          position: fixed; /* Stay in place */
          z-index: 1111; /* Sit on top */
          left: 0;
          top: 0;
          width: 100%; /* Full width */
          height: 100%; /* Full height */
          overflow: auto; /* Enable scroll if needed */
          background-color: rgb(0,0,0); /* Fallback color */
          background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      }

      /* Modal Content/Box */
      .modal-content {
          background-color: #fefefe;
          margin: 160px auto; /* 15% from the top and centered */
          /*padding: 20px;*/
          padding: 35px 20px 30px;
          border: 1px solid #888;
          width: 89%; /* Could be more or less, depending on screen size */
      }

        /* circle*/
       .circle {
          float: right;
          margin-top: -28px;
          position: relative;
          width: 24px; 
          height: 24px; 
          background: #3c8dbc; 
          border-radius: 12px; 
          -moz-border-radius: 15px; 
          -webkit-border-radius: 15px; 
          
      }
      /* The Close Button */
      .close {
          color: #fff;
          /*float: right;*/
          margin-left: 7px;
          font-size: 20px;
          font-weight: bold;
          position: absolute;
          /*margin-top: -18px;*/
      }    

      .close:hover,
      .close:focus {
          color: black;
          text-decoration: none;
          cursor: pointer;
      }    
</style>