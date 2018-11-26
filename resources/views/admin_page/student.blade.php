@extends('layouts.dashboard')
@section('page_heading','Students')
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Students
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin-left: 2px;">
                            <form class="form-inline">
                                <div class="input-group mb-3">
                                    <input type="text" name="search_no" class="form-control" placeholder="Enter Student No." aria-label="Enter Student No." aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="input-group mx-sm-3 mb-3">
                                        <input type="text" name="search_ln_fn" class="form-control" placeholder="Enter firstname or lastname" aria-label="Enter firstname or lastnam" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                </div>
                                <div class="row">
                                    <table id="lifedb" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Student#</th>
                                                <th>Given</th>
                                                <th>Sur</th>
                                                <th>School</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $o)
                                            <tr>
                                                <td>{{$o->stud_num}}</td>
                                                <td>{{$o->given}}</td>
                                                <td>{{$o->sur}}</td>
                                                <td>{{$o->school}}</td>                                                
                                            </tr>               
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready( function () {
                $('#lifedb').DataTable({
                    bLengthChange: false,
                    searching: false,
                    "language": {
                        "paginate": {
                    "previous": "<",
                    "next" : ">"
                        }
                    }
                });
            } );
        </script>         
        @stop
