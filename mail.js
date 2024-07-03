
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

firebase.initializeApp(firebaseConfig);

var contactFormDB = firebase.database().ref('staffsForm');

document.getElementById('staffsForm').addEventListener('submit', submitForm);

function submitForm(e){
  e.preventDefault();

  var staffid = getElementVal('staffid');
  var stafffname = getElementVal('stafffname');
  var staffposition = getElementVal('staffposition');
  var staffdepart = getElementVal('staffdepart');
  var staffphone = getElementVal('staffphone');
  var staffemail = getElementVal('staffemail');
  var staffpassword = getElementVal('staffpassword');


  saveMessages(staffid, stafffname, staffposition, staffdepart, staffphone, staffemail, staffpassword.then(() => {
    // Show success message to the user
    alert("Staff information saved successfully!");
    // Clear the form after successful submission
    document.getElementById('staffsForm').reset();
  })
  .catch((error) => {
    // Show error message to the user
    alert("An error occurred while saving staff information: " + error.message);
  });
}

const saveMessages =(staffid, stafffname, staffposition, staffdepart, staffphone, staffemail, staffpassword)=>{
    const hashedPassword = md5(staffpassword);
  contactFormDB.child(staffid).set({
    staffid : staffid,
    stafffname : stafffname,
    staffposition : staffposition,
    staffdepart : staffdepart,
    staffphone : staffphone,
    staffemail : staffemail,
    staffpassword : hashedPassword,
  });
};

const getElementVal = (id) => {
  return document.getElementById(id).value;
};