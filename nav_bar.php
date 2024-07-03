<?php
session_start();

$usernum = $_SESSION['staffid'];

if (!isset($_SESSION['staffid'])) {
    header("Location: login.php");
    exit();
}
?>

<style>
  p{font-size: 25px;}
  .nav a{font-size: 25px;
    margin-top: 5px;}
  h6{font-size: 1px; }
  /* Add custom CSS styles to increase the height of the navigation bar */
  .navbar {
    height: 60px; /* You can adjust the height according to your preference */
  }

  .navbar-brand img {
    margin-top: -10px; /* Adjust the margin to vertically center the logo */
  }
</style>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><img src="logofr.png" alt="Logo Multi-FR Lock" width="40px" height="40px"></a>
    </div>
 
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <?php
      $currentPage = basename($_SERVER['PHP_SELF']);
      if ($currentPage == 'staffs.php') {
        echo '<li><a href="index.php" class="active">Staff Details</a></li>';
      } elseif ($currentPage == 'log.php') {
        echo '<li><a href="index.php" class="active">Log Activities</a></li>';
      } elseif ($currentPage == 'staffstable.php') {
        echo '<li><a href="index.php" class="active">Staff List</a></li>';
      } else {
        echo '<li><a href="index.php" class="active">Home</a></li>';
    }
  ?>
</ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="staffs.php">Staff Details</a></li>
            <li><a href="staffstable.php">Staff List</a></li>
            <li><a href="log.php">Logs</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
      <?php
        if (isset($_SESSION['staffid'])) {
            echo '<p class="navbar-text">| &nbsp;&nbsp;&nbsp;                    Welcome, ' . $_SESSION['staffid'] . '.</p>';
          }
        
        ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>