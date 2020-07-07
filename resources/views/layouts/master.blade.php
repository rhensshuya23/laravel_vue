
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>ROS | Homepage</title>

  <!-- This refers to public>css>app.css -->
  <link rel="stylesheet" type="text/css" href="css/app.css">

  <link rel="icon" type="image/png" href="/img/ros-r-only.png"/>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  
    <!-- SEARCH FORM -->
    <div class="ml-3">
      <div class="input-group input-group-sm">
        <input @keyup="searchit" v-model="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <div class="user-panel d-flex"> 
        <div class="info">
          <p class="d-block" style="color: #7C7D7E">{{ Auth::user()->name }}</p>
        </div>
        <div class="image">
          @if ( Auth::user()->photo == "profile.png" )
          <router-link to="/profile" style="background-color: transparent !important;"><img src="img/default.png" alt="User Image" class="img-circle"></router-link>
          @elseif (!file_exists(public_path('img/profile/'.Auth::user()->photo)))
          <router-link to="/profile" style="background-color: transparent !important;"><img src="img/default.png" alt="User Image" class="img-circle"></router-link>
          @else
          <router-link to="/profile" style="background-color: transparent !important;"><img src="img/profile/{{Auth::user()->photo}}" alt="User Image" class="img-circle"></router-link>
          @endif
        </div>
      </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar green-bg elevation-4">
    <!-- Brand Logo -->
    <router-link to="/dashboard" class="brand-link" style="background-color: transparent !important;">
      <img src="./img/ros-r-only.png" alt="Profile Picture" class="brand-image img-circle" style="opacity: .8">
      <p style="color: white"><span class="brand-text">School Management</span></p>
      <p style="color: white; text-align: center; margin-top: -20px; margin-right: 30px;"><span class="brand-text">System</span></p>
      {{-- <p style="text-align: center; font-size: 15px; margin-top: -10px;"><span class="brand-text font-weight-light">HR System</span></p> --}}
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt white"></i>
              <p class="white">
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="nav-icon fas fa-user white"></i>
              <p class="white">
                Profile
              </p>
            </router-link>
          </li>
          @canany(['isSuperAdmin','isAdmin'])
          <li class="nav-item">
            <router-link to="/users" class="nav-link">
              <i class="nav-icon fas fa-users-cog white"></i>
              <p class="white">
                Users
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/employees" class="nav-link">
              <i class="nav-icon fas fa-user-friends white"></i>
              <p class="white">
                Employees
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users white"></i>
              <p class="white">
                Students
                <i class="right fas fa-angle-left white"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <router-link to="/new-students" class="nav-link">
                  <i class="nav-icon fas fa-circle white"></i>
                  <p class="white">New Students</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/old-students" class="nav-link">
                  <i class="nav-icon fas fa-circle white"></i>
                  <p class="white">Old Students</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
              <i class="nav-icon fas fa-cogs white"></i>
              <p class="white">
                For Developers
              </p>
            </router-link>
          </li>
          @endcanany
          <li class="nav-item">
            <router-link to="/contact-us" class="nav-link">
              <i class="nav-icon fas fa-envelope white"></i>
              <p class="white">
                Question/Issue
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                             <i class="nav-icon fas fa-sign-out-alt white"></i>
                <p class="white">
                  {{ __('Logout') }}
                </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        {{-- it will render matched route compenent here --}}
        <router-view></router-view>

        <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="#">Developed by: Abdullah - <b>RHENS</b></a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 - </strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
@auth
  <script type="text/javascript">
    window.userGlobal = @json(auth()->user()); //In laravel we can pass data to Javascript and read it as javascript object = json_encode(auth()->user())
  </script>
@endauth

<!-- REQUIRED SCRIPTS -->
{{-- <script type="text/javascript" src="/js/app.js"></script> --}}
<script src="{{mix('/js/app.js')}}"></script>
</body>
</html>
