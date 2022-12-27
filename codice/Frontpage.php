<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
</style>
</head>
<body>
<div id="id01" class="modal" style="display:block">
  
  <form class="modal-content animate" action="http://localhost/practice/json/login.php" method="post">
    <div class="imgcontainer">
      <img src="img/profile.png" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Nome Utente</b></label>
      <input type="text" placeholder="Inserisci Nome Utente" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Inserisci Password" name="psw" required>
        
      <button type="submit">LOGIN</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="showReg()" class="changebtn">REGISTRATI</button>
    </div>
  </form>
</div>

<div id="id02" class="modal two">
  
  <form class="modal-content animate" action="http://localhost/practice/json/register.php" method="post">
    <div class="imgcontainer">
      <img src="img/profile.png" class="avatar">
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
        
      <button type="submit">REGISTRATI</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
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
