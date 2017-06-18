<template>
    <span v-bind:class="{                        
          'highlight-danger': (colorName == 'danger') ? true : false,          
          'highlight-info': (colorName == 'info') ? true : false,          
          'highlight-success': (colorName == 'success') ? true : false,          
          'highlight-warning': (colorName == 'warning') ? true : false,
          'curved': (curveActive == 'true') ? true : false, 

       }" 
       id="highlight-background"
    >   
        <slot></slot>        
    </span>
</template>

<script>
    export default {
        props: ['color', 'curve'],
        data() {
            return {
                colorName: '',
                curveActive: false,
                //curveValue: '10px',
            }
        },
        mounted() {
            //console.log('Component mounted.')
            this.colorName = this.color;
            this.curveActive = this.curve;            
        }
    }
</script>