@extends('layouts.members_page')
@section('content')
<!-- Breadcrumb-->
<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="/member/landing">Home</a></li>
      </ul>
  </div>
</div>

<div class="container-fluid">
  <h2>Welcome Page!</h2>
  <div class="row justify-content-center align-items-center" style="margin: 10px 0 10px 0;">
    <img src="{{ asset('images/pice_name.png') }}" class="img-fluid" alt="Responsive image"/>
  </div>     	
  <div class="row">
    <div class="col-lg-10 col-md-6">
      <p>Your PICE dashboard contains all the help and advice that you need to manage your membership, from information about your membership, to payment tracking and current events.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <p>Here you can find:</p>
      <ul>
        <li style="font-size:20px">My Profile - Let us know of any changes to your personla details</li>               
        <li style="font-size:20px">My Payments - Keep track of your PICE Membership payments</li>               
        <li style="font-size:20px">Events - Be aware of latest events in your professional circle</li>
      </ul>
    </div>
    <div class="col-lg-6">
      <div class="card" style="width: 20rem;">
        <div class="card-body">
          <h5 class="card-title">Got a question about your membership?</h5>
          <p class="card-text">Our membership team is here to help you with any queries you've got about your application. If you're not sure about something or think you've made mistakes, then let us know and we'll help.</p>
          <button type="button" class="btn btn-info">Contact us</button>
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top: 10px;">
    <div class="col-lg-3 col-md-6">
      <a href="{{ url ('member\home') }}">
        <div class="card text-white bg-info mb-3" style="max-width: 18rem; width: 350px;">
          <div class="card-body text-center">
            <i class="fa fa-user-circle-o  fa-5x"></i>
            <h5 class="card-title">My Profile</h5>
            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
          </div>
        </div>
      </a>
    </div>    
    <div class="col-lg-3 col-md-6">
      <a href="{{ url ('member\payments') }}">
        <div class="card text-white bg-info mb-3" style="max-width: 18rem; width: 350px;">
          <div class="card-body text-center">
            <i class="fa fa-credit-card-alt fa-5x"></i>
            <h5 class="card-title">My Payments</h5>
            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-md-6">
      <a href="{{ url ('member\events') }}">
        <div class="card text-white bg-info mb-3" style="max-width: 18rem; width: 350px;">
          <div class="card-body text-center">
            <i class="fa fa-calendar fa-5x"></i>
            <h5 class="card-title">Events</h5>
            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
          </div>
        </div>
      </a>
    </div> 
  </div>
</div>      

</div>

@stop
