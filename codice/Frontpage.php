<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  background-image: url('img/sfondo.png');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
}

/* Full-width input fields */
input[type=text], input[type=password], input[type=email] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: rgb(5, 68, 104);
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

/* Extra styles for the cancel button */
.changebtn {
  width: 18%;
  padding: 1.5% 2.5%;
  background-color: rgb(5, 50, 104);
  float: right;
}

.loginbtn {
  width: 18%;
  padding: 1.5% 2.5%;
  background-color: rgb(5, 68, 104);
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 15%;
}

.container {
  padding: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 40%; /* Could be more or less, depending on screen size */
}


/* Add Zoom Animation */
.animate {
  animation: animatezoom 0.5s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

</style>
</head>
<body>
<div id="id01" class="modal" style="display:block">
  
  <form class="modal-content animate" action="http://localhost/practice/json/login.php" method="post">
    <div class="imgcontainer">
      <img src="img/icona.png" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Nome Utente</b></label>
      <input type="text" placeholder="Inserisci Nome Utente" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Inserisci Password" name="psw" required>
        
      
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="submit" class="loginbtn">ACCEDI</button>
      <button type="button" onclick="showReg()" class="changebtn">REGISTRATI</button>
    </div>
  </form>
</div>

<div id="id02" class="modal two">
  
  <form class="modal-content animate" action="http://localhost/practice/json/register.php" method="post">
    <div class="imgcontainer">
      <img src="img/icona.png" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Nome Utente</b></label>
      <input type="text" placeholder="Inserisci Nome Utente" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Inserisci Password" name="psw" required>

      <label for="mail"><b>E-mail</b></label>
      <input type="email" placeholder="Inserisci E-mail" name="mail" required>

      <label for="gruppo"><b>Associazione</b></label>
      <input type="text" placeholder="Inserisci Associazione" name="gruppo" required>

      <label for="pswasso"><b>Password Associazione</b></label>
      <input type="text" placeholder="Inserisci Password Associazione" name="pswasso" required>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="submit" class="loginbtn">REGISTRATI</button>
      <button type="button" onclick="showLog()" class="changebtn">LOGIN</button>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');
var two = document.getElementById('id02');



function showReg(){
  modal.style.display = "none";
  two.style.display = "block";
}

function showLog(){
  two.style.display = "none";
  modal.style.display = "block";
}

</script>

</body>
</html>
