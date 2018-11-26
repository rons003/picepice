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
                  @if ($mem_info['is_new'])
                    <h2>New Membership Fee</strong></h2>
                  @else
                    <h2>Arrears Summary: <strong>{{$mem_info->last_pay}} - 2018</strong></h2>
                  @endif                    
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
              <tr class="text-right text-bold">
                <td>Sub-Total</td>
                <td>{{ number_format($member_payment->total_natl_dues,'2') }}</td>
                <td>{{ ($member_payment->total_natl_discount > 0)?'('.number_format($member_payment->total_natl_discount,'2').')':'' }}</td>
                <td>{{ number_format($member_payment->total_chap_dues,'2')  }}</td>
                <td>{{ ($member_payment->total_chap_discount > 0)?'('.number_format($member_payment->total_chap_discount,'2').')':'' }}</td>
                <td>{{ number_format($member_payment->net_chap_dues+$member_payment->net_natl_dues,'2') }}</td>
              </tr>
              @if ($member_payment->chap_reins_dues > 0)
              <tr class="text-right text-bold">
                <td>Reinstatement Fee</td>
                <td class="text-right">{{number_format($member_payment->nat_reins_dues,'2')}}</td>
                <td></td>
                <td class="text-right">{{number_format($member_payment->chap_reins_dues,'2')}}</td>
                <td></td>
                <td class="text-right">{{number_format($member_payment->nat_reins_dues+$member_payment->chap_reins_dues,'2')}}</td>
              </tr>
             @endif
             @if ($member_payment->chap_ent_dues > 0 )
              <tr class="text-right text-bold">
                <td>Entrance Fee</td>
                <td class="text-right">{{number_format($member_payment->chap_ent_dues,'2')}}</td>
                <td></td>
                <td class="text-right">{{number_format($member_payment->nat_ent_dues,'2')}}</td>
                <td></td>
                <td class="text-right">{{number_format($member_payment->chap_ent_dues+$member_payment->nat_ent_dues,'2')}}</td>
              </tr>
             @endif
             @if ($member_payment->id_fee > 0 )
              <tr class="text-right text-bold">
                <td>ID Fee</td>
                <td class="text-right"></td>
                <td></td>
                <td class="text-right">{{number_format($member_payment->id_fee,'2')}}</td>
                <td></td>
                <td class="text-right">{{number_format($member_payment->id_fee,'2')}}</td>
              </tr>
             @endif 


            </tbody>
          </table>        
      </div>
    </div>  
  <div class="row col-lg-12">
  <div class="col-lg-12">
    <div class="card-deck">
          <div class="card box-shadow">
            <div class="card-header">
                @if ($mem_info['is_new'])
                  <h2>Membership Fee Summary:</strong></h2>
                @else
                  <h2>Payment Summary: <strong>{{$mem_info->last_pay}} - 2018</strong></h2>
                @endif                  
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
            @if (($member_payment->total_chap_discount+$member_payment->total_natl_discount) > 0)
            <tr class="text-center">               
                <td>Total Amnesty Discount</td>
                <td>{{'('.number_format($member_payment->total_chap_discount+$member_payment->total_natl_discount,'2').')' }}</td>
            </tr>
            @endif
            @if ($member_payment->chap_reins_dues > 0)
            <tr class="text-center">               
                <td>Reinstatement Fee</td>
                <td>{{number_format($member_payment->nat_reins_dues+$member_payment->chap_reins_dues,'2')}}</td>
            </tr>
            @endif
            @if ($member_payment->chap_ent_dues > 0)
            <tr class="text-center">               
                <td>Entrance Fee</td>
                <td>{{number_format($member_payment->chap_ent_dues+$member_payment->nat_ent_dues,'2')}}</td>
            </tr>
            @endif
            @if ($member_payment->id_fee > 0)
            <tr class="text-center">               
                <td>ID Fee</td>
                <td>{{number_format($member_payment->id_fee,'2')}}</td>
            </tr>
            @endif            
            <tr class="text-center">               
                <td><h2>Total Dues</h2></td>
                <td><h2>{{ number_format($member_payment->getTotalDues(),'2') }}</h2></td>
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
<!--
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
-->
@stop
