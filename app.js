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

  var staffid = getElementVal('staffid');
  var stafffname = getElementVal('stafffname');
  var staffposition = getElementVal('staffposition');
  var staffdepart = getElementVal('staffdepart');
  var staffphone = getElementVal('staffphone');
  var staffemail = getElementVal('staffemail');
  var staffpassword = getElementVal('staffpassword');

  function InsertData(){
    set(ref(db,"UserData/"+staffid),{
        staffid : staffid.value,
        stafffname : stafffname.value,
        staffposition : staffposition.value,
        staffdepart : staffdepart.value,
        staffphone : staffphone.value,
        staffemail : staffemail.value,
        staffpassword : hashedPassword.value,
    }).then(()=>{
        alert("data stored successfully");
    })
    .catch((error)=>{
        alert("unsuccessful, error"+error);
    });
  }

  document.getElementById('staffsForm').addEventListener('submit', InsertData);