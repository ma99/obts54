<template>
  <div id="loader" class="modal" v-show="loading">
    <div class="modal-content">      
      <div class="loading"><i class="fa fa-spinner fa-pulse fa-3x text-primary"></i></div>
      <!-- <slot></slot> -->      
    </div>          
  </div>   
</template>

<script>
    export default {   
      props: ['show'],         
      // created() {
      //     document.addEventListener("keydown", (e) => {
      //       if (e.keyCode == 27) {
      //         this.close();
      //       }
      //     });
      //   },
      data() {
        return {
          loading: false,
        }
      },
      mounted() {
          console.log('loader component mounted.')
          //this.loading = false;
      },
     watch: {
      show() {
        this.loading = this.show;
      }
     }
    }
</script>
<style lang="scss" scoped>
    /* The Modal (background) */
    #loader {
      &.modal {
          display: block; 
          position: absolute; //* Stay in place */
          z-index: 99999; //* Sit on top */
          //left: 0;
          top: 0;
          width: 100%; //* Full width */
          height: 100%; //* Full height */
          overflow: auto; //* Enable scroll if needed */
          background-color: rgb(0,0,0); //* Fallback color */
          background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
          /* Modal Content/Box */
        > .modal-content {
            background-color: #fefefe;
            margin: 160px auto; //* 15% from the top and centered */
            /*padding: 20px;*/
            padding: 35px 20px 30px;
            position: relative;
            top: 25%;
            border: 1px solid #888;
            width: 10%; //* Could be more or less, depending on screen size */
          > .loading {
              text-align: center;
            }
        }
      }
    }
      
</style>