<?php

include 'db_connection.php';

$arr = array();
$uname = strtoupper(getvar("uname"));
$psw = getvar("psw");

$conn = OpenCon();

getInfo();

//echo json_encode($arr);

function getvar($name,$isint="") {
   if(isset($_REQUEST[$name])) {
       return $_REQUEST[$name];
   } else {
       if($isint) {
           return 0;
       } else {
           return "";
       }
   }
}

//SQL

function getInfo(){
    global $conn,$uname,$psw;
	$arr = array();
	$val = array();
	
	$sql = "SELECT username as USER, password as PSW
		FROM utente
		WHERE username='".$uname."' ";
		
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if($row['PSW'] == $psw){
                $risposta='ok';
                $msg='';
            }else{
                $risposta='no';
                $msg='password errata';           
            }
        }
    } else {
            $risposta='no';
            $msg='utente inesistente';
    }

    CloseCon($conn);

    if($risposta == "ok"){
        session_start();
        $_SESSION['username'] = $uname;
        header( 'Location: /practice/HomePage.php' );
        exit;
    }else{
        header( 'Location: /practice/Frontpage.php' );
        exit;
    }

}

?>