<?php

include 'db_connection.php';

$arr = array();
$uname = strtoupper(getvar("uname"));
$psw = getvar("psw");
$mail = getvar("mail");
$gruppo = strtoupper(getvar("gruppo"));

$conn = OpenCon();

$arr = getInfo();

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
    global $conn,$uname,$psw,$mail,$gruppo;
	$arr = array();
	$val = array();

    $risposta="";
    $msg="";
	
	$sql = "SELECT count(*) as COUNT
		FROM utente
		WHERE username='".$uname."' ";
		
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['COUNT'] > 0){
            $risposta='no';
            $msg='utente già esistente';
        } else {
            $sql2 = "INSERT INTO `utente`(`username`, `password`, `mail`, `admin`) 
            VALUES ('".$uname."','".$psw."','".$mail."','0') ";
            
            $result2 = $conn->query($sql2);

            if ($result2 === TRUE) {
                $risposta = "ok";

                if($gruppo!=""){
                    $sql3 = "INSERT INTO `associazione`(`utente`, `associazione`) VALUES ('".$uname."','".$gruppo."') ";
                    
                    $result3 = $conn->query($sql3);

                    if ($result3 === TRUE) {
                        $risposta = "ok";
                    } else {
                        $risposta = "no";
                        $msg='errore durante la creazione dell\'associazione';
                    }
                }

            } else {
                $risposta = "no";
                $msg='errore durante la creazione dell\'utente';
            }
        }
    }

    CloseCon($conn);

    if($risposta == "ok"){
        header( 'Location: /practice/Frontpage.php' );
        exit;
    }else{
        echo $msg;
        exit;
    }

}

?>