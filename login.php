

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
    <style type="text/css">
        body {
            background: url(blue.gif);
        }

        img {
            animation: float 2s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: perspective(500px) rotatey(30deg);
            }

            50% {
                transform: perspective(500px) rotatey(-30deg);
            }

            100% {
                transform: perspective(500px) rotatey(30deg);
            }
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <div class="page-header">
                    <center>
                        <h2>Multi-FR Lock</h2>
                        <br><br>
                        <img src="logofr.png">
                        <br><br>
                        <center>
                </div>
                <form id="loginForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="staffu" class="col-sm-3 control-label">User Name</label>
                        <div class="col-sm-9">
                            <input name="uname" type="text" class="form-control" id="staffu" placeholder="Staff ID" required>
                        </div>
                        <br><br><br>
                    </div>
                    <div class="form-group">
                        <label for="staffpassword" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9">
                            <input name="password" type="password" class="form-control" id="staffpassword" placeholder="Password" required>
                        </div>
                        <br><br><br>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-11">
                            <button class="btn btn-primary btn-lg btn-block" id="btnlogin" type="submit">LOGIN</button>
                        </div>
                    </div>
                </form>
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

      import {getDatabase, ref, child, get} from "https://www.gstatic.com/firebasejs/10.11.1/firebase-database.js";

      const db = getDatabase();

      // Function to handle login form submission
        document.getElementById('loginForm').addEventListener('submit', async function (event) {
            event.preventDefault(); // Prevent form submission
            const staffu = document.getElementById('staffu').value.trim();
            const password = document.getElementById('staffpassword').value.trim();

            try {
                const snapshot = await get(child(ref(db), 'Registration'));
                if (snapshot.exists()) {
                    const registrations = snapshot.val();
                    let userExists = false;
                    let userData = null;
                    let userKey = null;

                    for (const key in registrations) {
                        if (registrations[key].username === staffu) {
                            userExists = true;
                            userData = registrations[key];
                            userKey = key;
                            break;
                        }
                    }

                    if (userExists) {
                        const hashedPassword = md5(password); // Assuming you have a function to hash passwords (e.g., md5)
                        if (hashedPassword === userData.password) {
                            // Send AJAX request to set session variable
                            $.ajax({
                                type: 'POST',
                                url: 'set_session.php', // PHP script to handle setting session
                                data: { staffid: userKey, staffname: userData.username },
                                success: function (response) {
                                    if (response === 'success') {
                                        window.location.href = 'index.php'; // Redirect to index.php on successful login
                                    } else {
                                        showError('Error setting session');
                                    }
                                },
                                error: function () {
                                    showError('Error setting session');
                                }
                            });
                        } else {
                            showError('Incorrect password');
                        }
                    } else {
                        showError('Username not exists');
                    }
                } else {
                    showError('No registrations found');
                }
            } catch (error) {
                console.error('Error logging in:', error);
                showError('Error logging in');
            }
        });

        // Function to display error message
        function showError(message) {
            const errorMessageElement = document.getElementById('errorMessage');
            errorMessageElement.textContent = message;
            errorMessageElement.style.display = 'block';
        }
    </script>
</body>
</html>
