@extends('layouts.members_page')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              My Info
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <form id="frm-membership-profile">
                    <div class="row" style="margin-bottom: 1rem; margin-left: .1rem;">
                      <button type="button" class="btn btn-link btn-sm" id="edit-btn" style="margin-right: 10px;">Edit</button>
                      <button type="submit" class="btn btn-primary btn-sm" id="btn-save" disabled>Save Changes</button>
                    </div>
                    <div class="row" id="person-info">
                      <div class="col">
                        <h5 class="card-title">Personal Information</h5>               
                          <div class="form-row">
                            <div class="form-group col-md-4">
                              <label for="fn">Firstname</label>
                              <input type="text" class="form-control" disabled id="given" name="given">
                            </div>
                            <div class="form-group col-md-4">
                              <label for="ln">Lastname</label>
                              <input type="text" class="form-control" disabled id="sur" name="sur">
                            </div>
                            <div class="form-group col-md-4">
                              <label for="mn">Middlename</label>
                              <input type="text" class="form-control" disabled id="middlename" name="middlename">
                            </div>               
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-4">
                              <label for="gender">Gender</label>
                              <select id="gender" class="form-control" disabled name="gender">
                                <option value="MALE">MALE</option>
                                <option value="FEMALE">FEMALE</option>
                              </select>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="civilstat">Civil Status</label>
                              <select id="civilstat" class="form-control" disabled name="civilstat">
                                <option>SINGLE</option>
                                <option>MARRIED</option>
                              </select>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="prc">Date of Birth</label>
                              <div class="input-group date" id="datetimepicker1" data-target-input="nearest">

                                <input type="text" class="form-control datetimepicker-input" name="birthdate" id="birthdate" data-target="#datetimepicker1" disabled />
                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-row">
                         <div class="form-group col-md-6">
                            <label for="prc">PRC No</label>
                            <input type="text" class="form-control" disabled id="prc_no" name="prc_no">
                          </div>

                          <div class="form-group col-md-6">
                            <label for="prc">Email Address</label>
                            <input type="email" class="form-control" disabled id="e_mail" name="e_mail">
                          </div>
                          </div>
                          <div class="form-group">
                            <label for="fn">Place of Birth</label>
                            <textarea type="text" class="form-control" disabled id="birthplace" name="birthplace"></textarea>
                          </div>  

                          <div class="form-group">
                            <label for="prc">Mobile Number</label>
                            <input type="text" class="form-control" disabled id="cell_no" name="cell_no">
                          </div>
                          <div class="form-group">
                            <label for="gender">Home Tel. Number:</label>
                            <input type="text" class="form-control" disabled id="home_tel" name="home_tel">
                          </div>
                          <div class="form-group">
                            <label for="gender">Home Fax</label>
                            <input type="text" class="form-control" disabled id="home_fax" name="home_fax">
                          </div>     
                          <div class="form-group">
                            <label for="fn">Home Address:</label>
                            <textarea type="text" class="form-control" disabled id="address1" name="address1"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="fn">Company Address:</label>
                            <textarea type="text" class="form-control" disabled id="address2" name="address2"></textarea>
                          </div>          
                      </div>
                      <div class="col">
                        <h5 class="card-title">Other Info</h5>
                          <div class="form-group">
                            <label for="gender">Chapter</label>
                            <input type="text" class="form-control" disabled id="chapter" name="chapter">
                          </div>   
                          <div class="form-group">
                            <label for="gender">Chapter Code</label>
                            <input type="text" class="form-control" disabled id="chap_code" name="chap_code">
                          </div>    
                          <div class="form-group">
                            <label for="gender">Year</label>
                            <input type="text" class="form-control" disabled id="year" name="year">
                          </div>     
                          <div class="form-group">
                            <label for="civilstat">Position</label>
                            <input type="text" class="form-control" disabled id="position" name="position">
                          </div>
                          <div class="form-group">
                            <label for="civilstat">Sector</label>
                            <input type="text" class="form-control" disabled id="sektor" name="sektor">
                          </div>
                          <div class="form-group">
                            <label for="civilstat">Areas of Practice</label>
                            <input type="text" class="form-control" disabled id="praktis" name="praktis">
                          </div>
                          <div class="form-group">
                            <label for="prc">Type of Membership</label>
                            <input type="text" class="form-control" disabled id="type_mem" name="type_mem">
                          </div>
                          <div class="form-group">
                            <label for="prc">Education (Degree)</label>
                            <input type="text" class="form-control" disabled id="degree" name="degree">
                          </div>
                          <div class="form-group">
                            <label for="gender">School</label>
                            <input type="text" class="form-control" disabled id="school" name="school">
                          </div>
                          <div class="form-group">
                            <label for="gender">Year Graduated</label>
                            <input type="text" class="form-control" disabled id="yeargrad" name="yeargrad">
                          </div>
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
</div>   

<!-- Membership js files -->
<script src="{{ asset("pice/member/js/index.js") }}" type="text/javascript"></script>

@stop
