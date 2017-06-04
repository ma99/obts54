<template>
    <!-- Left Side Of Navbar -->
    <div class="sidebar" role="navigation">
        <!-- {{-- <div class="sidebar-nav collapse navbar-collapse" id="app-navbar-collapse"> --}} -->
        <div class="sidebar-nav collapse navbar-collapse" id="app-navbar-collapse">
            <!-- <div class="sidebar-head">
                <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
            </div> -->
            <ul class="nav" id="side-menu">
                <li>
                    <a href="index.html" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>Dashboard</a>
                </li>
                <li>
                    <h2>User</h2>
                    <ul>
                        <li> <a href="profile.html" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Profile</a> </li>
                        <li>Set Roles</li>
                        <li>View List</li>
                    </ul>
                    
                </li>
                <li>
                    <a href="basic-table.html" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i>Basic Table</a>
                </li>
                <li>
                    <a href="fontawesome.html" class="waves-effect"><i class="fa fa-font fa-fw" aria-hidden="true"></i>Icons</a>
                </li>
                <li>
                    <a href="map-google.html" class="waves-effect"><i class="fa fa-globe fa-fw" aria-hidden="true"></i>Google Map</a>
                </li>
                <li>
                    <a href="blank.html" class="waves-effect"><i class="fa fa-columns fa-fw" aria-hidden="true"></i>Blank Page</a>
                </li>                        
            </ul>                    
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style>
    .sidebar h2.is-active::after {
     transform: rotate(90deg);
    }
    .sidebar h2::after {
        border-color: transparent transparent transparent #dee0df;
        border-style: solid;
        border-width: 4px;
        height: 0;
        position: absolute;
        right: 0;
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
    }
</style>