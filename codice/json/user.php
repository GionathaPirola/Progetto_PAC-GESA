<?php

include 'db_connection.php';

$arr = array();
$info = getvar("info");
$evento = strtoupper(getvar("idEvento"));
$posti = strtoupper(getvar("partecipanti"));
$user = strtoupper(getvar("uname"));
$asso = strtoupper(getvar("asso"));
$psw = getvar("psw");

$conn = OpenCon();

switch ($info) {
    case 1: //Info Utente
        $arr = getInfoUser();
        break;
    case 2: //nuova associazione
        $arr = newAssociazione();
        break;
    case 3: //iscrizione ad associazione
        $arr = subAssociazione();
        break;
}

echo json_encode($arr);

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

function subAssociazione(){
    global $conn,$asso,$user,$psw;
    $arr = array();

    $count = 0;

    $sql = "SELECT count(*) as CNT
		FROM soci 
        WHERE associazione = '" . $asso . "' and utente= '" . $user . "'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count = $row['CNT'];

    if ($count == 0) {
        $sql4 = "SELECT count(*) as COUNT FROM associazione WHERE nome = '" . $asso . "' and password = '" . $psw . "'";
        $result4 = $conn->query($sql4);
        $row4 = $result4->fetch_assoc();   
        
        if($row4['COUNT'] > 0){
            $sql3 = "INSERT INTO `soci`(`utente`, `associazione`) VALUES ('".$user."','".$asso."') ";
        
            $result3 = $conn->query($sql3);

            if ($result3 === TRUE) {
                $risposta = "ok";
                $msg="";
            } else {
                $risposta = "no";
                $msg='errore durante la creazione dell\'associazione';
            }
        } else {
            $risposta='no';
            $msg='associazione non esistente';
        }
    }else {
        $risposta = 'no';
        $msg = 'utente già iscritto';
    }

    CloseCon($conn);

    $arr = array(
        'result' => $risposta,
        'errore' => $msg
    );

    return $arr;
}

function newAssociazione(){
    global $conn,$asso,$psw;
    $arr = array();
    $count = 0;

    $sql = "SELECT count(*) as CNT
		FROM associazione 
        WHERE nome = '" . $asso . "'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count = $row['CNT'];

    if ($count == 0) {

        $risposta = 'ok';
        $msg = '';

        $sql3 = "SELECT max(id) as ID
		FROM associazione ";

        if($result3 = $conn->query($sql3)){
            $row3 = $result3->fetch_assoc();
            $maxid = $row3['ID'] + 1;
        }else{
            $maxid = 1 ;
        }

        $sql2 = "INSERT INTO `associazione`(`id`, `nome`, `password`) 
            VALUES ('" . $maxid . "','" . $asso . "','" . $psw . "')";

        $result2 = $conn->query($sql2);

        if ($result2 === TRUE) {
            $risposta = "ok";
            $msg = '';
        } else {
            $risposta = "no";
            $msg = 'errore durante l\'inserimento';
        }

    } else {
        $risposta = 'no';
        $msg = 'associazione esistente';
    }

    CloseCon($conn);

    $arr = array(
        'result' => $risposta,
        'errore' => $msg
    );

    return $arr;
}

function getInfoUser(){
    global $conn,$user;
	$arr = array();
	$val = array();
    $val2 = array();

    //GET PARTECIPANTI
    $sql = "SELECT username as NOME, mail as MAIL
            from utente left join soci on utente = username
            where username = '".$user."'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $risposta='ok';
        $msg='';
        while($row = $result->fetch_assoc()) {

            $val[]= array (							
				'username' => $row['NOME'],
                'mail' => $row['MAIL'],
			);

        }

        $sql2 = "SELECT associazione as ASSO
            from soci 
            where utente = '".$user."'";

        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {
            $risposta='ok';
            $msg='';
            while($row2 = $result2->fetch_assoc()) {
    
                $val2[]= array (							
                    'associazione' => $row2['ASSO'],
                );
    
            }
        }
    
    }else{
        $risposta='no';
        $msg='errore nella selezione dei dati';
    }

    CloseCon($conn);

	$arr = array(
        'elementi' => $val,
        'associazioni' => $val2,
		'result' => $risposta,
		'errore' => $msg
	);
	
	return $arr;
}


?>