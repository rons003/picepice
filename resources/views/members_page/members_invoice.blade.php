@extends('layouts.members_page')
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<h5 class="card-header">Invoices</h5>
				<div class="card-body">
					<table id="invoicedb" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
						<thead class="thead-dark">
							<tr>
								<th>Invoice #</th>
								<th>Type</th>
								<th>Total</th>
								<th>Due Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($invoice as $o)
							<tr>
								<td>{{$o->invoicenumber}}</td>
								<td>{{$o->type}}</td>
								<td>{{$o->total}}</td>
								<td>{{$o->duedate}}</td>
								<td>{{$o->status}}</td>
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
		$('#invoicedb').DataTable({
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
