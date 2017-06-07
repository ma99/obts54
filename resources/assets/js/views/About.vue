<template>
  <div>    
    <section class="content-header">
      <h1>
        About Page
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">        
        <li>
          <router-link to="/dashboard" exact>
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li> 
        <li class="active">About</li>
      </ol>
    </section>

    <section class="content">      
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
              <div class="panel-heading">The About Page</div>
              <div class="panel-body">
                  I'm an About component!
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
            // axios call here.
        }
    }
</script>