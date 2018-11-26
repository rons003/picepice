@extends('layouts.dashboard')
@section('page_heading','Membership')
@section('content')
<div class="container-fluid">

  <div class="col-sm-12">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            Member's List
          </div>
          <div class="card-body">
            <div class="row" style="margin-left: 2px;">
              <form id="frm-search-member" method="POST" class="form-inline">
                <div class="input-group mb-3">
                  <input type="text" name="search_prc_no" id="search_prc_no" class="form-control" placeholder="Enter PRC Number" aria-label="Enter PRC Number" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                  </div>

                  <div class="input-group mx-sm-2 mb-3">
                    <input type="text" name="search_ln_fn" id="search_ln_fn" class="form-control" placeholder="Enter firstname or lastname" aria-label="Enter firstname or lastnam" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                          <i class="fa fa-search"></i>
                        </button>
                      </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">              
                    <input type="hidden" name="req_given" value="{{ request()->req_given }}">
                    <input type="hidden" name="req_sur" value="{{ request()->req_sur }}">
                  </form>
                  <form>
                    <button id="btn-add-member" type="button" class="btn btn-info" data-toggle="modal" data-target="#add-member-modal" data-backdrop="static" data-keyboard="false">Create</button>
                    <button type="button" id="delete-link" class="btn btn-info">Delete</button>
                    <button type="button" id="btn-recycle" class="btn btn-info" data-toggle="modal" data-target="#recycle-modal" data-backdrop="static" data-keyboard="false">Recycle</button>     
                  </form>
                </div>
                <div class="row">
                  <table id="datatable-members" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
                    <thead class="thead-dark">
                      <tr>
                        <th></th>
                        <th>Mem Code.</th>
                        <th>PRC Number</th>
                        <th>Surname</th>
                        <th>Given</th>
                        <th>Middlename</th>
                        <th>Snum</th>
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
  </div>      
</div>

<!-- Statement Model -->
<div class="modal fade" id="view-statement-modal" tabindex="-1" role="dialog" aria-labelledby="statementModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h5 class="modal-title">Statement of Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="datatable-statement" class="table table-bordered" cellspacing="0">
            <thead>
              <tr>
                <th>Year Covered</th>
                <th>Natl Due</th>
                <th>Chap Due</th>
                <th>Amount</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="modal-footer">
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Recycle Modal -->
<div class="modal fade" id="recycle-modal" tabindex="-1" role="dialog" aria-labelledby="recycle-modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h5 class="modal-title" id="datatable-membersModalLabel">Delete Logs</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="datatable-recycle-members" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
            <thead class="thead-dark">
              <tr>
                <th>PRC Number</th>
                <th>Surname</th>
                <th>Given</th>
                <th>Middlename</th>
                <th>Action</th>
              </tr>
            </thead>                                   
          </table>
        </div>
        <div class="modal-footer">
 <input type="hidden" name="_token" value="{{ csrf_token() }}">        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Member Info -->
<div class="modal fade" id="view-member-modal" tabindex="-1" role="dialog" aria-labelledby="datatable-membersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="frm-update-member" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="datatable-membersModalLabel">Membership Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
          </div>
          <div class="col-lg-12">
            <div class="row">
              <div class="col-auto">
                <img class="img-thumbnail" src="{{ asset('images/piceicon.png') }}" width="150" height="150" />
              </div>
              <div class="col-sm-9">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label>PRC Number</label>
                    <input type="number" class="form-control" id="prc_no" name="prc_no">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Type of Membership</label>
                    <select class="custom-select mr-sm-4" id="sector-select" name="type_mem" style="margin-bottom: .1rem;">
                      <option value="" disabled selected>Choose:</option>
                      <option value="0">REGULAR</option>
                      <option value="1">ASSOCIATE</option>
                      <option value="2">LIFE MEMBER</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                      <label>Year</label>
                      <input type="number" class="form-control" id="year" name="year">
                    </div>
                </div>  
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Member Code</label>
                    <input type="number" class="form-control" id="mem_code" name="mem_code">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="prc">Date of Membership</label>
                    <div class="input-group date" id="datetimepicker-view-date-mem" data-target-input="nearest">

                      <input type="text" id="view-date-mem" name="date_mem" class="form-control datetimepicker-input" data-target="#datetimepicker-view-date-mem"/>
                      <div class="input-group-append" data-target="#datetimepicker-view-date-mem" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>     
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Chapter</label>
                    <select class="custom-select mr-sm-4" id="view-chapter-select" name="chap_code">
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Life No.</label>
                    <input type="number" class="form-control" id="life_no" name="life_no">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="fn">Firstname</label>
                    <input type="text" class="form-control" name="given" id="given">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="ln">Lastname</label>
                    <input type="text" class="form-control" name="sur" id="sur">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="mn">Middlename</label>
                    <input type="text" class="form-control" name="middlename" id="middlename">
                  </div>
                </div> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="gender">Gender</label>
                    <select name="gender" id="view-gender" class="form-control">
                      <option value="MALE">MALE</option>
                      <option value="FEMALE">FEMALE</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="civilstat">Civil Status</label>
                    <select id="view-civilstat" name="civilstat" class="form-control">
                      <option value="SINGLE">SINGLE</option>
                      <option value="MARRIED">MARRIED</option>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="prc">Email Address</label>
                    <input type="text" class="form-control" id="e_mail" name="e_mail" placeholder="Email Address">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="prc">Date of Birth</label>
                    <div class="input-group date" id="datetimepicker-view-birthdate" data-target-input="nearest">

                      <input type="text" id="view-birthdate" name="birthdate" class="form-control datetimepicker-input" data-target="#datetimepicker-view-birthdate"/>
                      <div class="input-group-append" data-target="#datetimepicker-view-birthdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div> 
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label>Mobile Number</label>
                    <input type="text" class="form-control" id="cell_no" name="cell_no">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Home Tel. Number</label>
                    <input type="text" class="form-control" id="home_tel" name="home_tel">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Home Fax</label>
                    <input type="text" class="form-control" id="home_fax" name="home_fax">
                  </div> 
                </div>
                <div class="form-group">
                  <label>Place of Birth</label>
                  <input type="text" class="form-control" name="birthplace" id="birthplace">
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Home Address</label>
                    <textarea type="text" class="form-control" id="address1" name="address1"></textarea>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Office Address</label>
                    <textarea type="text" class="form-control" name="office" id="office"></textarea>
                  </div> 
                </div>   
                <div class="form-group">
                  <label for="inputEmail4">Position</label>
                  <input type="text" class="form-control" id="position" name="position">
                </div>
                <div class="form-group">
                  <label>School</label>
                  <input type="text" class="form-control" id="school" name="school">
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Education (Degree)</label>
                    <input type="text" class="form-control" id="degree" name="degree">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Year Graduated</label>
                    <input type="text" class="form-control" id="yeargrad" name="yeargrad">  
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Sector</label>
                    <select class="custom-select mr-sm-4" id="view-sector-select" name="sektor" style="margin-bottom: .1rem;">
                      <option value="" disabled selected>Choose:</option>
                      <option value="GOVERNMENT">GOVERNMENT</option>
                      <option value="PRIVATE">PRIVATE</option>
                      <option value="OCW">OCW</option>
                      <option value="OTHERS">OTHERS</option>
                    </select>
                    <input type="text" class="form-control" id="view-other-sector" name="other-sector" disabled>  
                  </div>
                  <div class="form-group col-md-6">
                    <label>Areas of Practice</label>
                    <select class="custom-select mr-sm-4" id="view-sector-select" name="praktis" style="margin-bottom: .1rem;">
                      <option value="" disabled selected>Choose:</option>
                      <option value="CONSTRUCTION">CONSTRUCTION</option>
                      <option value="DESIGN">DESIGN</option>
                      <option value="ACADEME">ACADEME</option>
                      <option value="COMMERCIAL">COMMERCIAL</option>
                    </select>
                    <input type="text" class="form-control" id="view-other-areas" name="other-areas" disabled>  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">          
          <input type="hidden" id="id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit" id="btn-update-member">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--ADD modal -->
<div class="modal fade" id="add-member-modal" tabindex="-1" role="dialog" aria-labelledby="datatable-membersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="frm-add-member">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="datatable-membersModalLabel">Member Registration</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
          </div>
          <div id="smartwizard">

            <ul class="nav nav-tabs nav-justified" role="tablist">
              <li class="nav-item"><a class="nav-link" href="#member-info-tab">Step 1<br /><small>Member Info</small></a></li>
              <li class="nav-item"><a class="nav-link" href="#other-info-tab">Step 2<br /><small>Other Info</small></a></li>
            </ul>

            <div class="tab-content">
              <div id="member-info-tab">
                <div class="row" style="padding: 1rem;">
                  <div class="col-lg-12">
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label>PRC Number</label>
                        <input type="number" class="form-control" id="prc_no" name="prc_no">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputEmail4">Member Code</label>
                        <input type="number" class="form-control" id="mem_code" name="mem_code">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="prc">Date of Membership</label>
                        <div class="input-group date" id="datetimepicker-add-date-mem" data-target-input="nearest">

                          <input type="text" id="add-date-mem" name="date_mem" class="form-control datetimepicker-input" data-target="#datetimepicker-add-date-mem"/>
                          <div class="input-group-append" data-target="#datetimepicker-add-date-mem" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Chapter</label>
                        <select class="custom-select mr-sm-4" id="chapter-select" name="chap_code">
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Type of Membership</label>
                        <select class="custom-select mr-sm-4" id="sector-select" style="margin-bottom: .1rem;">
                          <option value="" disabled selected>Choose:</option>
                          <option value="0">REGULAR</option>
                          <option value="1">ASSOCIATE</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label>First Name</label>
                        <input type="text" class="form-control" id="given" name="given" placeholder="First Name" required>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Last Name</label>
                        <input type="text" class="form-control" id="sur" name="sur" placeholder="Last Name" required>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name" required autofocus>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail4">Position</label>
                      <input type="text" class="form-control" id="position" name="position">
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Sector</label>
                        <select class="custom-select mr-sm-4" id="sector-select" name="sektor" style="margin-bottom: .1rem;">
                          <option value="" disabled selected>Choose:</option>
                          <option value="GOVERNMENT">GOVERNMENT</option>
                          <option value="PRIVATE">PRIVATE</option>
                          <option value="OCW">OCW</option>
                          <option value="OTHERS">OTHERS</option>
                        </select>
                        <input type="text" class="form-control" id="other-sector" name="other-sector" disabled>  
                      </div>
                      <div class="form-group col-md-6">
                        <label>Areas of Practice</label>
                        <select class="custom-select mr-sm-4" id="sector-select" name="praktis" style="margin-bottom: .1rem;">
                          <option value="" disabled selected>Choose:</option>
                          <option value="CONSTRUCTION">CONSTRUCTION</option>
                          <option value="DESIGN">DESIGN</option>
                          <option value="ACADEME">ACADEME</option>
                          <option value="COMMERCIAL">COMMERCIAL</option>
                        </select>
                        <input type="text" class="form-control" id="other-areas" name="other-areas" disabled>  
                      </div>
                    </div>           
                  </div>
                </div>
              </div>
              <div id="other-info-tab">
                <div class="row" style="padding: 1rem;">
                  <div class="col-lg-12">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Gender</label>
                        <select id="gender" name="gender" class="form-control">
                          <option value="" disabled selected>Choose:</option>
                          <option value="MALE">MALE</option>
                          <option value="FEMALE">FEMALE</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Civil Status</label>
                        <select id="civilstat" name="civilstat" class="form-control">
                          <option value="" disabled selected>Choose:</option>
                          <option value="S">SINGLE</option>
                          <option value="M">MARRIED</option>
                        </select>
                      </div>
                    </div>    
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Email Address</label>
                        <input type="email" class="form-control" id="e_mail" name="e_mail">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputPassword4">Date of Birth</label>
                        <div class="input-group date" id="datetimepicker-add-birthdate" data-target-input="nearest">
                          <input type="text" name="birthdate" class="form-control datetimepicker-input" data-target="#datetimepicker-add-birthdate"/>
                          <div class="input-group-append" data-target="#datetimepicker-add-birthdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label>Mobile Number</label>
                        <input type="text" class="form-control" id="cell_no" name="cell_no">
                      </div>
                      <div class="form-group col-md-4">
                        <label>Home Tel. Number</label>
                        <input type="text" class="form-control" id="home_tel" name="home_tel">
                      </div>
                      <div class="form-group col-md-4">
                        <label>Home Fax</label>
                        <input type="text" class="form-control" id="home_fax" name="home_fax">
                      </div> 
                    </div>
                    <div class="form-group">
                      <label>Place of Birth</label>
                      <input type="text" class="form-control" name="birthplace">
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Home Address</label>
                        <textarea type="text" class="form-control" id="address1" name="address1"></textarea>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Office Address</label>
                        <textarea type="text" class="form-control" name="office" id="office"></textarea>
                      </div> 
                    </div> 
                    <div class="form-group">
                      <label>School</label>
                      <input type="text" class="form-control" id="school" name="school">
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Education (Degree)</label>
                        <input type="text" class="form-control" id="degree" name="degree">
                      </div>
                      <div class="form-group col-md-6">
                        <label>Year Graduated</label>
                        <input type="number" class="form-control" id="yeargrad" name="yeargrad">  
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btn-submit-create" class="btn btn-primary">Submit</button>
        </div>
      </div>      
      <input type="hidden" name="_token" value="{{ csrf_token() }}">   
</form>
  </div>
</div>
<!-- -->
<!-- invoices modal -->
<div class="modal fade" id="view-invoices-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Invoices</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table id="invoiceHistory" class="table table-striped table-bordered dt-responsive" cellspacing="0" style="width:100%" >
          <thead class="thead-dark">
            <tr>              
              <th>Name</th>
              <th>Invoice #</th>
              <th>Type</th>
              <th>Total</th>
              <th>Due Date</th>
              <th>Status</th>
              <th></th>
            </tr>
            <thead>                 
            </table>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="view-invoices-detail">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Invoices</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <table id="invoiceHistory" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%" >
              <thead class="thead-dark">
                <tr>              
                  <th>Name</th>
                  <th>Invoice #</th>
                  <th>Type</th>
                  <th>Total</th>
                  <th>Due Date</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                <thead>                 
                </table>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>    
        <!-- Admin Page js files -->
        <script src="{{ asset("pice/admin/js/membership/index.js") }}" type="text/javascript"></script>
        @stop
