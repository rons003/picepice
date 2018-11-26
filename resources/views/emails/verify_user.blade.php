<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>PICE Membership Confirmation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <style type="text/css" media="screen">
    body {
      margin:0;
      padding:0;
      background-color:#eee;
      font-weight:normal;
          font-family: 'Open Sans', sans-serif;
          font-size:14px;
          color:#444;
    }

    a {
      color:#ff5a5f;
    }

    label {
      margin-right:5px;
      font-weight:bold;
    }

    .wrapper {
      width:670px;
      height:auto;
      margin:auto;
      margin-top:30px;
      padding:0 30px;
      box-sizing:border-box;
      -moz-box-sizing:border-box;
      -webkit-box-sizing:border-box;
      -o-box-sizing:border-box;
    }

    .container {
      background-color:#fff;
      width:100%;
      min-height:200px;
      padding:10px 60px 60px 60px;
      box-sizing:border-box;
      -moz-box-sizing:border-box;
      -webkit-box-sizing:border-box;
      -o-box-sizing:border-box;
    }

    .header {
      margin:20px 0;
      text-align:left;
    }

    .header .logo {
      width:250px;
      display:inline-block;
    }

    .footer ul {list-style:none;padding:0;margin:15px 0;}
    .footer li {text-align:center;font-size:12px;}
    .footer li, .footer a {color:#888;}


    @media(max-width:768px){
      .wrapper {
        width:100%;
      }
    }

    @media(max-width:600px){
      .wrapper {
        padding:0 15px;
      }

      .container {
        padding:10px 15px 60px 15px;
      }
    }

  </style>

</head>
<body>
<div class="wrapper">
  <div class="container">
    <div class="header">
          <img height="60" width="200" class="logo" alt="pice logo" src="https://membership.pice.org.ph/images/pice_name.png">
    </div>
    <div class="body">
      <div class="header-info">
        <span>Dear Engineer {{ $user['given'].' '.$user['sur'] }} !</span>

        <p>Thank you for signing up with PICE Membership Portal.</p>

		<p>Please click the link below to activate your account:</p>
		<a href="{{ $user['url'].'/login?tokenid='.$user['verify_token'] }}" target="_blank" style="background-color: #ff5a5f;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none; display: inline-block;font-size: 16px;border-radius: 5px;">CONFIRM REGISTRATION</a>		
        <p>Need any help? Just send us an <a href="mailto:celalvizun.pice@gmail.com">email</a>. We are always glad to help!</p>
		<br>
        <p>Regards,</p>
        <p>PICE Membership Team</p>
		<p>
		GLOBE: <a href="tel:+639174029126">+639174029126</a><br>
		SMART: <a href="tel:+639196943711">+639196943711</a><br>
		Email: <a href="mailto:celalvizun.pice@gmail.com">celalvizun.pice@gmail.com</a><br>

  <div style="color:#888;font-size:12px;text-align:left">
    <p>
    Philippine Institute of Civil Engineers, Inc <br/>
    Unit 705, 7th Floor, Futurepoint Plaza 1 Condominium <br/>
    112 Panay Avenue, Quezon City <br/>     
    </p>
  </div>


      </div>
    </div>
  </div>

</div>

</body></html>