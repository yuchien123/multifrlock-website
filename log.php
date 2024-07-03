<?php include_once 'nav_bar.php'; ?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Multi-FR Lock : Logs Activities</title>
  <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="guracss.css">
    <!-- Include DataTables CSS -->
    <style>
        .table tbody tr.selected {
            background-color: #00ffbf;
        }
        .form-group select {
            height: 30px;
        }
    </style>

</head>
<body>
   
 
<div class="container-fluid">
    <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
      <div class="page-header">
        <h2>Logs Activities</h2>
      </div>
      <!-- Filter Dropdown -->
      <div class="form-group pull-right col-xs-7 col-xs-offset-5 col-sm-5 col-sm-offset-7 col-md-3 col-md-offset-9">
          <label for="appnameFilter" class="col-sm-3 control-label"><img src="filter.png" width="30px"></label>
          <select class="col-sm-9" id="appnameFilter">
            <option value="">All App Names</option>
          </select>
      </div>
      <!-- Table -->
      <div>
      <table class="table table-striped table-bordered" id="logTable">
      <thead>
        <tr>
          <th>Log ID</th>
          <th>App Name</th>
          <th>Login Time</th>
          <th>Logout Time</th>
          <th>Staff ID</th>
          <th>Department</th>
          <th>Position</th>
        </tr>
      </thead>
      <tbody id="tbody1"></tbody>
      
    </table>
  </div>
    </div>
  </div>
</div>

<script src="jquery-3.7.1.min.js"></script>
<!-- Include DataTables JavaScript -->
<script src="js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script type="module">
      var tbody = document.getElementById('tbody1');

      function AddItemToTable(logid, appname, logintime, logouttime, staffid, staffdepart, staffposition){
        let trow = document.createElement('tr');
        let td1 = document.createElement('td');
        let td2 = document.createElement('td');
        let td3 = document.createElement('td');
        let td4 = document.createElement('td');
        let td5 = document.createElement('td');
        let td6 = document.createElement('td');
        let td7 = document.createElement('td');

        td1.innerHTML = logid;
        td2.innerHTML = appname;
        td3.innerHTML = logintime;
        td4.innerHTML = logouttime;
        td5.innerHTML = staffid;
        td6.innerHTML = staffdepart;
        td7.innerHTML = staffposition;

        trow.appendChild(td1);
        trow.appendChild(td2);
        trow.appendChild(td3);
        trow.appendChild(td4);
        trow.appendChild(td5);
        trow.appendChild(td6);
        trow.appendChild(td7);

        tbody.appendChild(trow);
      }

      function AddAllItemsToTable(TheUser){
        tbody.innerHTML = "";
        TheUser.forEach(element => {
          AddItemToTable(element.logid, element.appname, element.logintime, element.logouttime, element.staffid, element.staffdepart, element.staffposition);
        });
      }

      function PopulateAppNameFilter(appNames){
        var filter = document.getElementById('appnameFilter');
        appNames.forEach(appName => {
          let option = document.createElement('option');
          option.value = appName;
          option.innerHTML = appName;
          filter.appendChild(option);
        });
      }

      import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
   
      const firebaseConfig = {
        apiKey: "AIzaSyAZQrw-uTWyYFp7gRHFu1v0Zkhwb30y3CI",
        authDomain: "multifrlock.firebaseapp.com",
        databaseURL: "https://multifrlock-default-rtdb.firebaseio.com",
        projectId: "multifrlock",
        storageBucket: "multifrlock.appspot.com",
        messagingSenderId: "906988839816",
        appId: "1:906988839816:web:3a4eac807583408120903d",
        measurementId: "G-MXXWXRMK1J"
      };

      // Initialize Firebase
      const app = initializeApp(firebaseConfig);

      import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-database.js";

      const db = getDatabase();

      function GetAllDataRealtime(){
        const dbRef = ref(db, "LogActivity");
        onValue(dbRef, (snapshot) => {
          var users = [];
          var appNames = new Set();
          snapshot.forEach(childSnapshot => {
            var user = childSnapshot.val();
            users.push(user);
            appNames.add(user.appname);
          });
          AddAllItemsToTable(users);
          PopulateAppNameFilter(Array.from(appNames));
          // Initialize DataTable after loading data
          $('#logTable').DataTable();
        });
      }

      window.onload = GetAllDataRealtime;

      // Filter Functionality
      $('#appnameFilter').change(function(){
        var appName = $(this).val();
        $('#logTable').DataTable().column(1).search(appName).draw();
      });

</script>
 
</body>
</html>
