@extends('layouts.plane')

@section('body')
<div id="wrapper">

  <!-- Navigation -->
  <nav class="side-navbar">
    <div class="side-navbar-wrapper">
      <!-- Sidebar Header    -->
      <div class="sidenav-header d-flex align-items-center justify-content-center">
        <!-- User Info-->
        <div class="sidenav-header-inner text-center" id="header-icon">
          <h2 class="h5" style="margin-bottom: 12px">My Profile</h2>
          <img src="{{ asset('images/profile_icon.png') }}" alt="person" class="img-fluid rounded-circle">
          <div id="header-profile">
            <h2 class="h5">{{session('fullname')}}</h2>
            <span class="h5">PRC No. {{session('prc_no')}}</span>
          </div>
        </div>
        <!-- Small Brand information, appears on minimized sidebar-->
        <div class="sidenav-header-logo"><a href="{{ url ('member\landing') }}" class="brand-small text-center"><img src="{{ asset('images/piceicon.png') }}" width="50" height="25" /></a></div>
      </div>
      <!-- Sidebar Navigation Menus-->
      <div class="main-menu">
        <h5 class="sidenav-heading">Main</h5>
        <ul id="side-main-menu" class="side-menu list-unstyled">                  
          <li><a href="{{ url ('member\landing') }}"> <i class="fa fa-home"></i>Home                             </a></li>
          <li><a href="{{ url ('member\home') }}"> <i class="fa fa-user-circle-o"></i>Profile                             </a></li>
          <li><a href="{{ url ('member\payments') }}"> <i class="fa fa-credit-card-alt"></i>Payments                             </a></li>
          @if ( session('islifemember') == 1)
          <li><a href="{{ url ('member\lifemember') }}"> <i class="fa fa-credit-card"></i>Life Member</a></li>
          @else
          <li><a href="{{ url ('member\dues') }}"> <i class="fa fa-credit-card"></i>Membership Due</a></li>
          @endif

          <li><a href="{{ url ('member\events') }}"> <i class="fa fa-calendar"></i>Events                             </a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="page">
    <header class="header">
      <nav class="navbar">
        <div class="container-fluid">
          <div class="navbar-holder d-flex align-items-center justify-content-between">
            <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="{{ url ('member\landing') }}" class="navbar-brand">
              <div class="brand-text d-none d-md-inline-block">
                <h2 class="text-default" style="font-family: 'Raleway', sans-serif; font-weight: 100; color: #D1983E;">Membership Portal</h5></div></a></div>
                  <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <!-- Notifications dropdown-->
                    
                    <!-- Messages dropdown-->
                    
                    
                    <!-- Log out-->
                    <li class="nav-item">
                      <a href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();" 
                      class="nav-link logout"> <span class="d-none d-sm-inline-block">Logout</span><i class="fa fa-sign-out"></i></a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </ul>
                </div>
              </div>
            </nav>
          </header>
          <div id="pager">
            @yield('content')
          </div>
        </div>

        
      </div>
      <script>
    $(document).ready(function () {
      $('input[type=text]').keyup(function () {
        $(this).val($(this).val().toUpperCase());
      });
      $('textarea[type=text]').keyup(function () {
        $(this).val($(this).val().toUpperCase());
      });
    });

  
  </script>
      @stop


