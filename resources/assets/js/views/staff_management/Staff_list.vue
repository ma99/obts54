<template>  
  <div role="tabpanel" class="tab-pane active" id="home"> Home Tab
  <!-- {{-- SCHEDULE --}}     -->
    <div class="panel panel-info">
        <div class="panel-heading">User Details</div>
        <div id="scroll-me">
          <table class="table table-striped table-hover">
             <!-- Table Headings -->
              <thead>
                  <th>&nbsp;</th>
                  <th>SL No.</th>                                
                  <th>ID</th>                                
                  <th>Name</th>                                
                  <th>Phone</th>                                
                  <th>Email</th>                                
                  <th>Role</th>
                  <th>Actions</th>                                                         
                  <th>&nbsp;</th>
              </thead>                      
              
              <tbody>
                <tr v-for="(staff, index) in staffs">
                    <td class="table-text">
                      <div> </div>
                    </td>
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
                        <button v-on:click.prevent="editStaff(staff)" class="btn btn-primary">
                          <i class="fa fa-pencil-square-o fa-fw"></i>Edit
                        </button> 
                        <button v-on:click.prevent="removeStaff(staff)" class="btn btn-danger">
                        <!-- <button @click="clickEvnt" class="btn btn-danger"> -->
                          <i class="fa fa-trash fa-fw"></i>Remove
                        </button>  
                      </div>
                    </td>
                </tr>                                                           
              </tbody>                        
          </table>                  
        </div>
        <!-- {{-- panel-footer --}} -->
        <div class="panel-footer">                    
          <!-- <show-alert :show="showAlert" :type="alertType" @cancel="showAlert=false">  -->
          <show-alert :show.sync="showAlert" :type="alertType"> 
            <!-- altert type can be info/warning/danger -->
            <strong>{{ staffName }} </strong> has been 
            <strong> {{ actionStatus }} </strong> successfully!
          </show-alert>
        </div>
        <!-- <div v-show="false" class="panel-footer"                   
           v-bind:class="{                        
              'alert-info': true
           }" 
           id="status-alert"
        >
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <strong>{{ staffName }} </strong> has been <strong> {{ actionStatus }} </strong>
        </div> -->
    </div>
   
    <loader :show="loading">      
    <!-- <div class="loading"><i v-show="loading" class="fa fa-spinner fa-pulse fa-3x text-primary"></i></div> -->
    </loader>
    
    <!-- Modal -->              
    <!-- <modal :show="modal" @close="modal=false"> -->
    <modal v-show="modal" @close="modal=false">
      <div class="row">
          <div id="edit-staff" class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4>Edit Staff Role</h4>
              </div>
              <div class="row panel-body">
                  <div class="saff-info">
                    Name: <span> {{ staffName }} </span>
                    <br/>                                   
                    Present Role: <high-light :color="colorName" value="5"> {{ staffRole }} </high-light> 
                    <br/>
                    <strong>Change to</strong>
                  </div>
                  <div class="role-selection">
                    <form>
                      <div class="radio">
                        <label class="radio-inline">
                          <input type="radio" name="optionsRadios" id="optionsRadios1" value="admin" v-model="rolePicked" :disabled="staffRole=='admin'">
                          Administrator
                        </label>    
                      </div>
                      <div class="radio">
                        <label class="radio-inline">
                          <input type="radio" name="optionsRadios" id="optionsRadios2" value="staff" v-model="rolePicked" :disabled="staffRole=='staff'">
                          Staff
                        </label>
                      </div>
                    </form>  
                  </div>                             
              </div>
              <div class="panel-footer">
                      <button class="btn btn-primary" v-on:click.prevent="updateStaffRole()">Save</button>
                      <button class="btn btn-primary" @click.prevent="modal=false">Cancel</button>
              </div>                        
            </div>
          </div>               
      </div>                 
    </modal>
      <!-- /Modal -->
  </div>
</template>
<script>
    //import swal from 'sweetalert';    
    export default {
        data() {
            return {
                actionStatus: '',
                alertType: '',
                colorName: '',
                error: false,
                loading: false,
                modal: false,
                rolePicked:'',
                showAlert: false,                
                staffId: '' ,
                staffName: '' ,
                staffRole: '',
                staffRoleId: '',
                staffs: []                
            }
        },        
        methods: {
            // clickEvnt() {
            //   this.showAlert = true;
            // },
            editStaff(staff) {  // role id of user/staff in roles table
                var vm = this;
                this.staffId = staff.id;
                this.staffName = staff.name;
                this.staffRole = staff.role;
                this.staffRoleId = staff.role_id;
                this.rolePicked = (this.staffRole=='admin') ? 'staff': 'admin';
                this.colorName = (this.staffRole=='admin') ? '#de1575': '#75e';

                this.modal = true;
                /*axios.post('/staffs/staff'+ staffId)          
                    .then(function (response) {                                           
                      response.data.error ? vm.error = response.data.error : vm.actionStatus = response.data;
                    });*/
            },
            enableSlimScroll() {
                $('#scroll-me').slimScroll({
                  color: '#00f',
                  size: '8px',
                  height: '300px',
                  //height: auto,
                  wheelStep: 10                  
                });
            },
            fetchStaffInfo() {
                var vm = this;
                this.loading = true;
                axios.get('/staffs')          
                    .then(function (response) {                    
                      console.log(response.data);
                      response.data.error ? vm.error = response.data.error : vm.staffs = response.data;
                        vm.loading = false;                      
                    });
            },
            // showAlert() {
            //     $("#status-alert").alert();
            //     $("#status-alert").fadeTo(2000, 500)
            //     .slideUp(500, function(){
            //         $("#status-alert").slideUp(500);
            //     });   
            // },
            removeStaff(staff) {  // role id of user/staff in roles table
                var vm = this;
                this.staffName = staff.name; 
                swal({
                      title: "Are you sure?",
                      text: "This staff will be Removed from Staff Roles!",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Yes, Remove!",
                      //closeOnConfirm: false,
                      //closeOnCancel: false                       
                    },
                    function() {                       
                            vm.loading = true;
                            vm.response = '';
                            axios.post('/delete', {
                                id: staff.role_id, 
                                user_id: staff.id 
                            })          
                            .then(function (response) {                                           
                                //response.data.error ? vm.error = response.data.error : vm.staffs = response.data;
                                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                                if (vm.response) {
                                  vm.removeStaffFromStaffs(staff.id);
                                  vm.loading = false;
                                  vm.actionStatus = 'Removed';
                                  vm.alertType = 'danger';
                                  vm.showAlert= true;                                                        
                                }
                            });    
                            //swal("Deleted!", "Staff has been Removed.", "success");                      
                        
                    });
            },
            
            removeStaffFromStaffs(staffId) {

                var indx = this.staffs.findIndex(function(staff){ 
                    // here 'staff' is array object 
                    return staff.id == staffId;
                });        
                this.staffs.splice(indx, 1);
            },

            updateStaffRole() {
                var vm = this;
                this.response = '';
                //this.staffName = staff.name;                
                this.loading = true;
                axios.post('/update', {
                      id: this.staffRoleId,
                      user_id: this.staffId,
                      role: this.rolePicked 
                    })          
                    .then(function (response) {                                           
                      //response.data.error ? vm.error = response.data.error : vm.staffs = response.data;
                      response.data.error ? vm.error = response.data.error : vm.response = response.data;
                      if(vm.response) {
                          vm.updateStaffRoleAtStaffs(vm.staffId, vm.rolePicked);
                          vm.loading = false;
                          vm.modal = false;
                          vm.actionStatus = 'Udated';
                          vm.alertType = 'info';
                          vm.showAlert= true;                                              
                      }
                    });
            },

            updateStaffRoleAtStaffs(staffId, rolePicked) {
                 var indx = this.staffs.findIndex(function(staff){ 
                    // here 'staff' is array object                     
                    return staff.id == staffId;
                });                        
                this.staffs[indx].role = rolePicked;
            },

        },
        mounted() {
            console.log('Staff Component mounted.');            
            this.fetchStaffInfo();
            this.enableSlimScroll();
        }
    }
</script>
<style lang="scss" scoped>

  .table-hover > tbody > tr:hover {
    background-color: #d6edd7;
  }
  .fa-fw {
    width: 1.4em;
  }
  th {
    line-height: 2.5;
  }
  .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
    vertical-align: middle;
  }
  .role-selection {
    margin-left: 1.5em;
  }
</style>