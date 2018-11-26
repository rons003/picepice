@extends('layouts.admin_plane')

@section('body')
<div id="wrapper">

  <!-- Navigation -->
  <nav class="side-navbar">
    <div class="side-navbar-wrapper">
      <!-- Sidebar Header    -->
      <div class="sidenav-header d-flex align-items-center justify-content-center">
        <!-- User Info-->
        <div class="sidenav-header-inner text-center">
          <img src="{{ asset('images/piceicon.png') }}" class="img-fluid" alt="Responsive image" />
          <h2 class="h5" style="margin-bottom: 12px ">Administrator</h2>
        </div>
        <!-- Small Brand information, appears on minimized sidebar-->
        <div class="sidenav-header-logo"><a href="{{ url ('member\landing') }}" class="brand-small text-center"><img src="{{ asset('images/piceicon.png') }}" width="50" height="25" /></a></div>
      </div>
      <!-- Sidebar Navigation Menus-->
      <div class="main-menu">
        <h5 class="sidenav-heading">Main</h5>
        <ul id="side-main-menu" class="side-menu list-unstyled"> 
         
          <li {{ (Request::is('/') ? 'class="active"' : '') }}>
            <a class="h5" href="{{ url ('admin\membership') }}"><i class="icon-user"></i><b>MEMBERS</b></a></li>
            <li {{ (Request::is('*payments') ? 'class="active"' : '') }}>
              <a href="{{ url ('admin\create_payment') }}"><i class="icon-check"></i><b>PAYMENTS</b></a>
              <!-- /.nav-second-level -->
            </li>
            <li {{ (Request::is('*invoices') ? 'class="active"' : '') }}>
              <a href="{{ url ('admin\invoices') }}"><i class="icon-bill"></i><b>INVOICES</b></a>
              <!-- /.nav-second-level -->
            </li>
            <li {{ (Request::is('*chapter') ? 'class="active"' : '') }}>
              <a href="{{ url ('admin\chapter') }}"><i class="fa fa-file-text"></i><b>CHAPTERS</b></a>
              <!-- /.nav-second-level -->
            </li>
            <li {{ (Request::is('*life') ? 'class="active"' : '') }}>
              <a href="{{ url ('admin\life') }}"><i class="fa fa-heart"></i><b>LIFE MEMBERS</b></a>
            </li>
            <li {{ (Request::is('*bluecards') ? 'class="active"' : '') }}>
              <a href="{{ url ('admin\bluecards') }}"><i class="fa fa-address-card"></i><b>BLUE CARDS</b></a>           
            </li>
          </ul>
        </div>
      </div>
      <div class="admin-menu">
        <h5 class="sidenav-heading">Request</h5>
        <ul id="side-admin-menu" class="side-menu list-unstyled"> 
          <li> <a href="{{ url ('admin\registration') }}"> <i class="icon-screen"> </i>Membership Registration</a></li>
          </ul>
        </div>
    </nav>

    <div class="page">
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="{{ url ('member\landing') }}" class="navbar-brand">
                <div class="brand-text d-none d-md-inline-block">
                  <h2 class="text-default" style="font-family: 'Raleway', sans-serif; font-weight: 100;color: #d5953f ">Pice Administrator Portal</h2></div></a></div>
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
            <div class="row">
              <div class="col-lg-12">
                <h1 class="page-header">@yield('page_heading')</h1>
              </div>
              <!-- /.col-lg-12 -->
            </div>
            @yield('content')
          </div>
        </div>

        
      </div>
      <script>
        $(document).ready(function() {
          $('input[type="number"]').keydown(function (e) {
              // Allow: backspace, delete, tab, escape, enter and .
              if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                   // Allow: Ctrl/cmd+A
                  (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                   // Allow: Ctrl/cmd+C
                  (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                   // Allow: Ctrl/cmd+X
                  (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                   // Allow: home, end, left, right
                  (e.keyCode >= 35 && e.keyCode <= 39)) {
                       // let it happen, don't do anything
                       return;
              }
              // Ensure that it is a number and stop the keypress
              if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                  e.preventDefault();
              }
          });
      });
      </script>
      @stop



