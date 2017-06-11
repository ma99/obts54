<template>
<!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Page Name
        <!-- <small>Optional description</small> -->
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
     <!-- Your Page Content Here -->     
    </section>

  </div>      
</template>

<script>
    export default {
        // mounted() {
        //     console.log('Component mounted.')
        // }
    }
</script>