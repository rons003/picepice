@extends('layouts.members_page') 
@section('content')

<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a>Home</a></li>
      <li class="breadcrumb-item"><a>Membership Payment Due</a></li>
    </ul>
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
                <td id="par" colspan="3">
                  <div>
                    <p>NAME: <strong>Engr. {{$mem_info->sur}}, {{$mem_info->given}} {{$mem_info->middle}}.</strong></p>
                    <p>Chapter: <strong>{{$mem_info->chap_code}}</strong></p>
                    <p>Date Prepared: </p>
                  </div>
                </td>
                <td>
                  <div>
                    <p>Contact No.:</p>
                    <p>Tel/Fax:</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td id="par" colspan="3">
                  <div>
                    <p>Arrears: <strong>{{$mem_info->last_pay}} - 2018</strong></p>
                  </div>
                </td>
                <td>
                  <div>
                    <p>Membership Type:</p>
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
            @if ($member_payment)
            <tbody>
              @foreach ($member_payment->paymentLineItems as $o)
              <tr>
                <td>{{$o->lastpayyearrange}}</td>
                <td>P {{ number_format($o->sub_total_natl_dues,'2') }}</td>
                <td>P {{ number_format($o->sub_total_chap_dues,'2') }}</td>
                <td>P {{ number_format($o->sub_total_natl_dues+$o->sub_total_chap_dues,'2') }}</td>
              </tr>
              @endforeach
              <tr>
                <td></td>
                <td>REINSTATEMENT FEE P100</td>
                <td>REINSTATEMENT FEE P100</td>
                <td>P 200</td>
              </tr>
              <tr>
                <td></td>
                <td colspan="2" class="text-center">ID FEE P150</td>
                <td>P 150</td>
              </tr>
              <tr>
                <th colspan="4">
                  <div class="text-right" style="margin-right: 85px;">
                    <p>TOTAL P {{ number_format($member_payment->total_chap_dues+$member_payment->total_natl_dues+200+150,'2')
                      }}</p>
                  </div>
                  </td>
              </tr>
            </tbody>
            @endif
          </table>

        </div>
      </div>
    </div>
    <div class="row" style="margin-top: 1rem;">
        <div class="col-lg-12 text-center">
            @if ($member_payment)
            <div id="paypal-button-container"></div>
            @endif
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