@extends('layouts.dashboard')
@section('page_heading','MAP')
@section('content')

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Map
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin-left: 2px;">
                            <form class="form-inline">
                                <div class="input-group mb-3">
                                    <input type="text" name="search_no" class="form-control" placeholder="Enter Serial No." aria-label="Enter Serial No." aria-describedby="basic-addon2">
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
                                    <table id="lifedb" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>SNUM</th>
                                                <th>Name</th>
                                                <th>mailing</th>
                                                <th>mailing2</th> 
                                                <th>payment</th>                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($maps as $o)
                                            <tr>
                                                <td>{{$o->snum}}</td>
                                                <td>{{$o->name}}</td>
                                                <td>{{$o->mailing}}</td>
                                                <td>{{$o->mailing2}}</td>  
                                                <td>{{$o->payment}}</td>                                               
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
                    searching: false
                });
            } );
        </script>         
        @stop
