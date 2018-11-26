@extends('layouts.members_page')
@section('page_heading','Membership Dues')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <input type="hidden" name="_token" id="csrftoken" value="{{ csrf_token() }}">
        <div class="table-responsive">
          <table id="datatable-statement" class="table table-bordered">
            <thead>
              <tr>
                <td id="par" colspan="6">
                  <div>
                    <h2>Arrears Summary: <strong>{{$mem_info->last_pay}} - 2018</strong></h2>
                  </div>
                </td>
              </tr>
              <tr class="text-center">
                <th>YEAR COVERED</th>
                <th>NATIONAL DUES</th>
                <th>NATIONAL DUES DISCOUNT</th>
                <th>CHAPTER DUES</th>
                <th>CHAPTER DUE DISCOUNTS</th>
                <th>COMPUTATION</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($paymentLineItems as $o)
              <tr class="text-right">
                <td>{{$o->year}}</td>
                <td>{{ number_format($o->sub_total_natl_dues,'2') }}</td>
                <td>{{  ($o->sub_total_natl_discount > 0)?'('.number_format($o->sub_total_natl_discount,'2').')':'' }}</td>
                <td>{{ number_format($o->sub_total_chap_dues,'2') }}</td>
                <td>{{ ($o->sub_total_chap_discount > 0)?'('.number_format($o->sub_total_chap_discount,'2').')':'' }}</td>
                <td>{{ number_format($o->net_total_chap_dues+$o->net_total_natl_dues,'2') }}</td>
              </tr>
              @endforeach
              <tr class="text-right">
                <td></td>
                <td>{{ number_format($member_payment->total_natl_dues,'2') }}</td>
                <td>{{'('.number_format($member_payment->total_natl_discount,'2').')' }}</td>
                <td>{{ number_format($member_payment->total_chap_dues,'2')  }}</td>
                <td>{{'('.number_format($member_payment->total_chap_discount,'2').')' }}</td>
                <td>{{ number_format($member_payment->net_chap_dues+$member_payment->net_natl_dues,'2') }}</td>
              </tr>
              <tr>
                <td>REINSTATEMENT FEE</td>
                <td class="text-right">100.00</td>
                <td></td>
                <td class="text-right">100.00</td>
                <td></td>
                <td class="text-right">200.00</td>
              </tr>
            </tbody>
          </table>        
      </div>
    </div>  
  <div class="row col-lg-12">
  <div class="col-lg-12">
    <div class="card-deck">
          <div class="card box-shadow">
            <div class="card-header">
              <h2>Payment Summary: <strong>{{$mem_info->last_pay}} - 2018</strong></h2>
            </div>
            <div class="card-body">              
            <table class="table">
            <thead>              
              <tr class="text-center">               
                <td><h5>Dues</h5></td>
                <td><h5>Amount</h5></td>
              </tr>
            </thead>
            <tbody>
            <tr class="text-center">               
                <td>Total National Dues</td>
                <td>{{ number_format($member_payment->total_natl_dues,'2') }}</td>
            </tr>
            <tr class="text-center">               
                <td>Total Chapter Dues</td>
                <td>{{number_format($member_payment->total_chap_dues,'2')}}</td>
            </tr>
            <tr class="text-center">               
                <td>Total Amnesty Discount</td>
                <td>{{'('.number_format($member_payment->total_chap_discount+$member_payment->total_natl_discount,'2').')' }}</td>
            </tr>
            <tr class="text-center">               
                <td>Reinstatement Fee</td>
                <td>200.00</td>
            </tr>
            <tr class="text-center">               
                <td><h2>Total Dues</h2></td>
                <td><h2>{{ number_format($member_payment->net_chap_dues+$member_payment->net_natl_dues+200,'2') }}</h2></td>
            </tr>
            </tbody>
            </table>              
            </div>
            <div class="card-footer"><div class="row" style="margin-top: 1rem;">
	<div class="col-lg-12 text-center">
		<div id="paypal-button-container"></div>
	</div>
</div>
</div>
            </div>
      </div>
      </div>   
    </div>        


</div>
<script>
  paypal.Button.render({

            env: 'sandbox', // sandbox | production

            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,

            style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size:  'large', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'blue'   // gold | blue | silver | black
            },

            // payment() is called when the button is clicked
            payment: function() {

                // Set up a url on your server to create the payment
                var CREATE_URL = '/member/payment/create';
                var token = $('#csrftoken').val();

                var data = {
                    paymentID: "1",
                    payerID: "2",
                    email:"xian.calabia-test@gmail.com",
                    _token: token
                };

                // Make a call to your server to set up the payment
                return paypal.request.post(CREATE_URL,data)
                    .then(function(res) {
                        return res.id;
                    });
            },

            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function(data, actions) {

                // Set up a url on your server to execute the payment
                var EXECUTE_URL = '/member/payment/update';
                var token = $('#csrftoken').val();

                // Set up the data you need to pass to your server
                var data = {
                    paymentID: data.paymentID,
                    payerID: data.payerID,
                    _token: token
                };

                 // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function() {
                    //window.alert('Payment Complete!');
                    $.ajax({
                      url: EXECUTE_URL,
                      headers:
                        {
                            'X-CSRF-Token': token
                        },
                      data: data,
                      type: 'POST',
                      beforeSend: function(){ },
                      success: function(data) {
                        $( "#paypal-button-container" ).hide();
                      }
                  });


                });                
            }

        }, '#paypal-button-container');

</script>
@stop
