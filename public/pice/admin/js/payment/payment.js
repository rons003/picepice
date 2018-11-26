//Global Variables
var snum;
var chap_code;
var given;
var sur;
var middle;
var total;
var r_state;
var id_fee = 0;
var life;

//
$('#frm-search-statement').submit(function (e) {
	var search_val = $('#search_statement').val();
	getSearch(search_val);
	e.preventDefault();
});

function getSearch(value) {
	var url = '/admin/payments/getmembersearch/' + value;
	$.ajax({
		url: url,
		type: "GET",
		beforeSend: function () {
			$('#datatable-member').DataTable().destroy();
		},
		success: function (data) {
			var msg = JSON.parse(data);
			if (msg.result == 'success') {
				var table = $('#datatable-member').DataTable({
					searching: false,
					processing: true,
					data: msg.data.data,
					responsive: true,
					columns: [{
							data: 'prc_no'
						},
						{
							data: 'sur'
						},
						{
							data: 'given'
						},
						{
							data: 'middlename'
						},
						{
							'render': function (data, type, full, meta) {
								if (full['life_no'] == 0 || full['life_no'] == null) {
									data = '<button id="btn-view-statement" type="button" onclick="viewStatement(this)" class="btn btn-primary btn-sm" data-snum="' + full['snum'] + '" style="margin: .1rem;">View Statement</button><button id="btn-view-history" type="button" onclick="viewHistory(this)" class="btn btn-primary btn-sm" data-history-snum="' + full['snum'] + '">View Payment History</button>';
								} else {
									data = '<button id="btn-view-history" type="button" onclick="viewHistory(this)" class="btn btn-primary btn-sm" data-history-snum="' + full['snum'] + '">View Payment History</button>';
								}
								return data;
							}
						}
					],
					"order": [
						[1, "asc"]
					],
					"order": [
						[2, "asc"]
					]
				});
			} else {
				swal({
					title: 'Ooops!',
					text: msg.message,
					icon: 'error'
				})

			}
		},
		error: function (xhr, ajaxOptions, thrownError) { // if error occured
			console.log("Error: " + thrownError);
		},
		complete: function () {},
	});
}

function viewStatement(data) {
	snum = $(data).attr('data-snum');
	var url = '/admin/payments/statement/' + (new Date()).getFullYear() + '/' + snum + '/';
	if (snum != '') {
		$.ajax({
			url: url,
			type: "GET",
			beforeSend: function () {
				$('#datatable-statement > tbody').empty();
				$('#amount').val("");
				$('#or_number').val("");
				$('#idrenewal-cb').prop('checked', false);
				$('.print-error-msg').hide();
			},
			success: function (data) {
				var msg = JSON.parse(data);
				if (msg.result == 'success') {
					var curYear = (new Date()).getFullYear();
					if (msg.yearpayables <= curYear) {
						$('#statement-modal').modal({
							toggle: true,
							backdrop: 'static',
							keyboard: false
						});
						$.each(msg.statement, function (i, value) {
							chap_code = value['chap_code'];
							given = value['given'];
							middle = value['middle'];
							sur = value['sur'];
							var diffDatemem = curYear + 1 - value['year'];
							if (diffDatemem >= 10) {
								$('#life-cb').prop('disabled', false);
							} else {
								$('#life-cb').prop('disabled', true);
							}
							$('#fn').html('Engr. ' + value['sur'] + ', ' + value['given'] + ' ' + value['middle']);
							$('#cell_no').html(value['cell_no']);
							$('#tel_fax').html(value['tel_fax']);
							$('#chapter').html(value['chapter']);
							$('#select-year-cb').empty();
							var arrears = msg.yearpayables;
							$('#arrears-year').html(arrears + ' to');
							$('#arrears').html(arrears);
							$('#arrears-to').html(curYear);
							var dif_year = curYear - arrears;
							for (i = 0; i < dif_year + 1; i++) {
								$('#select-year-cb').append('<option value="' + curYear + '">' + curYear + '</option>');
								curYear -= 1;
							}
						});
						var statement = msg.statement_data;
						total = msg.total;
						for (i = 0; i < statement.length; i++) {
							var yrcover = Object.keys(statement)[i];
							var year;
							var natl_dues = statement[yrcover].total_natl_dues;
							var chap_dues = statement[yrcover].total_chap_dues;
							var amount = statement[yrcover].total_amount;
							var yearcovered = statement[yrcover].yearcovered;
							$('#datatable-statement > tbody').append(
								'<tr class="text-right">' +
								'<td id="yearcov">' + yearcovered + '</td>' +
								'<td id="natl_dues">' + natl_dues + '</td>' +
								'<td id="chap_dues">' + chap_dues + '</td>' +
								'<td id="computation">' + amount + '</td>' +
								'</tr>'
							);
						}
						if (msg.rstate != 0) {
							var total_r = parseInt(msg.rstate) * 2;
							r_state = total_r;
							$('#datatable-statement > tbody').append(
								'<tr class="text-right">' +
								'<td></td>' +
								'<td>REINSTATEMENT FEE: ' + msg.rstate + '</td>' +
								'<td>REINSTATEMENT FEE: ' + msg.rstate + '</td>' +
								'<td>' + total_r + '</td>' +
								'</tr>'
							);
						}
						$('#datatable-statement > tbody').append(
							'<tr id="lifemember"></tr>' +
							'<tr id="idfee"></tr>' +
							'<tr class="text-right">' +
							'<th colspan="4">' +
							'<div class="text-right" style="margin-right: 85px;">' +
							'<p id="total-pay">TOTAL P ' + total + '</p>' +
							'</div>' +
							'</td>' +
							'</tr>'
						);
					} else {
						swal({
							title: 'Hello!',
							text: 'The payment is up to date'
						})
					}

				} else {
					swal({
						title: "Notice!",
						text: msg.message,
						icon: "warning",
					})
				}
			},
			error: function (xhr, ajaxOptions, thrownError) { // if error occured
				console.log("Error: " + thrownError);
			},
			complete: function () {},
		});
	} else {
		swal({
			title: 'Ooops!',
			text: 'No Snum',
			icon: 'error'
		})
	}



}
$(document).ready(function () {
	$('#datatable-member').DataTable({
		bLengthChange: false,
		searching: false,
		"language": {
			"paginate": {
				"previous": "<",
				"next": ">"
			}
		},

	});
});

function viewHistory(snum) {
	var snum = $(snum).attr('data-history-snum');
	if (snum != '') {
		var url = '/admin/payments/getpaymenthistory/' + snum;
		$.ajax({
			url: url,
			type: "GET",
			beforeSend: function () {
				$('#datatable-payment-history').DataTable().destroy();
			},
			success: function (data) {
				var msg = JSON.parse(data);
				if (msg.result == 'success') {
					$('#payment-history-modal').modal({
						toggle: true,
						backdrop: 'static',
						keyboard: false
					});
					var table = $('#datatable-payment-history').DataTable({
						searching: false,
						responsive: {
							details: {
								display: $.fn.dataTable.Responsive.display.childRowImmediate,
								type: ''
							}
						},
						data: msg.payments,
						columns: [{
								data: 'or_number'
							},
							{
								data: 'last_pay'
							},
							{
								data: 'remarks'
							},
							{
								data: 'r_statemnt'
							},
							{
								data: 'totalpay'
							},
							{
								data: 'date_paid'
							}
						],
						"order": [
							[1, "desc"]
						]
					});
				}
			},
			error: function (xhr, ajaxOptions, thrownError) { // if error occured
				console.log("Error: " + thrownError);
			},
			complete: function () {},
		});
	}
}

$('#select-year-cb').on('change', function () {
	$('#arrears-to').html(this.value);
	var url = '/admin/payments/statement/' + this.value + '/' + snum + '/';
	$.ajax({
		url: url,
		type: "GET",
		beforeSend: function () {
			$('#datatable-statement > tbody').empty();
		},
		success: function (data) {
			var msg = JSON.parse(data);
			if (msg.result == 'success') {
				$('#life-cb').prop('checked', false);
				var curyear = (new Date()).getFullYear();
				var diffDatemem = curyear + 1 - msg.statement[0].year;
				if (diffDatemem >= 10) {
					if ($('#select-year-cb').prop('selectedIndex') == 0) {
						$('#life-cb').prop('disabled', false);
					} else {
						$('#life-cb').prop('disabled', true);
					}
				} else {
					$('#life-cb').prop('disabled', true);
				}
				var statement = msg.statement_data;
				total = msg.total;
				for (i = 0; i < statement.length; i++) {
					var yrcover = Object.keys(statement)[i];
					var year;
					var natl_dues = statement[yrcover].total_natl_dues;
					var chap_dues = statement[yrcover].total_chap_dues;
					var amount = statement[yrcover].total_amount;
					var yearcovered = statement[yrcover].yearcovered;
					$('#datatable-statement > tbody').append(
						'<tr class="text-right">' +
						'<td id="yearcov">' + yearcovered + '</td>' +
						'<td id="natl_dues">' + natl_dues + '</td>' +
						'<td id="chap_dues">' + chap_dues + '</td>' +
						'<td id="computation">' + amount + '</td>' +
						'</tr>'
					);
				}
				if (msg.rstate != 0) {
					var total_r = parseInt(msg.rstate) * 2;
					r_state = total_r;
					$('#datatable-statement > tbody').append(
						'<tr class="text-right">' +
						'<td></td>' +
						'<td id="rfnatl">REINSTATEMENT FEE: ' + msg.rstate + '</td>' +
						'<td id="rfchap">REINSTATEMENT FEE: ' + msg.rstate + '</td>' +
						'<td id="rftotal">' + total_r + '</td>' +
						'</tr>'
					);
				}
				$('#datatable-statement > tbody').append(
					'<tr id="lifemember"></tr>' +
					'<tr id="idfee"><tr>' +
					'<tr class="text-right">' +
					'<th colspan="4">' +
					'<div class="text-right" style="margin-right: 85px;">' +
					'<p id="total-pay">TOTAL P ' + total + '</p>' +
					'</div>' +
					'</td>' +
					'</tr>'
				);
			} else {

			}
		},
		error: function (xhr, ajaxOptions, thrownError) { // if error occured
			console.log("Error: " + thrownError);
		},
		complete: function () {},
	});
});

function createPayment() {
	var payables = parseInt($('#select-year-cb').val()) + 1;
	var remarks = total - $('#amount').val();
	var rfnatl;
	var paymentDetailsData = [];
	$('#datatable-statement > tbody  > tr').each(function () {
		var yearcov = $(this).find("#yearcov").html();
		var natl_dues = $(this).find("#natl_dues").html();
		var chap_dues = $(this).find("#chap_dues").html();
		var amount = $(this).find("#computation").html();
		rfnatl = $(this).find("#rfnatl").html();
		if (yearcov != null) {
			var paymentLine = {
				rfnatl: 0,
				rfchap: 0,
				yearcov: yearcov,
				natl_dues: natl_dues,
				chap_dues: chap_dues,
				id_fee: 0
			};
			paymentDetailsData.push(paymentLine);
		}
	});
	if (rfnatl != null) {
		var paymentLine = {
			rfnatl: 100,
			rfchap: 100,
			yearcov: null,
			natl_dues: 0,
			chap_dues: 0,
			id_fee: 0
		};
		paymentDetailsData.push(paymentLine);
	}
	if (id_fee != 0) {
		var paymentLine = {
			rfnatl: 0,
			rfchap: 0,
			yearcov: null,
			natl_dues: 0,
			chap_dues: 0,
			id_fee: 150
		};
		paymentDetailsData.push(paymentLine);
	}
	var formData = {
		chap_code: chap_code,
		given: given,
		date_paid: $('#date-paid').val(),
		last_pay: '01/01/' + $('#select-year-cb').val(),
		middle: middle,
		or_number: $('#or_number').val(),
		payables: payables,
		r_statemnt: r_state,
		remarks: remarks,
		snum: snum,
		sur: sur,
		id_fee: id_fee,
		totalpay: $('#amount').val(),
		life: life,
		payment_details: paymentDetailsData
	};
	$.ajax({
		url: "/admin/payments/add",
		cache: false,
		type: "POST",
		headers: {
			'X-CSRF-Token': $('input[name="_token"]').val()
		},
		data: formData,
		beforeSend: function () {

		},
		error: function (data) {
			if (data.readyState == 4) {
				errors = JSON.parse(data.responseText);

				$.each(errors, function (key, value) {
					console.log({
						type: 2,
						text: value,
						time: 2
					});
				});
			}
		},
		success: function (data) {
			var msg = JSON.parse(data);
			if (msg.result == 'success') {
				swal({
					title: 'Great!',
					text: msg.message,
					icon: 'success'
				})
				$('#statement-modal').modal('toggle');

			} else {
				printErrorMsg(msg.error);
			}
		}
	});
}

$('#frm-create-payment').submit(function (e) {
	createPayment();
	e.preventDefault();
});


$(document).ready(function () {
	$('input[type=text]').keyup(function () {
		$(this).val($(this).val().toUpperCase());
	});
});

$(document).ready(function () {
	$('textarea[type=text]').keyup(function () {
		$(this).val($(this).val().toUpperCase());
	});
});

$('#idrenewal-cb').change(function () {
	if (this.checked) {
		id_fee = 150;
		total += 150;
		$('#idfee').append(
			'<td></td>' +
			'<td colspan="2">ID FEE P150</td>' +
			'<td>150.00</td>'
		);
		$('#total-pay').html('TOTAL P ' + total)
	} else {
		id_fee = 0;
		$('#idfee').empty();
		total -= 150;
		$('#total-pay').html('TOTAL P ' + total)
	}
});

$('#life-cb').change(function () {
	if (this.checked) {
		life = 1;
		total += 10000;
		$('#lifemember').append(
			'<td></td>' +
			'<td>5,000.00</td>' +
			'<td>5,000.00</td>' +
			'<td>10,000.00</td>'
		);
		$('#total-pay').html('TOTAL P ' + total)
	} else {
		life = 0;
		$('#lifemember').empty();
		total -= 10000;
		$('#total-pay').html('TOTAL P ' + total)
	}
});

$(document).ready(function () {
	$('input[type="number"]').keydown(function (e) {
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			// Allow: Ctrl/cmd+A
			(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
			// Allow: Ctrl/cmd+C
			(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
			// Allow: Ctrl/cmd+X
			(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
			// Allow: home, end, left, right
			(e.keyCode >= 35 && e.keyCode <= 39)) {
			// let it happen, don't do anything
			return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	});
});

function printErrorMsg(msg) {
	$(".print-error-msg").find("ul").html('');
	$(".print-error-msg").css('display', 'block');
	$.each(msg, function (key, value) {
		$(".print-error-msg").find("ul").append('<li>' + value + '</li>');
	});
}

$(function () {
	$('#datetimepicker-date-paid').datetimepicker({
		format: 'YYYY-MM-DD',
		viewMode: 'years'
	});
});