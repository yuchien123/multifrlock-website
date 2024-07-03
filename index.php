  <?php include_once 'nav_bar.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Multi-FR Lock : Home</title>
  <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="guracss.css">
    <!--<link rel="stylesheet" href="gura1.css">-->
</head>
<body>
 


  <div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <br><br><br><br>
        <button class="btn btn-default" id="btnstaff"><h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Staff&nbsp; List&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2></button>
        <br><br><br><br><br>
      </div>
      <div class="page-header">
        <button class="btn btn-default" id="btnlogs"><h2>&nbsp;&nbsp;Logs Activities&nbsp;&nbsp;</h2></button>
      </div>
    </div>
  </div>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <script>
        document.getElementById('btnstaff').addEventListener('click', function() {
            // Redirect to staffstable.php
            window.location.href = 'staffstable.php';
        });

        document.getElementById('btnlogs').addEventListener('click', function() {
            // Redirect to log.php
            window.location.href = 'log.php';
        });
    </script>
</body>
</html>