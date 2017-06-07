<template>
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Home page</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">                        
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/dashboard" exact>
                            Dashboard
                        </router-link>
                    </li>                    
                    <li class="active">Home</li>
                </ol>
            </div>
        </div>               
        
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
    </div>           
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>