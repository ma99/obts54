<template>
  <div>    
    <section class="content-header">
      <h1>
        Roles Page
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">        
        <li>
          <router-link to="/dashboard" exact>
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li> 
        <li class="active">Roles</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
          <div class="panel panel-default">
              <div class="panel-heading">
                <!-- Add New City -->
                <!-- <span class="input-group-btn">
                    <button class="btn btn-success" type="button" @click="expandAddRolePanel" v-show="!show">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-warning" type="button" @click="expandAddRolePanel" v-show="show">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </span>      -->
                Role Setting           
              </div>
              
              <div class="panel-body">
                
                      <div class="col-sm-6 user-info">
                        <label for="cityCode">User email/ phone</label>
                        <div class="input-group">
                          <input v-model="searchString" type="text" class="form-control" name="userInfo" id="userInfo" placeholder="Search for...">
                          <span class="input-group-btn">
                            <button class="btn btn-success" type="button" @click="searchButton" v-show="!search">
                              <i class="fa fa-search" aria-hidden="true"></i>
                          </button>
                          <button class="btn btn-danger" type="button" v-show="search">
                              <i class="fa fa-search fa-spin" aria-hidden="true"></i>
                          </button>
                          </span>
                        </div><!-- /input-group -->
                      </div> 

                      <div class="col-sm-12">
                        <!-- <div class="panel panel-info" v-show="Object.keys(userInfo).length > 0"> -->
                        <div class="panel panel-info" v-if="Object.keys(userInfo).length > 0">
                          <div class="panel-heading">User Info</div>
                          <div class="panel-body">
                            <table class="table .table-striped">
                                <thead>
                                  <tr>
                                    <th>User Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>&nbsp;</th>              
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>                              
                                    <td>{{ userInfo.id}}</td>                              
                                    <td>{{ userInfo.name}}</td>                              
                                    <td>{{ userInfo.email}}</td>                              
                                    <td>{{ userInfo.phone}}</td>
                                  </tr>                            
                                </tbody>
                            </table>                                        
                          </div>

                          <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline">
                                      <input type="radio" name="inlineRadioOptions" id="adminRadio" value="admin" v-model="selectedRole"> Administrator
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="inlineRadioOptions" id="staffRadio" value="staff" v-model="selectedRole"> Staff
                                    </label>                                
                                </div>
                                <div class="col-sm-8">                                
                                    <button type="button" class="btn btn-primary" @click="setRole">Submit</button>
                                </div>
                            </div>
                          </div>  
                        </div>
                        <div v-else>
                             <span class="error-bg" v-show="error"> {{ error }}  </span> 
                        </div>
                     </div>
                                                       
              </div> <!-- panel body -->
              <!-- {{-- panel-footer --}} -->
              <div class="panel-footer" v-show="show">                    
                <!-- <show-alert :show="showAlert" :type="alertType" @cancel="showAlert=false">  -->
                <!-- <show-alert :show.sync="showAlert" :type="alertType"> 
                                 
                  <strong>{{ userInfo.name }} </strong> </br>
                  id: {{ userInfo.id}} <span>&nbsp;</span> email:  {{ userInfo.email}} <span>&nbsp;</span> phone: {{ userInfo.phone}} </br>

                  Added as <strong>{{ selectedRole }} </strong>  successfully!
                 
                </show-alert> -->

                <strong>{{ user.name }} </strong> </br>
                  id: {{ user.id}} <span>&nbsp;</span> email:  {{ user.email}} <span>&nbsp;</span> phone: {{ user.phone}} </br>

                  Added as <strong>{{ selectedRole }} </strong>  successfully!

              </div>        
          </div> 
      </div> <!-- row -->     

      <loader :show="loading"></loader>  

    </section>        
  </div>      
</template>

<script>
    export default {
        data() {
          return {
            alertType: '',
            error: '',
            loading: false,
            show: false,
            showAlert: false,
            userInfo: {},
            user: {},
            response: '',
            search: false,
            searchString: '',
            selectedRole: 'staff',
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        watch: {
            searchString() {
                this.error = '';
                this.show = false;
                this.userInfo = {};
            }
        },

        methods: {
            expandAddRolePanel() {
            this.show = !this.show;
          },
          searchButton() {
            //this.search = !this.search;
           
           this.userInfo = {};
           this.user = {},
           this.error = '';
           this.search = true;
           this.show = false;
          
           var vm = this;           
            axios.post('/search-user', {
                search_string: this.searchString         
            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.userInfo = response.data;
                vm.search = false;
               
            });
          },
          setRole() {

            var vm = this;   
            //this.showAlert = false;
            this.loading = true;

            this.user = Object.assign({}, this.userInfo); // clone a object
            //console.log('mm=', this.user);

            axios.post('/set-role', {
                role: this.selectedRole,
                user_id: this.userInfo.id,         
            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                if (vm.response) {
                    vm.search = false;
                    vm.userInfo = {};
                    vm.show = true;
                    //vm.alertType = 'info';
                    //vm.showAlert= true;                    
                }
                vm.loading = false;
            });

          }
        }
    }
</script>
<style lang="scss" scoped>
    .user-info {
        margin-bottom: 20px;
    }
    .error-bg {        
        background-color: #ffd700;
        font-weight: 500;       
        padding: 10px 80px;    
    }   
</style>