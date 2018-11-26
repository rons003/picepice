@extends('layouts.dashboard')
@section('page_heading','Blue Cards')
@section('content')

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						Blue Cards
					</div>
					<div class="card-body">
						<div class="row">
							<table id="bluecarddb" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"  style="width:100%">
								<thead class="thead-dark">
									<tr>
										<th>Marker</th>
										<th>Surname</th>
										<th>Name</th>
										<th>M.I</th>
										<th>SNUM</th>
										<th>Remarks</th>
										<th>DTLCNT</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($blue_card as $o)
									<tr>
										<td>{{$o->marker}}</td>
										<td>{{$o->sur}}</td>
										<td>{{$o->given}}</td>
										<td>{{$o->middle}}</td>
										<td>{{$o->snum}}</td>
										<td>{{$o->remarks}}</td>
										<td>{{$o->dtlcnt}}</td>
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
	
	/*function viewChapter(id){
		var chap_id = $(id).attr('data-chap-id');
		var url = '/admin/getchapterdetails/' + chap_id;
		$.ajax({
			    type: 'GET',
			    url: url,
			    beforeSend: function() {
			    	console.log('test');
			    },
			    success: function(data) {
			        var msg = JSON.parse(data);            
		            if(msg.result == 'success'){
		                $('#ent_natl').val(msg.data.entrance);
		                $('#natl_dues').val(msg.data.natl_dues);
		                $('#ent_chap').val(msg.data.entrance);
		                $('#chap_dues').val(msg.data.chap_dues);

		            }
			    },
			    error: function(e) { // if error occured
			        
			    },
			    complete: function() {
			        
			    },
			});
		
		}*/

		$(document).ready( function () {
			$('#bluecarddb').DataTable({
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
