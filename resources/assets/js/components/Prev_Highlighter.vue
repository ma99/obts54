<template>
    <span v-bind:style="highLightBackGround">        
        <slot></slot>        
    </span>
</template>

<script>
    export default {
        props: ['color', 'value'],
        data() {
            return {                
              highLightBackGround: {
                background: '',
                borderRadius: '', //this.borderRadiusValue + 'px' //'13px'
                padding: '5px 10px',
                color: '#fff'
              }
            }
        },
        mounted() {
            //console.log('Component mounted.')            
            this.highLightBackGround.background = this.color;
            this.highLightBackGround.borderRadius = this.value + 'px';            
        },
        watch: {
            color() {
                this.highLightBackGround.background = this.color;
            }
        }
    }
</script>