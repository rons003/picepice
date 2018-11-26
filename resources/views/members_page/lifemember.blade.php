@extends('layouts.members_page')
@section('page_heading','Membership Dues')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <input type="hidden" name="_token" id="csrftoken" value="{{ csrf_token() }}">
        <div class="card-deck">
          <div class="card box-shadow">
            <div class="card-header">              
                  <h2><strong>LIFE Member</strong></h2>
            </div>
            <div class="card-body">             
              Please stay tuned for LIFE Member related Benefits.
            </div>
            <div class="card-footer">
            </div>  
            </div>
      </div>  
    </div>
</div>
@stop
