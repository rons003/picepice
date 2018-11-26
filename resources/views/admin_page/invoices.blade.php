@extends('layouts.dashboard')
@section('page_heading','Invoices')
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Invoices
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin-left: 2px;">
                            <form class="form-inline">
                                <div class="input-group mb-3">
                                    <input type="text" name="search_invoice" class="form-control" placeholder="Enter Invoice Number" aria-label="Enter Invoice Number" aria-describedby="basic-addon2">
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
                                <table id="invoicedt" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Invoice Number</th>
                                            <th>Amount Due</th>
                                            <th>Sub Total</th>
                                            <th>Total</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice as $o)
                                        <tr>
                                            <td>{{$o->invoiceid}}</td>
                                            <td>{{$o->invoicenumber}}</td>
                                            <td>{{$o->amountdue}}</td>
                                            <td>{{$o->subtotal}}</td>
                                            <td>{{$o->total}}</td>

                                        </tr>
                                        @endforeach
                                        
                                        <script type="text/javascript">
                                            $(document).ready( function () {
                                                $('#invoicedt').DataTable({
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        ...
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
</div>
</div>
</div>


@stop
