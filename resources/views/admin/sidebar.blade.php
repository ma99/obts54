<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">          

    <!-- search form (Optional) -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">HEADER</li>
      <!-- Optionally, you can add icons to the links -->
      <li>
        <router-link to="/dashboard" exact><i class="fa fa-clock-o"></i> <span>Home</span></router-link>
      </li>
      <li>
          <router-link to="/about"><i class="fa fa-table" aria-hidden="true"></i>About</router-link>
      </li>            
      <li>
          <router-link to="/contact"><i class="fa fa-link" aria-hidden="true"></i>Contact</router-link>
      </li>
      <li>
          <router-link to="/staff-management"><i class="fa fa-cog" aria-hidden="true"></i>Staff Management</router-link>
      </li>                        
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user"></i> <span>User</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
           <li>
              <router-link to="/profile">
                  <i class="fa fa-address-card fa-fw" aria-hidden="true"></i>
                  Profile
              </router-link> 
          </li>
          <li> 
              <router-link to="/roles">
                  <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                  Set Roles
              </router-link>
         </li>
          <li>
              <router-link to="/staff-list">
                  <i class="fa fa-address-book-o fa-fw" aria-hidden="true"></i>
                  Admin Staff
              </router-link>
          </li>                  
          <li><a href="#">Link in level 2</a></li>
          <li><a href="#">Link in level 2</a></li>
        </ul>
      </li>

      {{-- Bus Management --}}      
      <li class="treeview">
        <a href="#">
          <i class="fa fa-bus" aria-hidden="true"></i>
          <span>Bus</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
              <router-link to="/add-bus">
                  <i class="fa fa-bus" aria-hidden="true"></i>
                  Add Bus
              </router-link> 
          </li>          
          <li> 
              <router-link to="/bus-list">
                  <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                  View Bus List
              </router-link>
         </li> 
         <li>
              <router-link to="/add-city">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  Add City
              </router-link> 
          </li>
          <li>
              <router-link to="/add-stop">
                  <i class="fa fa-link" aria-hidden="true"></i>
                  Add Stop
              </router-link> 
          </li>  
          <li>
              <router-link to="/add-route">
                  <i class="fa fa-link" aria-hidden="true"></i>
                  Add Route
              </router-link> 
          </li>          
        </ul>
      </li>
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>