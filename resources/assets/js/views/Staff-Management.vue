<template>
<!-- Content Wrapper. Contains page content -->
  <div >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Page Name        
      </h1>
      <ol class="breadcrumb">
        <li>          
          <router-link to="/dashboard">
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li>        
        <li class="active">Here</li>
      </ol>
    </section>
 
    <!-- Main content -->
    <section class="content">       
     <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
          <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
          <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
          <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
        <!-- Tab Staff List -->
        <tab-staff-list></tab-staff-list>
          
          <div role="tabpanel" class="tab-pane" id="profile">Profile Tab</div>
          <div role="tabpanel" class="tab-pane" id="messages">Something</div>
          <div role="tabpanel" class="tab-pane" id="settings">something else</div>
        </div>

      </div>
    </section>

  </div>      
</template>
<script>        
    
    import TabStaffList from './staff_management/Staff_list';
    export default {
        components: {
            // Add a reference to the TodoList component in the components property
            //'tab-staff-list': require('./staff_management/Staff_list.vue')
            // in template use as: <tab-staff-list> 
            TabStaffList,  
          },
        mounted() {            
        }
    }
</script>