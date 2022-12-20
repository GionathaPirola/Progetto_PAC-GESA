<?php

include 'db_connection.php';

$arr = array();
$info = getvar("info");

$conn = OpenCon();

switch ($info) {
    case 1: //Elenco Tipologie
        $arr = getTipo();
        break;
    case 2: //Nuova stanza
        $arr = newRoom();
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

//SQL

function getTipo(){
    global $conn;
	$arr = array();
	$val = array();
	
	$sql = "SELECT id as ID, descr as DESCR
		FROM tipologia ";
		
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $risposta='ok';
        $msg='';
        while($row = $result->fetch_assoc()) {

            $val[]= array (							
				'id' => $row['ID'],
                'descr' => $row['DESCR']
			);

        }
    } else {
        $risposta='no';
        $msg='utente inesistente';
    }

    CloseCon($conn);

	$arr = array(
		'elementi' => $val,
		'result' => $risposta,
		'errore' => $msg
	);
	
	return $arr;

}

function newRoom(){
    global $conn;
	$arr = array();
	$val = array();

    $risposta='ok';
    $msg='';

    $arr = array(
		'result' => $risposta,
		'errore' => $msg
	);

    return $arr;

}

?>