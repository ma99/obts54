<template>
  <div>    
    <section class="content-header">
      <h1>
        Admin Staff
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">        
        <li>
          <router-link to="/dashboard" exact>
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li> 
        <li class="active">Admin Staff</li>
      </ol>
    </section>

    <section class="content">      
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">The Admin Staff Page</div>
            <div class="panel-body">
                I'm an Admin Staff component!
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