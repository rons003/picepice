<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="viewport"/>
  <style>
    *{ 
      font-family: sans-serif !important;       
     }   

    th { 
    text-align: center; 
    vertical-align: center; 
    }

    td {     
    text-align: right; 
    vertical-align: center; 
    }

    thead { display: table-header-group }
    tfoot { display: table-row-group }
    tr { page-break-inside: avoid }


   </style>
  <title>Statement of account</title>
</head>
<body>
  <div>    
      <div style="text-align: center;">
        <span >PHILIPPINE INSTITUTE OF CIVIL ENGINEERS, INC.</span>
        <br/>
         <span>MEMBERSHIP DUES (AMNESTY PROGRAM)</span>
         <br/>
         <span>{{$chapter->chapter}}</span>
      </div>    
    <div>
      <table>
        <thead>
          <tr>
            <th>NAME</th>
            <th>YR</th>
            <th>CHAP <br/>
            CODE</th>
            <th>CHAP <br/>
            NO</th>
            <th>MEM<br/>
            CODE</th>
            <th>LAST<br/>
            PAY</th>
            <th>PAYBL</th>
            <th>APPLIC<br/>
            OF PMNT.</th>
            <th>NTL<br/>
            DUES</th>
            <th>CHAP<br/>
            DUES</th>            
            <th>RF</th>
            <th>ID<br/>
            FEE</th>
            <th>TOTAL</th>
          </tr>         
        </thead>   
        <tbody>
          <?php

            $total_natl_dues = 0;;
            $total_chap_dues = 0;
            $total_rf = 0;
            $total_id = 0; 
            $activeMembers = 0;           
            $inactiveMembers = 0;
            $lifeMembers = 0;
           ?>

           @foreach ($chapterMembers as $o)
           <?php 

            $lastPaymentYear=2000;

            if (empty($o->last_pay) || strpos($o->last_pay, '0000') > -1)
            {
              $lastPaymentYear = $o->year;
              if ($lastPaymentYear < 1986)
              {
                $lastPaymentYear = 1986;
              }
            } else
            {
              $lastPaymentYear = (1 * substr($o->last_pay,21,4)) + 1;
            }

            $mp = App\Http\Util\PaymentUtil::generateMemberPayables(2018,$lastPaymentYear,$chapter->chap_dues,250,150); 

            $total_natl_dues += $mp->net_natl_dues;
            $total_chap_dues += $mp->net_chap_dues;
            $total_rf += 200;
            $total_id += 150;

            if ((2018 - $lastPaymentYear) <= 3)
            {
             $activeMembers++;
            } else
            {
             $inactiveMembers++;
            }

            if (strpos($o->remarks, 'LIFE') > -1)
            {

              $lifeMembers++;
            }

           ?>
            <tr>
              <td style="text-align: left;" nowrap>{{substr(($o->sur.', '.$o->given.' '.$o->middle),0,25)}}</td>
              <td>{{substr($o->last_pay,21,4)}}</td>
              <td>{{$o->chap_code}}</td>
              <td>{{$o->chap_no}}</td>
              <td>{{$o->mem_code}}</td>
              <td nowrap>{{$o->last_pay_date}}</td>
              <td>{{substr($o->last_pay_date,0,4)}}</td>
              <td>{{$o->remarks}}</td>
              <td>{{number_format($mp->net_natl_dues,2)}}</td>
              <td>{{number_format($mp->net_chap_dues,2)}}</td>              
              <td>200.00</td>
              <td>150.00</td>
              <td>{{number_format($mp->net_natl_dues + $mp->net_chap_dues + 200 + 150,2) }}</td>
            </tr>
            <?php 
              unset($mp);
            ?>
             @endforeach
        </tbody>
      </table>
      <table>
        <thead>
          <tr>
            <th>LIFE MEMBERS</th>
            <th>ACTIVE MEMBERS</th>
            <th>INACTIVE MEMBERS</th>
            <th>TOTAL NAT'L DUES</th>
            <th>TOTAL CHAP DUES</th>
            <th>TOTAL RF DUES</th>
            <th>TOTAL ID DUES</th>
            <th>TOTAL DUES</th>
          </tr>
          <tr>
            <td style="text-align: center;">{{$lifeMembers}}</td>
            <td style="text-align: center;">{{$activeMembers}}</td>              
            <td style="text-align: center;">{{$inactiveMembers}}</td>            
            <td style="text-align: center;">{{number_format($total_natl_dues,2)}}</td>
            <td style="text-align: center;">{{number_format($total_chap_dues,2)}}</td>
            <td style="text-align: center;">{{number_format($total_rf,2)}}</td>
            <td style="text-align: center;">{{number_format($total_id,2)}}</td>
            <td style="text-align: center;">{{number_format($total_natl_dues + $total_chap_dues + $total_rf + $total_id,2) }}</td>
          </tr>
      </table>
    </div>
  </div>
</body>
</html>
