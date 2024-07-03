<?php include_once 'nav_bar.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multi-FR Lock : Staffs List</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="guracss.css">
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
                    <h2>Staff List</h2>
                </div>
                      <div class="form-group pull-right col-xs-7 col-xs-offset-5 col-sm-5 col-sm-offset-7 col-md-3 col-md-offset-9">
          <label for="departmentFilter" class="col-sm-3 control-label"><img src="filter.png" width="30px"></label>
          <select class="col-sm-9" id="departmentFilter">
            <option value="">All Departments</option>
            <option value="Marketing">Marketing</option>
            <option value="Sales">Sales</option>
            <option value="Financial">Financial</option>
            <option value="Accounting">Accounting</option>
            <option value="Inventory">Inventory</option>
          </select>
      </div>
                <div>
                    <table class="table table-striped table-bordered" id="staffsTable">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1"></tbody>
                    </table>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-btn">
                        <button id="insBtn" class="btn btn-success col-xs-11" type="button">INSERT NEW STAFF</button>
                    </span>
                    <span class="input-group-btn">
                        <button id="updBtn" class="btn btn-warning col-xs-11" type="button">UPDATE STAFF PROFILE</button>
                    </span>
                    <span class="input-group-btn">
                        <button id="delBtn" class="btn btn-danger col-xs-12" type="button">DELETE STAFF</button>
                    </span>
                </div>
                <br>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="jquery-3.7.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
        import { getDatabase, ref, child, onValue, remove } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-database.js";
        import { getStorage, ref as storageRef, deleteObject } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-storage.js";

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

        const app = initializeApp(firebaseConfig);
        const db = getDatabase();
        const storage = getStorage();

        const tbody = document.getElementById('tbody1');
        let selectedRow = null;

        function addItemToTable(staff) {
            const { staffid, stafffname, staffdepart, staffposition, staffphone, staffemail } = staff;
            const trow = document.createElement('tr');

            trow.innerHTML = `
                <td>${staffid}</td>
                <td>${stafffname}</td>
                <td>${staffdepart}</td>
                <td>${staffposition}</td>
                <td>${staffphone}</td>
                <td>${staffemail}</td>
            `;

            trow.addEventListener('click', function () {
                if (selectedRow !== null) {
                    selectedRow.classList.remove('selected');
                }
                selectedRow = this;
                this.classList.add('selected');
            });

            tbody.appendChild(trow);
        }

        function addAllItemsToTable(users) {
            tbody.innerHTML = "";
            users.forEach(user => addItemToTable(user));
        }

        function getAllDataRealtime() {
            const dbRef = ref(db, "UsersData");
            onValue(dbRef, (snapshot) => {
                const users = [];
                snapshot.forEach(childSnapshot => {
                    users.push(childSnapshot.val());
                });
                addAllItemsToTable(users);
                // Initialize DataTable after loading data
                $('#staffsTable').DataTable();
            });
        }

        $('#departmentFilter').change(function(){
            var department = $(this).val();
            $('#staffsTable').DataTable().column(2).search(department).draw();
        });

        function deleteSelectedRow() {
            if (selectedRow !== null) {
                const staffId = selectedRow.cells[0].innerText;

                // Remove the image from Firebase Storage
                const imageRef = storageRef(storage, 'FaceImages/' + staffId + '.jpg');
                deleteObject(imageRef)
                .then(() => {
                })
                .catch((error) => {
                    console.error("Error deleting image: ", error);
                });

                tbody.removeChild(selectedRow);

                remove(ref(db, 'UsersData/' + staffId))
                    .then(() => {
                        alert("Data deleted successfully");
                    })
                    .catch((error) => {
                        alert("Unsuccessful, error: " + error);
                        console.error(error);
                    });
                    remove(ref(db, 'Registration/' + staffId))
                    .then(() => {
                    })
                    .catch((error) => {
                        alert("Unsuccessful, error: " + error);
                    });
                    remove(ref(db, 'HashMap/' + staffId))
                    .then(() => {
                    })
                    .catch((error) => {
                        alert("Unsuccessful, error: " + error);
                    });
                    remove(ref(db, 'VoiceList/' + staffId))
                    .then(() => {
                    })
                    .catch((error) => {
                        alert("Unsuccessful, error: " + error);
                    });

                selectedRow = null;
            } else {
                alert("Please select a row to delete.");
            }
        }

        function updateSelectedRow() {
            if (selectedRow !== null) {
                const staffId = selectedRow.cells[0].innerText;
                window.location.href = 'staffs.php?staffid=' + staffId;
            } else {
                alert("Please select a row to update.");
            }
        }

        document.getElementById('insBtn').addEventListener('click', () => {
            window.location.href = 'staffs.php';
        });

        document.getElementById('updBtn').addEventListener('click', updateSelectedRow);


        document.getElementById('delBtn').addEventListener('click', deleteSelectedRow);

        window.onload = getAllDataRealtime;
    </script>
</body>
</html>
