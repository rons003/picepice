@extends('layouts.members_page')
@section('page_heading','Previous Payments')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Previous Payments</h5>
        <div class="card-body">
          <table id="paymentsdb" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
            <thead class="thead-dark">
              <tr class="text-center">
                <th>OR Number</th>
                <th>National Dues</th>
                <th>Chapter Dues</th>
                <th>Reinstatement National Dues</th>
                <th>Reinstatement Chapter Dues</th>
                <th>Payment Date</th>       
                <th>Total Payment</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($payments as $o)
              <tr class="text-right">
                <td class="text-center">{{$o->or_number}}</td>
                <td>{{$o->natl_dues}}</td>
                <td>{{$o->chap_dues}}</td>
                <td>{{$o->ent_natl}}</td>
                <td>{{$o->ent_chap}}</td>
                <td>{{$o->last_pay}}</td>       
                <td>{{$o->totalpay}}</td>
                <td>
                @if ($o->invoiceid)
                  <a class="btn btn-success btn-sm" target="_blank" href="/member/invoice/{{$o->invoiceid}}">View Invoice</a>
                @endif
                </td>
              </tr>             
              @endforeach
            </tbody>
          </table>       
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready( function () {
    $('#paymentsdb').DataTable();
  } );
</script>  
@stop
