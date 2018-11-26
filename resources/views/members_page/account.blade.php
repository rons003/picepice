@extends('layouts.members_page')
@section('page_heading','My Account')
@section('section')

<div class="col-sm-12">
	<div class="row">
		<div class="col-lg-5">
			<div class="panel panel-primary text-left">
				<div class="panel-heading clearfix">
					<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Account Information</h4>
				</div>				
				<div class="panel-body">
					<form>
						<div class="form-group">
							<label>Email Address: {{$user_info['email']}}</label>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
