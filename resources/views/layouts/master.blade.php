
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
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar green-bg elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="./img/ros-r-only.png" alt="Profile Picture" class="brand-image img-circle" style="opacity: .8">
      <p style="color: white"><span class="brand-text">HR Solutions</span></p>
      {{-- <p style="text-align: center; font-size: 15px; margin-top: -10px;"><span class="brand-text font-weight-light">HR System</span></p> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/profile/{{Auth::user()->photo}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <p class="d-block white"><strong>{{ Auth::user()->name }}</strong></p>
          {{-- <p class="d-block white">{{ strtoupper(Auth::user()->type) }}</p> --}}
        </div>
      </div>

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
          @can('isAdmin')
          <li class="nav-item">
            <router-link to="/users" class="nav-link">
              <i class="nav-icon fas fa-users white"></i>
              <p class="white">
                Users
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
              <i class="nav-icon fas fa-cogs white"></i>
              <p class="white">
                For Developers
              </p>
            </router-link>
          </li>
          @endcan
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
      <a href="#">Developed by: Rhens - <b>ROS</b></a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 - </strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
@auth
  <script type="text/javascript">
    window.userGlobal = @json(auth()->user());
  </script>
@endauth

<!-- REQUIRED SCRIPTS -->
<script type="text/javascript" src="/js/app.js"></script>
</body>
</html>
