<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="{{ asset("images/piceicon.png") }}" type="image/x-icon">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <title>Statement of account</title>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col">
          <img src="http://pice.org.ph/wp-content/themes/picebaguio/img/logo-icon.png" width="90" height="85" />
      </div>
      <div class="col text-center">
        <span><h5 class="font-weight-bold">PHILIPPINE INSTITUTE OF CIVIL ENGINEERS, INC.</h5></span>
        <p>PICE Building, Unit 705, 7th Floor, Futurepoint Plaza 1 Condominium<br>
          112 Panay Avenue, Quezon City<br>
        Tel No. (632) 232-9034 / Telfax Nos: (632)709-2933, (632)709-3415</p>
        <span><h6 class="font-weight-bold">STATEMENT OF ACCOUNT</h6></span>
        <h6>ASSESSMENT FORM (Availing the AMNESTY on Membership Dues)</h6>
      </div>

    </div>
    <div style="margin-top: -70px; margin-left: -30px;margin-right: -30px;">
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
</body>
</html>
