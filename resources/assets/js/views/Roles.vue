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
          <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">Add Roles to User</div>
            <div class="panel-body">
                User Roles Settings Here
            </div>
          </div>
        </div>
      </div>      
    </section>        
  </div>      
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>