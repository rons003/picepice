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
    <div id="paypal-button-container"></div>
    <input type="hidden" name="_token" id="csrftoken" value="{{ csrf_token() }}">
      <div class="table-responsive">
        <table id="datatable-statement" class="table table-bordered">
        <thead>
          <tr>
            <td id="par" colspan="3">
              <div>
                <p>NAME: <strong>Engr. {{$sur}}, {{$given}} {{$middle}}.</strong></p>
                <p>Chapter: <strong>{{$chapter}}</strong></p>
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
                <p>Arrears: <strong>{{$statement_data['lastpay']+ 1}} - 2018</strong></p>
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
        <tbody>
          @if ($statement_data['lastpay'] != null)
          @if ($statement_data['lastpay'] <= 2001)
            <tr>
              <td>{{$statement_data['lastpay'] + 1}}-2001</td>
              <td>P {{ number_format($statement_data['data1']['total_natl_dues'],'2') }}</td>
              <td>P {{ $statement_data['data1']['total_chap_dues'] }}</td>
              <td>P {{ $statement_data['data1']['amount'] }}</td>
            </tr>
            <tr>
              <td>2002</td>
              <td>P {{$statement_data['data2']['total_natl_dues']}}</td>
              <td>P {{$statement_data['data2']['total_chap_dues']}}</td>
              <td>P {{$statement_data['data2']['amount']}}</td>
            </tr>
            <tr>
              <td>2003-2010</td>
              <td>P {{$statement_data['data3']['total_natl_dues']}}</td>
              <td>P {{$statement_data['data3']['total_chap_dues']}}</td>
              <td>P {{$statement_data['data3']['amount']}}</td>
            </tr>
            <tr>
              <td>2011-2018</td>
              <td>P {{$statement_data['data4']['total_natl_dues']}}</td>
              <td>P {{$statement_data['data4']['total_chap_dues']}}</td>
              <td>P {{$statement_data['data4']['amount']}}</td>
            </tr>
          @elseif ($statement_data['lastpay'] <= 2002)
            <tr>
              <td>2002</td>
              <td>P {{$statement_data['data2']['total_natl_dues']}}</td>
              <td>P {{$statement_data['data2']['total_chap_dues']}}</td>
              <td>P {{$statement_data['data2']['amount']}}</td>
            </tr>
            <tr>
              <td>2003-2010</td>
              <td>P {{$statement_data['data3']['total_natl_dues']}}</td>
              <td>P {{$statement_data['data3']['total_chap_dues']}}</td>
              <td>P {{$statement_data['data3']['amount']}}</td>
            </tr>
            <tr>
              <td>2011-2018</td>
              <td>P {{$statement_data['data4']['total_natl_dues']}}</td>
              <td>P {{$statement_data['data4']['total_chap_dues']}}</td>
              <td>P {{$statement_data['data4']['amount']}}</td>
            </tr>
          @elseif ($statement_data['lastpay'] <= 2003 || 2010 >= $statement_data['lastpay'])
            <tr>
              <td>{{$statement_data['lastpay'] + 1}}-2010</td>
              <td>P {{$statement_data['data3']['total_natl_dues']}}</td>
              <td>P {{$statement_data['data3']['total_chap_dues']}}</td>
              <td>P {{$statement_data['data3']['amount']}}</td>
            </tr>
            <tr>
              <td>2011-2018</td>
              <td>P {{$statement_data['data4']['total_natl_dues']}}</td>
              <td>P {{$statement_data['data4']['total_chap_dues']}}</td>
              <td>P {{$statement_data['data4']['amount']}}</td>
            </tr>
          @elseif ($statement_data['lastpay'] <= 2011 || 2018 >= $statement_data['lastpay'])
            <tr>
              <td>{{$statement_data['lastpay'] + 1}}-2018</td>
              <td>P {{$statement_data['data4']['total_natl_dues']}}</td>
              <td>P {{$statement_data['data4']['total_chap_dues']}}</td>
              <td>P {{$statement_data['data4']['amount']}}</td>
            </tr>
          @endif
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
                <p>TOTAL P {{ number_format($compute_total + 200 + 150,'2') }}</p>
              </div>
            </td>
          </tr>
          @endif
          
          
        </tbody>
      </table>
      
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
                var EXECUTE_URL = '/member/paypal/payment/execute/';

                // Set up the data you need to pass to your server
                var data = {
                    paymentID: data.paymentID,
                    payerID: data.payerID
                };

                // Make a call to your server to execute the payment
                return paypal.request.post(EXECUTE_URL, data)
                    .then(function (res) {
                        window.alert('Payment Complete!');
                    });
            }

        }, '#paypal-button-container');
  </script>

@stop