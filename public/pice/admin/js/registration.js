$(document).ready(function () {
        getRegistration();
});

function callDeleteMember(button) {
    var prc_no = $(button).attr('data-member-prc_no');
    if (prc_no != '') {
        var url = '/admin/deleteAccount/' + prc_no;
        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function () {

            },
            success: function (data) {
                var msg = JSON.parse(data);
                if (msg.result == 'success') {

                    getRegistration();
                    swal(
                        'Deleted!',
                        'Please Inform Member to Register Again.',
                        'success'
                    );

                } else {
                    swal({
                        title: "Error",
                        text: msg.message,
                        icon: "error",
                    });

                }
            },
            error: function (xhr, ajaxOptions, thrownError) { // if error occured
                console.log("Error: " + thrownError);
            },
            complete: function () {
                $('#btn-delete').prop("disabled", false);
            },
        });
    }
}

function callApproveMember(button)
{
    var prc_no = $(button).attr('data-member-prc_no');
    if (prc_no != '') {
        var url = '/admin/verifyAccount/' + prc_no;
        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function () {
                
            },
            success: function (data) {
                var msg = JSON.parse(data);
                if (msg.result == 'success')
                {
                  
                  getRegistration();
                  swal(
                       'Approved!',
                       'A Member can now access the Portal.',
                       'success'
                  );
                    
                } else {
                    swal({
                        title: "Error",
                        text: msg.message,
                        icon: "error",
                    });

                }
            },
            error: function (xhr, ajaxOptions, thrownError) { // if error occured
                console.log("Error: " + thrownError);
            },
            complete: function () {
                $('#btn-approve').prop("disabled", false); 
             },
        });
    }
}

function approveMember(button)
{
    
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        buttons: true,                
    }).then((value) => {
        if (value) {            
            $("[id=btn-approve]").prop("disabled", true);  
            callApproveMember(button);           
        }
    });
}

function deleteMember(button) {

    swal({
        title: 'Are you sure you want to Delete?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        buttons: true,
    }).then((value) => {
        if (value) {
            $("[id=btn-delete]").prop("disabled", true);
            callDeleteMember(button);
        }
    });
}

function resyncAccount(button) {
    var prc_no = $(button).attr('data-member-prc_no');
    if (prc_no != '') {
        var url = '/admin/resyncAccount/' + prc_no;
        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function () {

            },
            success: function (data) {
                var msg = JSON.parse(data);
                if (msg.result == 'success') {

                    getRegistration();
                    swal(
                        'Resync!',
                        'Resync Completed.',
                        'success'
                    );

                } else {
                    swal({
                        title: "Info",
                        text: msg.message,
                        icon: "info",
                    });

                }
            },
            error: function (xhr, ajaxOptions, thrownError) { // if error occured
                console.log("Error: " + thrownError);
            },
            complete: function () {
                $('#btn-approve').prop("disabled", false);
            },
        });
    }
}

$('#btn-refresh').click(function () {
    getRegistration();
});

function getRegistration() {
    var formData = new FormData();  
    var url = '/admin/getunverifiedaccount';
    $.ajax({
        url: url,
        headers:
        {
            'X-CSRF-Token': $('input[name="_token"]').val()
        },
        type: "GET",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $('#datatable-members').DataTable().destroy();
        },
        success: function (data) {
            var msg = JSON.parse(data);
            if (msg.result == 'success') {
                table = $('#datatable-members').DataTable({
                    searching: true,
                    processing: true,
                    data: msg.data,
                    pageLength: 50,
                    responsive: true,
                    columns: [
                        { data: 'prc_no' },
                        { data: 'usur' },
                        { data: 'ugiven' },                        
                        { data: 'msur' },
                        { data: 'mgiven' },
                        {
                         'render': function (data, type, full, meta) {
                           buttons = ''; 

                            deleteButton = '<button id="btn-delete" onclick="deleteMember(this)" type="button" class="btn btn-primary btn-sm"'
                                 + 'data-member-prc_no="' + full['prc_no'] + '" data-backdrop="static" data-keyboard="false">Delete</button> ';
                            buttons += deleteButton;

                           if (full['mem_count'] && full['mem_count'] > 1) {
                                dupButton = ' <a target="_blank" class="btn btn-primary btn-sm"'
                                    + ' href="membership?req_sur=' + full['msur'] + '&req_given=' + full['mgiven']
                                    + '" data-backdrop="static" data-keyboard="false">Duplicate Record Found!</a>';
                               rsyncButton = '<button id="btn-rsync" onclick="resyncAccount(this)" type="button" class="btn btn-primary btn-sm"'
                                     + 'data-member-prc_no="' + full['prc_no'] 
                                     + '"  data-toggle="tooltip" data-placement="top" title="Resync after Deleting Duplicate Record" data-keyboard="false">Resync</button>';
                                 buttons += rsyncButton;                                
                                 buttons += dupButton;
                           }

                             if (full['verify_token'] && full['verify_token'].length > 0) {
                                 label = '<label> Waiting for Member Confirmation </label>';
                                 buttons += label;
                           } else if (full['match_name'] && full['match_name'] > 0) {
                               possibleButton = ' <a target="_blank" class="btn btn-primary btn-sm"'
                                    + ' href="membership?req_sur=' + full['usur'] + '&req_given=' + full['ugiven'] 
                                    + '" data-backdrop="static" data-keyboard="false">Check Record Match without PRC #</a>';                    
                               buttons += possibleButton;
                           } else if ( (full['ugiven'].indexOf(full['mgiven']) > -1 || full['mgiven'].indexOf(full['ugiven'] ) > -1)
                                 && (full['usur'].indexOf(full['msur']) > -1 || full['msur'].indexOf(full['usur']) > -1) ) {
                                approveButton = '<button id="btn-approve" onclick="approveMember(this)" type="button" class="btn btn-primary btn-sm"' 
                                + 'data-member-prc_no="'+ full['prc_no'] + '" data-backdrop="static" data-keyboard="false">Approve</button>';
                                 buttons += approveButton; } 
                           else {
                                 mismatchButton = ' <a target="_blank" class="btn btn-primary btn-sm"'
                                     + ' href="membership?req_sur=' + full['msur'] +'&req_given=' + full['mgiven'] 
                                     + '" data-backdrop="static" data-keyboard="false">Fix Name Mismatch</a>';
                                 buttons += mismatchButton;
                           }                           
                             return buttons;
                           }
                        }
                    ],
                    "order": [[1, "asc"]],
                    "order": [[2, "asc"]],
                });
            }
        },
        error: function (xhr, ajaxOptions, thrownError) { // if error occured
            console.log("Error: " + thrownError);
        },
        complete: function () {
        },
    });
}