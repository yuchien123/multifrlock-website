
  <?php include_once 'nav_bar.php'; ?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Multi-FR Lock : Staff Details</title>
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="guracss.css">
   <style>
    .image-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: -20px;
    }
    .image-container img {
      width: 120px; 
      border: 3px solid blue; 
      border-radius: 10px;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <h2 style="margin-top: -30px">User Details</h2>
      </div>
      <div class="image-container">
        <img id="profileImage" src="profile.png" alt="Profile Image">
      </div>
      <form id="staffForm">
        <div class="form-group">
          <label for="staffid" class="col-sm-3 control-label">User ID</label>
          <div class="col-sm-9">
            <input name="sid" type="text" class="form-control" id="staffid" placeholder="Staff ID" required>
          </div>
        </div>
        <div class="form-group"><br><br></div>
        <div class="form-group">
          <label for="stafffname" class="col-sm-3 control-label">User Name</label>
          <div class="col-sm-9">
            <input name="fname" type="text" class="form-control" id="stafffname" placeholder="Staff First Name" required>
          </div>
        </div>
        <div class="form-group"><br><br></div>
        <div class="form-group">
          <label for="staffdepart" class="col-sm-3 control-label">Department</label>
          <div class="col-sm-9">
            <select name="department" class="form-control" id="staffdepart" required>
              <option value="">Please select</option>
              <option value="Marketing">Marketing</option>
              <option value="Sales">Sales</option>
              <option value="Financial">Financial</option>
              <option value="Accounting">Accounting</option>
              <option value="Inventory">Inventory</option>
            </select>
          </div>
        </div>
        <div class="form-group"><br><br></div>
        <div class="form-group">
          <label for="staffphone" class="col-sm-3 control-label">Phone Number</label>
          <div class="col-sm-9">
            <input name="phone" type="text" class="form-control" id="staffphone" placeholder="Staff Phone Number" required>
          </div>
        </div>
        <div class="form-group"><br><br></div>
        <div class="form-group">
          <label for="staffemail" class="col-sm-3 control-label">Email Address</label>
          <div class="col-sm-9">
            <input name="email" type="email" class="form-control" id="staffemail" placeholder="Staff Email Address" required>
          </div>
        </div>
        <div class="form-group"><br><br></div>
        <div class="form-group">
          <label for="staffposition" class="col-sm-3 control-label">Position</label>
          <div class="col-sm-9">
            <select name="position" class="form-control" id="staffposition" required>
              <option value="">Please select</option>
              <option value="Admin">Admin</option>
              <option value="Supervisor">Supervisor</option>
              <option value="Normal Staff">Normal Staff</option>
            </select>
          </div>
        </div>
        <div class="form-group"><br><br></div>
        <div class="form-group" id="staffpasswordGroup" style="display: none;">
          <label for="staffpassword" class="col-sm-3 control-label">Password</label>
          <div class="col-sm-9">
            <input name="spassword" type="password" class="form-control" id="staffpassword" placeholder="Password"><br><br>
          </div>
        </div>
        <div class="form-group"></div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button type="button" class="btn btn-default" id="Insbtn"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</button>
            <button type="button" class="btn btn-default" id="Retbtn"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Retrieve</button>
            <button type="button" class="btn btn-default" id="Updbtn"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
            <button type="button" class="btn btn-default" id="Delbtn"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button>
            <br><br>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="jquery-3.7.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.18.0/js/md5.min.js"></script>
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
  import { getDatabase, ref, set, child, update, remove, get } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-database.js";
  import { getStorage, ref as storageRef, getDownloadURL, deleteObject} from "https://www.gstatic.com/firebasejs/10.11.1/firebase-storage.js";

  document.addEventListener('DOMContentLoaded', () => {
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
    const storage = getStorage(app);

    function getQueryParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        const staffId = getQueryParameter('staffid');

        if (staffId) {
            const staffRef = ref(db, 'UsersData/' + staffId);
            get(staffRef).then(snapshot => {
                if (snapshot.exists()) {
                    const staffData = snapshot.val();
                    document.getElementById('staffid').value = staffData.staffid;
                    document.getElementById('stafffname').value = staffData.stafffname;
                    document.getElementById('staffdepart').value = staffData.staffdepart;
                    document.getElementById('staffposition').value = staffData.staffposition;
                    document.getElementById('staffphone').value = staffData.staffphone;
                    document.getElementById('staffemail').value = staffData.staffemail;
                    if ("<?php echo isset($_SESSION['staffid']) ? $_SESSION['staffid'] : ''; ?>" === staffId) {
                      staffpasswordGroup.style.display = 'block';
                      staffpassword.required = true;
                      staffpassword.value = '';
                    } else {
                      staffpasswordGroup.style.display = 'none';
                      staffpassword.required = false;
                    }
                    const profileImage = document.getElementById('profileImage');
                    const imageRef = storageRef(storage, `FaceImages/${staffId}.jpg`);
                    getDownloadURL(imageRef)
                    .then((url) => {
                      profileImage.src = url;
                    })
                    .catch((error) => {
                      console.error("Error fetching profile image:", error);
                    });
                } else {
                    console.log('No data available for the specified staff ID');
                }
            }).catch(error => {
                console.error(error);
            });
        }

    const staffid = document.getElementById('staffid');
    const stafffname = document.getElementById('stafffname');
    const staffposition = document.getElementById('staffposition');
    const staffdepart = document.getElementById('staffdepart');
    const staffphone = document.getElementById('staffphone');
    const staffemail = document.getElementById('staffemail');
    const staffpassword = document.getElementById('staffpassword');
    const staffpasswordGroup = document.getElementById('staffpasswordGroup');

    const Insbtn = document.getElementById('Insbtn');
    const Updbtn = document.getElementById('Updbtn');
    const Delbtn = document.getElementById('Delbtn');
    const Retbtn = document.getElementById('Retbtn');

    staffposition.addEventListener('change', function() {
      if (this.value === 'Admin' && "<?php echo isset($_SESSION['staffid']) ? $_SESSION['staffid'] : ''; ?>" === staffid.value) {
        staffpasswordGroup.style.display = 'block';
        staffpassword.required = true;
      } else {
        staffpasswordGroup.style.display = 'none';
        staffpassword.required = false;
      }
    });

    function sendEmail() {
            // Get form elements
            const email = document.querySelector('input[name="email"]').value;
            const sid = document.querySelector('input[name="sid"]').value;

            // Create a FormData object
            const formData = new FormData();
            formData.append('email', email);
            formData.append('sid', sid);
            formData.append('send', true);

            // Send the form data using fetch
            fetch('send.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert('Send Successfully');
                window.location.href = 'staffs.php';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to send email');
            });
        }

    function AddData() {
      const data = {
        staffid: staffid.value,
        stafffname: stafffname.value,
        staffposition: staffposition.value,
        staffdepart: staffdepart.value,
        staffphone: staffphone.value,
        staffemail: staffemail.value,
      };

      const staffRef = ref(db, 'UsersData/' + staffid.value);
      get(staffRef).then((snapshot) => {
        if (snapshot.exists()) {
          alert("The Staff ID already exists.");
        } else {
          set(staffRef, data)
            .then(() => {
              alert("Data stored successfully");
              ResetData();
            })
            .catch((error) => {
              alert("Unsuccessful, error: " + error);
            });
        }
      }).catch((error) => {
        alert("Error checking staff ID: " + error);
      });
      if(staffposition.value==='Admin'){
        sendEmail();
      }
    }

    function RetData() {
      const dbRef = ref(db);
      get(child(dbRef, 'UsersData/' + staffid.value)).then((snapshot) => {
        if (snapshot.exists()) {
          const data = snapshot.val();
          staffid.value = data.staffid;
          stafffname.value = data.stafffname;
          staffposition.value = data.staffposition;
          staffdepart.value = data.staffdepart;
          staffphone.value = data.staffphone;
          staffemail.value = data.staffemail;

          if ("<?php echo isset($_SESSION['staffid']) ? $_SESSION['staffid'] : ''; ?>" === staffid.value) {
            staffpasswordGroup.style.display = 'block';
            staffpassword.required = true;
            staffpassword.value = '';
          } else {
            staffpasswordGroup.style.display = 'none';
            staffpassword.required = false;
          }
        } else {
          alert("User does not exist");
        }
      }).catch((error) => {
        alert("Unsuccessful, error: " + error);
      });
      const profileImage = document.getElementById('profileImage');
      const imageRef = storageRef(storage, `FaceImages/${staffid.value}.jpg`);
      getDownloadURL(imageRef)
       .then((url) => {
        profileImage.src = url;
      })
      .catch((error) => {
        console.error("Error fetching profile image:", error);
        profileImage.src = 'profile.png';
      });
    }

    function UpdateData() {
      const hashedPassword = "<?php echo isset($_SESSION['staffid']) ? $_SESSION['staffid'] : ''; ?>" === staffid.value ? md5(staffpassword.value) : '';
      const data = {
        stafffname: stafffname.value,
        staffposition: staffposition.value,
        staffdepart: staffdepart.value,
        staffphone: staffphone.value,
        staffemail: staffemail.value,
      };

      const staffRef = ref(db, 'UsersData/' + staffid.value);
      get(staffRef).then((snapshot) => {
        if (snapshot.exists()) {
          update(staffRef, data)
            .then(() => {
              alert("Data updated successfully");
              ResetData();
            })
            .catch((error) => {
              alert("Unsuccessful, error: " + error);
            });
        } else {
          alert("Staff does not exist");
        }
      }).catch((error) => {
        alert("Error checking staff ID: " + error);
      });

      if(staffposition.value==='Admin'){
        const regisRef = ref(db, 'Registration/' + staffid.value);
      get(regisRef).then((snapshot) => {
        if (snapshot.exists()) {
          if ("<?php echo isset($_SESSION['staffid']) ? $_SESSION['staffid'] : ''; ?>" === staffid.value && staffpassword.value!=='') {
            update(regisRef, {password:hashedPassword})
            .then(() => {
            })
            .catch((error) => {
              alert("Unsuccessful, error: " + error);
            });
          }
        } 
      }).catch((error) => {
        alert("Error checking staff ID: " + error);
      });
    }else{
      DeleteRegisData();
    }

      

      if(staffposition.value==='Admin'){
        sendEmail();
      }
    }

    function DeleteData() {
      // Remove the image from Firebase Storage
      const imageRef = storageRef(storage, 'FaceImages/' + staffid.value + '.jpg');
      deleteObject(imageRef)
      .then(() => {
      })
      .catch((error) => {
        console.error("Error deleting image: ", error);
      });
      remove(ref(db, 'UsersData/' + staffid.value)).then(() => {
        alert("Data deleted successfully");
        ResetData();
      }).catch((error) => {
        alert("Unsuccessful, error: " + error);
      });
      DeleteRegisData();
      DeleteFaceData();
      DeleteVoiceData();
    }
     function DeleteRegisData() {
      remove(ref(db, 'Registration/' + staffid.value)).then(() => {
      }).catch((error) => {
        alert("Unsuccessful, error: " + error);
      });
    }
    function DeleteFaceData() {
      remove(ref(db, 'HashMap/' + staffid.value)).then(() => {
      }).catch((error) => {
        alert("Unsuccessful, error: " + error);
      });
    }
    function DeleteVoiceData() {
      remove(ref(db, 'VoiceList/' + staffid.value)).then(() => {
      }).catch((error) => {
        alert("Unsuccessful, error: " + error);
      });
    }

    function ResetData() {
      staffid.value = '';
      stafffname.value = '';
      staffposition.value = '';
      staffdepart.value = '';
      staffphone.value = '';
      staffemail.value = '';
      staffpassword.value = '';
      profileImage.src = 'profile.png';
    }

    Insbtn.addEventListener('click', AddData);
    Updbtn.addEventListener('click', UpdateData);
    Delbtn.addEventListener('click', DeleteData);
    Retbtn.addEventListener('click', RetData);
  });
</script>
</body>
</html>
