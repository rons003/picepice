<!DOCTYPE html>
<html>
<head>
  <title>Email</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

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
      margin-right:10px;
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
      text-align:center;
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
    </div>
    <div class="body">
      <div>
      </div>
      <div>
        <br/>
        <p>Cheerfully yours,</p>
        <p>PICE Membership Team</p>
        <p>    
    PH: +63 2543 7543<br/>
    Email: <a href="mailto:administration@pice.org.ph">administration@pice.org.ph</a><br/>
    Website: <a href="{{ url('/') }}">{{ url('/') }}</a>
      </p>
      </div>
    </div>
  </div>
  <div class="footer" style="padding: 0 60px;"> 
    <ul style="float: left;">      
    </ul>
    <ul style="float: right;">
    </ul>
  </div>
</div>
</body>
</html>