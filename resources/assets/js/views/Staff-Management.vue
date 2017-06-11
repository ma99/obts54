<template>
<!-- Content Wrapper. Contains page content -->
  <div>
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
          <div role="tabpanel" class="tab-pane active" id="home"> Home Tab

          </div>
          <div role="tabpanel" class="tab-pane" id="profile">Profile Tab</div>
          <div role="tabpanel" class="tab-pane" id="messages">Something</div>
          <div role="tabpanel" class="tab-pane" id="settings">something else</div>
        </div>

      </div>
    </section>

  </div>      
</template>

<script>
    export default {
        data() {
            return {
                staffInfo: [],
                error:false
                
            }
        },
        methods: {
            fetchStaffInfo() {
                var vm = this;
                axios.get('admin/staff')          
                    .then(function (response) {                      
                      // console.log(response.data);
                       response.data.error ? vm.error = response.data.error : vm.cityToList = response.data;
                       // vm.loading = false;                      
                    });
            }
            
        },
        mounted() {
            console.log('Staff Component mounted.');
            this.fetchStaffInfo();
        }
    }
</script>