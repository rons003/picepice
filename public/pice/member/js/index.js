$('#edit-btn').click(function (){
    // $("#frm-membership-profile :input").prop("disabled", false);
    $("#e_mail, #cell_no, #home_tel, #home_fax, #address1, #position, #sektor, #gender").prop("disabled", false);
    $('#btn-save').prop("disabled" , false);
  });

  $('#frm-membership-profile').on('submit', (function(e){
    e.preventDefault();
    $.ajax({
      url: "/member/profile/update",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function(){ 
        $('#btn-save').html('Processing...');
      },
      error: function(data){
        if(data.readyState == 4){
          errors = JSON.parse(data.responseText);

          $.each(errors,function(key,value){
            console.log({type: 2, text: value, time: 2 });
          });

          $('#btn-save').html('Save Changes');
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
          getProfile();
          $('#btn-save').html('Save Changes');
          // $("#frm-membership-profile :input").prop("disabled", true);
          $("#e_mail, #cell_no, #home_tel, #home_fax, #address1, #position, #sektor, #gender").prop("disabled", true);
          $('#edit-btn').prop("disabled", false);
        } else{
          swal({
            title: 'Ooops!',
            text: msg.message,
            icon: 'error'
          })

        }
      }
    });
  }));

  $(function () {
    $('#datetimepicker1').datetimepicker({
      format: 'L',
      viewMode: 'years'
    });
  });



  function getProfile(){
    var url = '/member/getmemberinfo';
    $.ajax({
     type: 'GET',
     url: url,
     beforeSend: function() {
     },
     success: function(data) {
       var msg = JSON.parse(data);            
       if(msg.result == 'success'){
        $.each( msg.data, function( i, value ) {
          //--Nav header profile
          //var html = '';
          //html += '<h2 class="h5">'+value['given']+' ' +value['sur']+'</h2>';
          //html += '<span>PRC No. '+value['prc_no']+'</span>';
          //$('#header-profile').html(html);
          //---end header profile
          $('#given').val(value['given']);
          $('#sur').val(value['sur']);
          $('#middlename').val(value['middlename']);
          if(value['gender'] == "M"){
            $('#gender').val('MALE');
          } 
          else if(value['gender'] == "FEMALE"){
            $('#gender').val('FEMALE');
          } 
          else if(value['gender'] == "MALE") {
            $('#gender').val('MALE');
          }
          else {
            $('#gender').val('FEMALE');
          }


          if(value['civilstat'] == "M"){
            $('#civilstat').val('MARRIED');
          } else if(value['civilstat'] == "S"){
            $('#civilstat').val('SINGLE');
          }
          $('#birthplace').val(value['birthplace']);
          $('#birthdate').val(value['birthdate']);
          $('#e_mail').val(value['e_mail']);
          $('#cell_no').val(value['cell_no']);
          $('#address1').val(value['address1']);
          $('#home_fax').val(value['home_fax']);
          $('#home_tel').val(value['home_tel']);
          $('#prc_no').val(value['prc_no']);

          $('#position').val(value['position']);
          $('#sektor').val(value['sektor']);
          $('#praktis').val(value['praktis']);
          $('#date_mem').val(value['date_mem']);
          $('#degree').val(value['degree']);
          $('#school').val(value['school']);
          $('#yeargrad').val(value['yeargrad']);

          $('#chap_code').val(value['chap_code']);
          $('#chapter').val(value['chapter']);
          $('#chap_no').val(value['chap_no']);
          $('#year').val(value['year']);
        });

      }
    },
    error: function(e) { // if error occured

    },
    complete: function() {

    },
  });
  }

$(document).ready(function () {
  getProfile();
});
