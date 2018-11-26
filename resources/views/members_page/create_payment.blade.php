@extends('layouts.members_page')
@section('page_heading','Membership Dues')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Membership Dues</h5>
        <div class="card-body">
          <table id="paymentsdb" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
            <thead class="thead-dark">
              <tr class="text-center">             
                <th>National Dues</th>
                <th>Chapter Dues</th>                
                <th>Reinstatement National Dues</th>
                <th>Reinstatement Chapter Dues</th>                
                <th>Total Amount Dues</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-right">{{number_format($payment['natl_dues'],'2')}}</td>
                <td class="text-right">{{number_format($payment['chap_dues'],'2')}}</td>
                <td class="text-right">{{number_format($payment['ent_natl'],'2')}}</td>
                <td class="text-right">{{number_format($payment['ent_chap'],'2')}}</td>
                <td class="text-right">{{number_format($payment['totalpay'],'2')}}</td>                
              </tr>             
            </tbody>
          </table>       
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="col-lg-12">
    <div class="row">
      <div class="col-lg-12">
        <input type="hidden" name="_token" id="csrftoken" value="{{ csrf_token() }}">
        <div class="table-responsive">
          <table id="datatable-statement" class="table table-bordered">
            <thead>
              <tr>
                <td id="par" colspan="4">
                  <div>
                    <p>Arrears Summary: <strong>{{$mem_info->last_pay}} - 2018</strong></p>
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
              @foreach ($paymentLineItems as $o)
              <tr class="text-right">
                <td>{{$o->year}}</td>
                <td>P {{ number_format($o->natl_dues,'2') }}</td>
                <td>P {{ number_format($o->chap_dues,'2') }}</td>
                <td>P {{ number_format($o->natl_dues+$o->chap_dues,'2') }}</td>
              </tr>
              @endforeach
              <tr>
                <td></td>
                <td>REINSTATEMENT FEE P100.00</td>
                <td>REINSTATEMENT FEE P100.00</td>
                <td class="text-right">P 200.00</td>
              </tr>
              <tr>               
              </tr>
              <tr>
                <th colspan="4">
                  <div class="text-right">
                    <p>TOTAL P {{ number_format($payment['totalpay'],'2')}}</p>
                  </div>
                  </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
    <div class="row" style="margin-top: 1rem;">
        <div class="col-lg-12 text-center">
            <div id="paypal-button-container"></div>
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
