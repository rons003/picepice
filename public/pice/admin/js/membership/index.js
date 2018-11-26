$(document).ready( function () {
  getMember();
  getChapters();
});
$('#btn-add-member').click(function(){
  $("#frm-add-member")[0].reset();
  $('.print-error-msg').hide();
});
var table;
$('#frm-add-member').submit(function(e){
      $.ajax({
        url: "/admin/membership/add",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function(){ 
          $('#btn-submit-create').prop('disabled', true);
        },
        error: function(data){
          $('#btn-submit-create').prop('disabled', false);
        },
        success: function(data){
          var msg = JSON.parse(data);
          if(msg.result == 'success'){
            swal({
              title: 'Great!',
              text: msg.message,
              icon: 'success'
            })
            $('#add-member-modal').modal('hide');
            //$('#add-member-modal').modal('dispose');
            $('#smartwizard').smartWizard("reset");
            $("#frm-add-member")[0].reset();
            $('#btn-submit-create').prop('disabled', false);
          } else{
            printErrorMsg(msg.error);
            $('#btn-submit-create').prop('disabled', false);
          }
        }
      });
      e.preventDefault();
    });

$(document).ready(function (){
  // Toolbar extra buttons
  var btnFinish = $('<button id="btn-submit-create"></button>').text('Finish')
  .addClass('btn btn-info')
  .on('click', function(){ 
     });

  var btnCancel = $('<button></button>').text('Reset')
  .addClass('btn btn-danger')
  .on('click', function(){ $('#smartwizard').smartWizard("reset"); });

            // Smart Wizard
            $('#smartwizard').smartWizard({
              selected: 0,
              showStepURLhash: false,
              theme: 'arrows',
              transitionEffect:'fade',
              toolbarSettings: {toolbarPosition: 'bottom'
            }
          });
          });

function viewMember(id)
{ 
  $('.print-error-msg').hide();
  $('#btn-update-member').attr('data-member-id', $(id).attr('data-member-id')); 
  var members_id = $(id).attr('data-member-id');
  $.get('/admin/membership/'+members_id, function(data){            
    var msg = JSON.parse(data);            
    if(msg.result == 'success'){
      $('#prc_no').val(msg.data.prc_no);
      $('#view-chapter-select').val(msg.data.chap_code);
      $('#view-date-mem').val(msg.data.date_mem);
      $('#given').val(msg.data.given);
      $('#sur').val(msg.data.sur);
      $('#middlename').val(msg.data.middlename);
      if(msg.data.gender == "M"){
        $('#view-gender').val('MALE');
      } 
      else if(msg.data.gender == "FEMALE"){
        $('#view-gender').val('FEMALE');
      } 
      else if(msg.data.gender == "MALE") {
        $('#view-gender').val('MALE');
      }
      else {
        $('#view-gender').val('FEMALE');
      }

      
      if(msg.data.civilstat == "M"){
        $('#view-civilstat').val('MARRIED');
      } else if(msg.data.civilstat == "S"){
        $('#view-civilstat').val('SINGLE');
      }
      $('#view-birthdate').val(msg.data.birthdate);
      $('#birthplace').val(msg.data.birthplace);
      $('#office').val(msg.data.office);
      $('#e_mail').val(msg.data.e_mail);
      $('#cell_no').val(msg.data.cell_no);
      $('#address1').val(msg.data.address1);
      $('#home_fax').val(msg.data.home_fax);
      $('#home_tel').val(msg.data.home_tel);

      $('#position').val(msg.data.position);
      $('#sektor').val(msg.data.sektor);
      $('#praktis').val(msg.data.praktis);
      $('#degree').val(msg.data.degree);
      $('#school').val(msg.data.school);
      $('#yeargrad').val(msg.data.yeargrad);
      $('#year').val(msg.data.year);
      $('#life_no').val(msg.data.life_no);

      $('#mem_code').val(msg.data.mem_code);
    }
  });

}

function viewInvoices(id)
{  
  var members_id = $(id).attr('data-member-id');

  $.get('/admin/invoices/'+members_id, function(data){            
    var msg = JSON.parse(data);            
    if(msg.result == 'success'){
      $('#invoiceHistory').DataTable().destroy(); 
      $('#invoiceHistory').dataTable({
        processing: true,
        data: msg.data,
        bFilter: false,
        bPaginate: false,
        order: [0, 'desc'],
        columns: [
        { data: 'name'},
        { data: 'invoicenumber'},
        { data: 'type'},
        { data: 'total'},
        { data: 'duedate'},
        { data: 'status'},
        {
          'render' : function (data, type, full, meta){
            data = '';
            for (var i in full['invoiceLineItems']) {
              if (full['invoiceLineItems'][i])
              { 
                data = data + " " + full['invoiceLineItems'][i].type + " <br/> ";
              }   

            }
            return data;
          }
        }
        ]
      });    

    }
  });
}

function viewInvoiceDetail(id)
{  
  var members_id = $(id).attr('data-xero-id');

  $.get('/admin/invoices/'+members_id, function(data){            
    var msg = JSON.parse(data);            
    if(msg.result == 'success'){
      $('#invoiceHistory').DataTable().destroy(); 
      $('#invoiceHistory').dataTable({
        processing: true,
        data: msg.data,
        bFilter: false,
        bPaginate: false,
        order: [0, 'desc'],
        columns: [
        { data: 'name'},
        { data: 'invoicenumber'},
        { data: 'type'},
        { data: 'total'},
        { data: 'duedate'},
        { data: 'status'},
        {
          'render' : function (data, type, full, meta){             
            data = '<button id="btn-view-claim" onclick="viewMember(this)" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#view-invoices-detail" data-member-id="'+full['id']+'" data-backdrop="static" data-keyboard="false">View</button>'
            return data;
          }
        }
        ]
      });    

    }
  });
}

function getDeletedMember(){
  var url = '/admin/mem/getdeletedmember';
  $.ajax({
    url: url,
    type: "GET",
    beforeSend: function() {
      $('#datatable-recycle-members').DataTable().destroy(); 
    },
    success: function(data) {
      var msg = JSON.parse(data);
      if(msg.result == 'success'){
        table = $('#datatable-recycle-members').DataTable({
          searching: false,
          processing: true,
          data: msg.data.data,
          responsive: true,
          columns: [
          { data: 'prc_no'},
          { data: 'sur'},
          { data: 'given'},
          { data: 'middlename'},
          {
            'render' : function (data, type, full, meta){             
              data = '<button id="btn-restore-member" onclick="restoreMember(this)" type="button" class="btn btn-primary btn-sm" data-restore-id="'+full['id']+'">Restore</button>'
              return data;
            }
          }
          ],
          order: [[ 2, 'asc' ]],
        });          
      }
    },
    error: function(xhr, ajaxOptions, thrownError) { // if error occured
      console.log("Error: " + thrownError);
    },
    complete: function() {
    },
  });
}

function restoreMember(id){
  var id = $(id).attr('data-restore-id');
  $.ajax({
    url: "/admin/membership/restoremember/" + id,
    type: "GET",
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
          title: 'Restore',
          text: msg.message,
          icon: 'success'
        })
        getDeletedMember();
        getMember();
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

$('#btn-recycle').click(function(){
  getDeletedMember();
});

function getMember(){
  var formData = new FormData();
  formData.append('search_ln_fn', $('input[name="search_ln_fn"]').val());
  formData.append('req_given', $('input[name="req_given"]').val());
  formData.append('req_sur', $('input[name="req_sur"]').val());
  formData.append('search_prc_no', $('input[name="search_prc_no"]').val());

  var url = '/admin/membership/getmemberall';
  $.ajax({
    url: url,
    headers:
    {
      'X-CSRF-Token': $('input[name="_token"]').val()
    },
    type: "POST",
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
      $('#datatable-members').DataTable().destroy(); 
    },
    success: function(data) {
      var msg = JSON.parse(data);
      if(msg.result == 'success'){
        table = $('#datatable-members').DataTable({
          searching: false,
          processing: true,
          data: msg.data.data,
          responsive: true,
          "language": {
            "paginate": {
              "previous": "<",
              "next": ">"
            }
          },
          columns: [
          { data: 'id'},
          { data: 'mem_code'},
          { data: 'prc_no'},
          { data: 'sur'},
          { data: 'given'},
          { data: 'middlename'},
          { data: 'snum'},
          {
            'render' : function (data, type, full, meta){
              if(full['xero_id'] != null){
                data = '<button id="btn-view-claim" onclick="viewMember(this)" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#view-member-modal" data-member-id="'+full['id']+'" data-backdrop="static" data-keyboard="false">View</button> <button id="btn-view-claim" onclick="viewInvoices(this)" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#view-invoices-modal" data-member-id="'+full['xero_id']+'" data-backdrop="static" data-keyboard="false">View Invoices</button>'

              } else {
                data = '<button id="btn-view-claim" onclick="viewMember(this)" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#view-member-modal" data-member-id="'+full['id']+'" data-backdrop="static" data-keyboard="false">View</button>'
              }
              return data;

            }
          }
          ],
          "order": [[3, "asc"]],
          "order": [[4, "asc"]],
          'columnDefs': [
          {
            'targets': 0,
            'searchable':false,
            'orderable':false,
            'width': '1%',
            'checkboxes': {
             'selectRow': true
           }
         },
         { responsivePriority: 1, targets: 1 },
         ],
         'select': {
           'style': 'multi',
           selector: 'td:first-child'
         },
       });          
      }
    },
          error: function(xhr, ajaxOptions, thrownError) { // if error occured
            console.log("Error: " + thrownError);
          },
          complete: function() {
          },
        });
}
function deleteMember($member_array){
  var id = $member_array;
  $.ajax({
    url: "/admin/membership/delete",
    type: "GET",
    data: { id: id },
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
        return 'deleted';
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

$(function () {
  $('#datetimepicker-add-birthdate').datetimepicker({
    format: 'DD/MM/YYYY',
    viewMode: 'years'
  });
  $('#datetimepicker-view-birthdate').datetimepicker({
    format: 'DD/MM/YYYY',
    viewMode: 'years'
  });
  $('#datetimepicker-view-date-mem').datetimepicker({
    format: 'DD/MM/YYYY',
    viewMode: 'years'
  });
  $('#datetimepicker-add-date-mem').datetimepicker({
    format: 'DD/MM/YYYY',
    viewMode: 'years'
  });
});

$('#frm-update-member').on('submit', (function(e){
  e.preventDefault();
  $.ajax({
    url: "/admin/membership/update/"+$('#btn-update-member').attr('data-member-id'),
    type: "POST",
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function(){ 
      $('#btn-update-member').html('Processing...');
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
        $('#view-member-modal').modal('hide');
        $('#btn-update-member').html('Save Changes');
        getMember();
      } else if(msg.result == 'failed'){
        printErrorMsg(msg.error);
        $('#btn-update-member').html('Save Changes');
      } else {
        swal({
          title: 'Ooops!',
          text: msg.message,
          icon: 'error'
        })
        $('#btn-update-member').props('disabled',false);
      }
    }
  });
}));

$('#frm-search-member').on('submit', (function(e){
  e.preventDefault();
  getMember();
}));

$('#delete-link').click(function(){
  var rows_selected = table.column(0).checkboxes.selected();
  var member_id = [];
        // Iterate over all selected checkboxes
        $.each(rows_selected, function(index, rowId){
          member_id.push(rowId);
        });
        if(member_id != ''){
          swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover data",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              deleteMember(member_id);
              $.each(rows_selected, function(index, rowId){
                table.row('.selected').remove().draw( false );
              });
            } 
          });  
        }
        
      });


$(document).ready(function(){
    $('input[type=text]').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });
});

function getChapters(){
  var url = "/admin/home/getchapter";
  $.ajax({
    url: url,
    type: "GET",
    beforeSend: function(){ 
      $('#chapter-select').empty();
      $('#view-chapter-select').empty();
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
        $.each(msg.chapter, function(i,value){
          $('#chapter-select').append('<option value="'+value['chap_code']+'">'+value['chapter']+'</option>');
          $('#view-chapter-select').append('<option value="'+value['chap_code']+'">'+value['chapter']+'</option>');
        });
      }
    }
  });
}

$('#sector-select').on('change', function() {
  if(this.value == 'OTHERS'){
    $('#other-sector').prop('disabled', false);
  } else {
    $('#other-sector').val("");
    $('#other-sector').prop('disabled', true);
  }
});

$('#areas-select').on('change', function() {
  if(this.value == 'OTHERS'){
    $('#other-areas').prop('disabled', false);
  } else {
    $('#other-areas').val("");
    $('#other-areas').prop('disabled', true);
  }
});

function printErrorMsg (msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display','block');
  $.each( msg, function( key, value ) {
    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
  });
}