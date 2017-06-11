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
            <!-- {{-- SCHEDULE --}}     -->
              <div class="panel panel-info">
                  <div class="panel-heading">User Details</div>
                  <div id="scrollMe">
                    <table class="table table-striped table-hover task-table">
                       <!-- Table Headings -->
                        <thead>
                            <th>SL No.</th>                                
                            <th>ID</th>                                
                            <th>Name</th>                                
                            <th>Phone</th>                                
                            <th>Email</th>                                
                            <th>Role</th>                                      
                            <th>&nbsp;</th>
                        </thead>                      
                        
                        <tbody>
                          <tr v-for="(staff, index) in staffs">
                              <td class="table-text">
                                <div> {{ index + 1 }} </div>
                              </td>
                              <td class="table-text">
                                <div> {{ staff.id }} </div>
                              </td>
                              <td class="table-text">
                                <div> {{ staff.name }} </div>
                              </td>
                              <td class="table-text">
                                <div> {{ staff.phone }} </div>
                              </td>
                              <td class="table-text">
                                <div> {{ staff.email }} </div>
                              </td>
                              <td class="table-text">
                                <div> {{ staff.role }} </div>
                              </td>
                              <td class="table-text">
                                <div> 
                                  <button v-on:click.prevent="removeUser()" class="btn btn-danger">Remove</button> 
                                </div>
                              </td>
                          </tr>                                                           
                        </tbody>                        
                    </table>                  
                  </div>
              </div>
             
              <div class="loading"><i v-show="loading" class="fa fa-spinner fa-pulse fa-3x text-primary"></i></div>

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
                error: false,
                loading: false, 
                staffs: []                
            }
        },
        methods: {
            fetchStaffInfo() {
                var vm = this;
                this.loading = true;
                axios.get('/staff')          
                    .then(function (response) {                      

                      console.log(response.data);
                      response.data.error ? vm.error = response.data.error : vm.staffs = response.data;
                        vm.loading = false;                      
                    });
            },
            enableSlimScroll() {
              $('#scrollMe').slimScroll({
                  color: '#00f',
                  size: '8px',
                  height: '180px',
                  // height: auto,
                  wheelStep: 10,
                  alwaysVisible: true
              });
            }            
        },
        mounted() {
            console.log('Staff Component mounted.');
            this.fetchStaffInfo();
            this.enableSlimScroll();
        }
    }
</script>
<style>
  .table-hover > tbody > tr:hover {
    background-color: #d6edd7;
  }
</style>