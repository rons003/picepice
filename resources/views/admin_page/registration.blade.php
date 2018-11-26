@extends('layouts.dashboard')
@section('page_heading','Registered Member')
@section('content')
<div class="container-fluid">
<div class="col-lg-12">
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Registered Member for Approval
            </div>
            <div class="card-body">
                <div class="row" style="margin-left: 2px;">
                    <form class="form-inline">
                        <div class="input-group mb-3">
                           <div class="input-group-append">
                                <span class="input-group-btn">
                                    <button id="btn-refresh" class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>Refresh
                                    </button>
                                </div>
                            </div>                            
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </div>
                        <div class="row">
                            <table id="datatable-members" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>PRC No</th>
                                        <th>Registrant Given</th>
                                        <th>Registrant Sur</th>
                                        <th>Existing Given</th>
                                        <th>Existing Sur</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>                                       
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<script src="{{ asset("pice/admin/js/registration.js") }}" type="text/javascript"></script> 
@stop
