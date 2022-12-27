<?php

include 'db_connection.php';

$arr = array();
$info = getvar("info");
$evento = strtoupper(getvar("idEvento"));
$posti = strtoupper(getvar("partecipanti"));
$user = strtoupper(getvar("uname"));

$conn = OpenCon();

switch ($info) {
    case 1: //Elenco Tipologie
        $arr = getInfoUser();
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

function getInfoUser(){
    global $conn,$user;
	$arr = array();
	$val = array();

    //GET PARTECIPANTI
    $sql = "SELECT username as NOME, mail as MAIL, associazione as ASSOCIAZIONE
            from utente left join associazione on utente = username
            where username = '".$user."'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $risposta='ok';
        $msg='';
        while($row = $result->fetch_assoc()) {

            $val[]= array (							
				'username' => $row['NOME'],
                'mail' => $row['MAIL'],
                'associazione' => $row['ASSOCIAZIONE'],
			);

        }
    }else{
        $risposta='no';
        $msg='errore nella selezione dei dati';
    }

    CloseCon($conn);

	$arr = array(
        'elementi' => $val,
		'result' => $risposta,
		'errore' => $msg
	);
	
	return $arr;
}


?>