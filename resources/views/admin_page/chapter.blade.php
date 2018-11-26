@extends('layouts.dashboard') 
@section('page_heading','Chapters') 
@section('content')

<div class="container-fluid">
	<div class="col-lg-12">

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						Chapters
					</div>
					<div class="card-body">
						<div class="row" style="padding-left: 1rem;">
							<form>
								<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add-chapter-modal" data-backdrop="static"
								 data-keyboard="false">Create Chapter</button>
							</form>
						</div>
						<div class="row">
							<table id="chaptersdb" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
								<thead class="thead-dark">
									<tr>
										<th>Chapter</th>
										<th>Chapter Code</th>
										<th>Region</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($chapters as $o)
									<tr>
										<td>{{$o->chapter}}</td>
										<td>{{$o->chap_code}}</td>
										<td>{{$o->region}}</td>
										<td>
											<button onclick="viewChapter(this)" type="button" class="btn btn-primary btn-sm" data-chapter-id="{{$o->id}}">View</button>
											<button id="btn-delete-chapter" onclick="deleteChapter(this)" type="button" class="btn btn-danger btn-sm" data-chapter-id="{{$o->id}}">Delete</button>
											<a class="btn btn-success btn-sm" target="_blank" href="/admin/chapter/report/{{$o->id}}">Report</a>
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
	</div>
</div>
<div class="modal fade dark-modal" id="add-chapter-modal">
	<div class="modal-dialog" role="document">
		<form id="frm-add-chapter">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Create New Chapter</h4>
					<button type="button" class="close" data-dismiss="modal" style="margin-right:10px;">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger print-error-msg" style="display:none">
						<ul></ul>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Chapter Code</label>
								<input type="text" class="form-control" id="chap_code" name="chap_code">
							</div>
							<div class="form-group">
								<label>Chapter Name</label>
								<input type="text" class="form-control" id="chapter" name="chapter">
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label>Chapter Dues</label>
									<input type="number" class="form-control" id="chap_dues" name="chap_dues">
								</div>
								<div class="form-group col-md-6">
									<label>National Dues</label>
									<input type="number" class="form-control" id="natl_dues" name="natl_dues">
								</div>
							</div>
							<div class="form-group">
								<label>Date Establish</label>
								<div class="input-group date" id="datetimepicker-add-date-estab" data-target-input="nearest">

									<input type="text" id="add-date-estab" name="establishe" class="form-control datetimepicker-input" data-target="#datetimepicker-add-date-estab"
									/>
									<div class="input-group-append" data-target="#datetimepicker-add-date-estab" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Region</label>
								<div class="form-row">
									<div class="form-group col-md-6">
										<select class="custom-select mr-sm-4" id="select-reptype" name="reptype" style="margin-bottom: .1rem;">
											<option value="LOCAL">LOCAL</option>
											<option value="INTERNATIONAL">INTERNATIONAL</option>
										</select>
									</div>
									<div class="form-group col-md-6">
										<select class="custom-select mr-sm-4" id="select-region" name="region" style="margin-bottom: .1rem;">
											<option value="ARMM">ARMM</option>
											<option value="CAR">CAR</option>
											<option value="MIMAROPA">MIMAROPA</option>
											<option value="NCR">NCR</option>
											<option value="Region I">Region I</option>
											<option value="Region II">Region II</option>
											<option value="Region III">Region III</option>
											<option value="Region IV-A">Region IV-A</option>
											<option value="Region V">Region V</option>
											<option value="Region VI">Region VI</option>
											<option value="Region VII">Region VII</option>
											<option value="Region VIII">Region VIII</option>
											<option value="Region IX">Region IX</option>
											<option value="Region X">Region X</option>
											<option value="Region XI">Region XI</option>
											<option value="Region XII">Region XII</option>
											<option value="Region XIII">Region XIII</option>
											<option value="INTERNATIONAL">INTERNATIONAL</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button id="btn-submit-chapter" type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal fade dark-modal" id="edit-chapter-modal">
	<div class="modal-dialog" role="document">
		<form id="frm-update-chapter">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Edit Chapter</h4>
					<button type="button" class="close" data-dismiss="modal" style="margin-right:10px;">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger print-error-msg" style="display:none">
						<ul></ul>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Chapter Code</label>
								<input type="text" class="form-control" id="view-chap_code" name="chap_code">
							</div>
							<div class="form-group">
								<label>Chapter Name</label>
								<input type="text" class="form-control" id="view-chapter" name="chapter">
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label>Chapter Dues</label>
									<input type="number" class="form-control" id="view-chap_dues" name="chap_dues">
								</div>
								<div class="form-group col-md-6">
									<label>National Dues</label>
									<input type="number" class="form-control" id="view-natl_dues" name="natl_dues">
								</div>
							</div>
							<div class="form-group">
								<label>Date Establish</label>
								<div class="input-group date" id="datetimepicker-view-date-estab" data-target-input="nearest">

									<input type="text" id="view-date-estab" name="establishe" class="form-control datetimepicker-input" data-target="#datetimepicker-view-date-estab"
									/>
									<div class="input-group-append" data-target="#datetimepicker-view-date-estab" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Region</label>
								<div class="form-row">
									<div class="form-group col-md-6">
										<select class="custom-select mr-sm-4" id="view-select-reptype" name="reptype" style="margin-bottom: .1rem;">
											<option value="LOCAL">LOCAL</option>
											<option value="INTERNATIONAL">INTERNATIONAL</option>
										</select>
									</div>
									<div class="form-group col-md-6">
										<select class="custom-select mr-sm-4" id="view-select-region" name="region" style="margin-bottom: .1rem;">
											<option value="ARMM">ARMM</option>
											<option value="CAR">CAR</option>
											<option value="MIMAROPA">MIMAROPA</option>
											<option value="NCR">NCR</option>
											<option value="Region I">Region I</option>
											<option value="Region II">Region II</option>
											<option value="Region III">Region III</option>
											<option value="Region IV-A">Region IV-A</option>
											<option value="Region V">Region V</option>
											<option value="Region VI">Region VI</option>
											<option value="Region VII">Region VII</option>
											<option value="Region VIII">Region VIII</option>
											<option value="Region IX">Region IX</option>
											<option value="Region X">Region X</option>
											<option value="Region XI">Region XI</option>
											<option value="Region XII">Region XII</option>
											<option value="Region XIII">Region XIII</option>
											<option value="INTERNATIONAL">INTERNATIONAL</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button id="btn-update-chapter" type="submit" class="btn btn-primary">Save Changes</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$('#frm-update-chapter').submit(function(e){
		e.preventDefault();
		 $.ajax({
		    url: "/admin/chapter/update/"+$('#btn-update-chapter').attr('data-chapter-id'),
		    type: "POST",
		    data: new FormData(this),
		    contentType: false,
		    cache: false,
		    processData: false,
		    beforeSend: function(){ 
		      $('#btn-update-chapter').html('Processing...');
		    },
		    error: function(data){
		      if(data.readyState == 4){
		        errors = JSON.parse(data.responseText);

		        $.each(errors,function(key,value){
		          console.log({type: 2, text: value, time: 2 });
		        });

		        $('#btn-update-member').html('Save Changes');
		      }
		    },
		    success: function(data){
		      var msg = JSON.parse(data);
		      if(msg.result == 'success'){
		        swal({
		          title: 'Great!',
		          text: msg.message,
		          icon: 'success'
		        })
		        $('#edit-chapter-modal').modal('hide');
		        $('#btn-update-chapter').html('Save Changes');
		        location.reload();
		      } else if(msg.result == 'failed'){
		        printErrorMsg(msg.error);
		        $('#btn-update-chapter').html('Save Changes');
		      } else {
		        swal({
		          title: 'Ooops!',
		          text: msg.message,
		          icon: 'error'
		        })
		      }
		    }
		  });
	});
	function viewChapter(id){
		var key = $(id).attr('data-chapter-id');
		$('#btn-update-chapter').attr('data-chapter-id', $(id).attr('data-chapter-id'));
		var url = '/admin/chapter/'+ key;
		  $.ajax({
		    url: url,
		    type: "GET",
		    beforeSend: function() {
		    	$('#frm-update-chapter')[0].reset();
		    },
		    success: function(data) {
		      var msg = JSON.parse(data);
		      if(msg.result == 'success'){
		        $('#edit-chapter-modal').modal({
					toggle: true,
					backdrop: 'static',
					keyboard: false
				});
				$('#view-chap_code').val(msg.chapter.chap_code);
				$('#view-chapter').val(msg.chapter.chapter);
				$('#view-chap_dues').val(msg.chapter.chap_dues);
				$('#view-natl_dues').val(msg.chapter.natl_dues);
				$('#view-date-estab').val(msg.chapter.establishe);
				$('#view-select-reptype').val(msg.chapter.reptype);
				$('#view-select-region').val(msg.chapter.region)
		      }
		    },
		    error: function(xhr, ajaxOptions, thrownError) { // if error occured
		      console.log("Error: " + thrownError);
		    },
		    complete: function() {
		    },
		  });

	}

	function deleteChapter(id){
		swal({
	        title: "Are you sure?",
	        text: "Once deleted, you will not be able to recover data",
	        icon: "warning",
	        buttons: true,
	        dangerMode: true,
	      })
	      .then((willDelete) => {
	        if (willDelete) {
	          $.ajax({
			    url: "/admin/chapter/delete",
			    type: "GET",
			    data: { id: key },
			    beforeSend: function(){ 

			    },
			    error: function(data){
			      if(data.readyState == 4){
			        errors = JSON.parse(data.responseText);

			        $.each(errors,function(key,value){
			          console.log({type: 2, text: value, time: 2 });
			        });

			      }
			    },
			    success: function(data){
			      var msg = JSON.parse(data);
			      if(msg.result == 'success'){ 
			        swal({
			          title: 'Deleted',
			          text: msg.message,
			          icon: 'success'
			        })
			        location.reload();
			      } else{
			        swal({
			          title: 'Ooops!',
			          text: msg.message,
			          type: 'error'
			        })

			      }
			    }
			  });
	        } 
	      }); 
		var key =  $(id).attr('data-chapter-id');
		
	}

	$('#frm-add-chapter').submit(function(e){
		$.ajax({
	        url: "/admin/chapter/add",
	        type: "POST",
	        data: new FormData(this),
	        contentType: false,
	        processData: false,
	        cache: false,
	        beforeSend: function(){ 
	          $('#btn-submit-chapter').prop('disabled', true);
	        },
	        error: function(data){
	          $('#btn-submit-chapter').prop('disabled', false);
	        },
	        success: function(data){
	          var msg = JSON.parse(data);
	          if(msg.result == 'success'){
	            swal({
	              title: 'Great!',
	              text: msg.message,
	              icon: 'success'
	            })
	            $('#add-member-chapter').modal('hide');
	            $("#frm-add-chapter")[0].reset();
	            $('#btn-submit-chapter').prop('disabled', false);
	            location.reload();
	          } else{
	            printErrorMsg(msg.error);
	            $('#btn-submit-chapter').prop('disabled', false);
	          }
	        }
	      });
		e.preventDefault();
	});

	function editChapter(){
		$('input[type="text"]').prop('readonly', false);
	}
	
	$(function () {
		$('#datetimepicker-add-date-estab').datetimepicker({
			format: 'DD/MM/YYYY',
			viewMode: 'years'
		});
	});
	$(document).ready( function () {
		$('#chaptersdb').DataTable({
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
	$(document).ready(function(){
	    $('input[type=text]').keyup(function(){
	        $(this).val($(this).val().toUpperCase());
	    });
	});
	function printErrorMsg (msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display','block');
  $.each( msg, function( key, value ) {
    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
  });
}

</script>

@stop