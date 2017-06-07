<template>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Home Page
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard Home Page</div>
                <div class="panel-body">
                    Welcome to Dashboard home page
                </div>
            </div>
        </div>    
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">Something-1</div>
                <div class="panel-body">
                    Welcome to Dashboard home page
                </div>
            </div>
        </div> 

        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">Something-2</div>
                <div class="panel-body">
                    Welcome to Dashboard home page
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