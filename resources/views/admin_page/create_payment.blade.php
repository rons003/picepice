@extends('layouts.dashboard') 
@section('page_heading','Payment') 
@section('content')

<!-- Statament Modal -->
<div class="modal fade" id="statement-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Statement of Account</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger print-error-msg" style="display:none">
					<ul></ul>
				</div>
				<div class="col-lg-12">
					<div class="row" style="margin-bottom: .3rem;">
						<div class="col-lg-12">
							<form>
								<div class="form-row align-items-center">
									<div class="col-auto">
										<div class="input-group input-group-sm mb-2">
											<div class="input-group-prepend">
												<div class="input-group-text"><span id="arrears-year"></span></div>
											</div>
											<select class="custom-select mr-sm-4" id="select-year-cb">
											</select>
										</div>
									</div>
									<div class="col-auto">
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="idrenewal-cb">
											<label class="form-check-label" for="autoSizingCheck">
												ID Renewal
											</label>
										</div>
									</div>
									<div class="col-auto">
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="life-cb" disabled>
											<label class="form-check-label" for="autoSizingCheck">
												Life Member
											</label>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row">
						<table id="datatable-statement" class="table table-bordered">
							<thead>
								<tr>
									<td id="par" colspan="3">
										<div>
											<p>NAME: <strong id="fn"></strong></p>
											<p>Chapter: <strong id="chapter"></strong></p>
											<p>Date Prepared: </p>
										</div>
									</td>
									<td>
										<div>
											<p>Contact No.: <strong id="cell_no"></strong></p>
											<p>Tel/Fax: <strong id="tel_fax"></strong></p>
										</div>
									</td>
								</tr>
								<tr>
									<td id="par" colspan="3">
										<div>
											<p>Arrears: <strong id="arrears"></strong> - <strong id="arrears-to"></strong></p>
										</div>
									</td>
									<td>
										<div>
											<p>Membership Type: <strong id="mem_type">Regular</strong></p>
										</div>
									</td>
								</tr>
								<tr class="text-center">
									<th>YEAR COVERED</th>
									<th>NATIONAL DUES</th>
									<th>CHAPTER DUES</th>
									<th>COMPUTATION</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="col-lg-12">
					<form id="frm-create-payment">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="form-group col">
										<label>Amount</label>
										<input type="number" class="form-control" name="amount" id="amount" placeholder="Enter Amount" required autofocus>
									</div>
									<div class="form-group col">
										<label>OR Number</label>
										<input type="number" class="form-control" name="or_number" id="or_number" placeholder="OR Number" required autofocus>
									</div>
									<div class="form-group col">
										<label for="prc">Date of Paid</label>
										<div class="input-group date" id="datetimepicker-date-paid" data-target-input="nearest">

											<input type="text" id="date-paid" name="date_paid" class="form-control datetimepicker-input" data-target="#datetimepicker-date-paid"
											/>
											<div class="input-group-append" data-target="#datetimepicker-date-paid" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row text-right">
							<div class="col-lg-12">
								<button type="submit" id="btn-create-payment" class="btn btn-primary">SUBMIT</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Payment History Modal -->
<div class="modal fade" id="payment-history-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Payment History</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<table id="datatable-payment-history" class="table table-bordered" cellspacing="0" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>OR Number</th>
								<th>Last Pay</th>
								<th>Remarks</th>
								<th>Reinstatement</th>
								<th>Total</th>
								<th>Date Paid</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			Create Payment
		</div>
		<div class="card-body">
			<div class="col-lg-12">
				<label>Filter By</label>
				<div class="row" style="margin-left: .2rem;">
					<form id="frm-search-statement">
						<div class="form-group">
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">Last Name</span>
								</div>
								<input type="text" name="search_statement" id="search_statement" class="form-control" placeholder="Enter Surname" aria-label="Enter PRC Number"
								 aria-describedby="basic-addon2">
								<div class="input-group-append">
									<span class="input-group-btn">
												<button id="btn-search" class="btn btn-default" type="submit">
													<i class="fa fa-search"></i>
												</button>
											</div>
										</div>
									</div>
				
								</form>
							</div>
							<div class="row">
								<table id="datatable-member" class="table table-bordered" cellspacing="0">
									<thead class="thead-dark">
										<tr>
											<th>PRC Number</th>
											<th>Surname</th>
											<th>Given</th>
											<th>Middle Name</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
		</div>
	</div>
	
	</div>
	<script src="{{ asset("pice/admin/js/payment/payment.js") }}" type="text/javascript"></script>
	



















@stop