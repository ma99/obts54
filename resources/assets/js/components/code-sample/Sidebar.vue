<template>
    <!-- Left Side Of Navbar -->
    <div class="sidebar" role="navigation">
        <!-- {{-- <div class="sidebar-nav collapse navbar-collapse" id="app-navbar-collapse"> --}} -->
        <div class="sidebar-nav collapse navbar-collapse" id="app-navbar-collapse">
            <!-- <div class="sidebar-head">
                <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
            </div> -->
            <ul class="nav" id="side-menu">
               <li @click="showChildren=false">                
                    <router-link class="waves-effect" to="/dashboard" exact><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>Dashboard</router-link>
                </li>
                <li>
                    <h2 @click="toggle()" v-bind:class="{'is-active': showChildren}">
                        <i class="fa fa-user fa-fw" aria-hidden="true"></i>User
                    </h2>
                    <ul v-show="showChildren">
                        <li>
                            <router-link class="waves-effect" to="/profile">
                                <i class="fa fa-address-card fa-fw" aria-hidden="true"></i>
                                Profile
                            </router-link> </li>
                        <li> 
                            <router-link class="waves-effect" to="/roles">
                                <i class="fa fa-plus fa-fw" aria-hidden="true"></i>                    
                                Set Roles
                            </router-link> </li>
                        <li>
                            <router-link class="waves-effect" to="/staff-list">
                                <i class="fa fa-address-book-o fa-fw" aria-hidden="true"></i>
                                Admin Staff
                            </router-link>
                        </li>                        
                    </ul>                    
                </li>
                <li @click="showChildren=false">
                    <a href="basic-table.html" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i>Basic Table</a>
                </li>
                <li @click="showChildren=false">
                    <a href="fontawesome.html" class="waves-effect"><i class="fa fa-font fa-fw" aria-hidden="true"></i>Icons</a>
                </li>
                <li @click="showChildren=false">
                    <a href="map-google.html" class="waves-effect"><i class="fa fa-globe fa-fw" aria-hidden="true"></i>Google Map</a>
                </li>
                <li @click="showChildren=false">
                    <a href="blank.html" class="waves-effect"><i class="fa fa-columns fa-fw" aria-hidden="true"></i>Blank Page</a>
                </li>                        
            </ul>                    
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showChildren: false,
            }
        },
        methods: {
            toggle() {
                this.showChildren = ! this.showChildren;
            }

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style>

    /*
    .sidebar h2.is-active::after {
     transform: rotate(90deg);
     margin-right: 3px;
    }
    .sidebar h2::after {
        border-color: transparent transparent transparent #dee0df;
        border-style: solid;
        border-width: 5px;
        height: 0;
        position: absolute;
        right: 3px; 
        top: 1.15rem;
        width: 0;
    }
    .sidebar h2::after {
        content: "";
    }
    .sidebar h2 {
        border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        margin: 0;
        padding: 0.75rem 0.75rem 0.75rem 0;
        transition: color 0.1s linear 0s;
    }*/
</style>