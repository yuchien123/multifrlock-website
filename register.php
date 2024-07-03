

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multi-FR Lock : Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="guracss.css">
    <style>
     img {
    margin-top: -10px; 
  }
</style>

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <div class="page-header">
                    <center>
                        <br><br>
                        <h2><img src="logofr.png" height="70px"> Multi-FR Lock</h2>
                        <br><br>
                        <center>
                </div>
                <div id="formgroup" style="display: none;">
                <form id="loginForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="staffid" class="col-sm-3 control-label">Staff ID</label>
                        <div class="col-sm-9">
                            <input name="uname" type="text" class="form-control" id="staffid" placeholder="Staff ID" readonly>
                        </div>
                        <br><br><br>
                    </div>
                    <div class="form-group">
                        <label for="staffun" class="col-sm-3 control-label">User Name</label>
                        <div class="col-sm-9">
                            <input name="uname" type="text" class="form-control" id="staffun" placeholder="User Name" required>
                        </div>
                        <br><br><br>
                    </div>
                    <div class="form-group">
                        <label for="staffpassword" class="col-sm-3 control-label">New Password</label>
                        <div class="col-sm-9">
                            <input name="password" type="password" class="form-control" id="staffpassword" placeholder="Password" required>
                        </div>
                        <br><br><br>
                    </div>
                    <div class="form-group">
                        <label for="cstaffpassword" class="col-sm-3 control-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input name="password" type="password" class="form-control" id="cstaffpassword" placeholder="Password" required>
                        </div>
                        <br><br><br>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-11">
                            <button class="btn btn-primary btn-lg btn-block" id="btnregis" type="button">REGISTER</button>
                        </div>
                    </div>
                </form>
                </div>
                <div id="errorMessage" class="alert alert-danger col-sm-offset-1 col-sm-11" style="display: none;" role="alert"></div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.18.0/js/md5.min.js"></script>
 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

   <script type="module">

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

      import {getDatabase, ref, child, get, set} from "https://www.gstatic.com/firebasejs/10.11.1/firebase-database.js";

      const db = getDatabase();

      const formgroup = document.getElementById('formgroup');

      function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
       }

       const staffId = getQueryParameter('staffid');

        if (staffId) {
            const dbRef = ref(db);
            get(child(dbRef, `UsersData/${staffId}`)).then((snapshot) => {
                if (snapshot.exists()) {
                    if(snapshot.val().staffposition === "Admin"){
                        get(child(dbRef, `Registration/${staffId}`)).then((snapshot) => {
                            if (!snapshot.exists()) {
                                document.getElementById('staffid').value = staffId;
                                formgroup.style.display = 'block';
                            } else {
                                errorMessage.textContent = 'Staff ID already registered.';
                                errorMessage.style.display = 'block';
                            }
                        }).catch((error) => {
                            console.error(error);
                            errorMessage.textContent = 'Error accessing the database.';
                            errorMessage.style.display = 'block';
                        });
                    }else{
                        errorMessage.textContent = 'You are not Admin.';
                        errorMessage.style.display = 'block';
                    }
    
                } else {
                    errorMessage.textContent = 'Staff ID not found.';
                    errorMessage.style.display = 'block';
                }
            }).catch((error) => {
                console.error(error);
                errorMessage.textContent = 'Error accessing the database.';
                errorMessage.style.display = 'block';
            });
        }else{
            errorMessage.textContent = 'Please use the correct link.';
            errorMessage.style.display = 'block';
        }

        const staffid = document.getElementById('staffid');
        const staffun = document.getElementById('staffun');
        const staffpassword = document.getElementById('staffpassword');
        const cstaffpassword = document.getElementById('cstaffpassword');
        const Regbtn = document.getElementById('btnregis');

    function AddData() {
      const hashedPassword = md5(staffpassword.value);  
      const data = {
        username: staffun.value,
        password: hashedPassword
      };

      const staffRef = ref(db, 'Registration/' + staffid.value);

      const dbRef = ref(db);
      get(child(dbRef, `Registration`)).then((snapshot) => {
        if (snapshot.exists()) {
          let usernameExists = false;
          snapshot.forEach((childSnapshot) => {
            if (childSnapshot.val().username === staffun.value) {
              usernameExists = true;
            }
          });
          if (usernameExists) {
            alert("The username already exists.");
          } else {
            set(staffRef, data)
              .then(() => {
                alert("Registration successful");
                window.location.href = 'login.php';
              })
              .catch((error) => {
                alert("Unsuccessful, error: " + error);
              });
          }
        } else {
          set(staffRef, data)
            .then(() => {
              alert("Registration successful");
              window.location.href = 'login.php';
            })
            .catch((error) => {
              alert("Unsuccessful, error: " + error);
            });
        }
      }).catch((error) => {
        alert("Error checking username: " + error);
      });
    }

    function checkpass(){
        if(staffpassword.value===cstaffpassword.value){
            AddData();
        }else{
            errorMessage.textContent = 'Passwords do not match';
            errorMessage.style.display = 'block';
        }
    }

    Regbtn.addEventListener('click', checkpass);
    </script>
</body>
</html>