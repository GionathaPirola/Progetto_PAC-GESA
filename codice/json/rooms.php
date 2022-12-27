<?php

include 'db_connection.php';

$arr = array();
$info = getvar("info");
$id = strtoupper(getvar("id"));
$tipo = strtoupper(getvar("tipo"));
$area = strtoupper(getvar("area"));
$capienza = strtoupper(getvar("capienza"));
$pulizia = strtoupper(getvar("pulizia"));
$costo = strtoupper(getvar("costo"));
$posizione = strtoupper(getvar("posizione"));
$status = strtoupper(getvar("status"));

$conn = OpenCon();

switch ($info) {
    case 1: //Elenco Tipologie
        $arr = getTipo();
        break;
    case 2: //Nuova stanza
        $arr = newRoom();
        break;
    case 3: //Elenco stanze
        $arr = allRooms();
        break;
    case 4: //Update stanza
        $arr = updateRoom();
        break;
}

echo json_encode($arr);

function getvar($name, $isint = "")
{
    if (isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    } else {
        if ($isint) {
            return 0;
        } else {
            return "";
        }
    }
}

//SQL

function getTipo()
{
    global $conn;
    $arr = array();
    $val = array();

    $sql = "SELECT id as ID, descr as DESCR
		FROM tipologia ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $risposta = 'ok';
        $msg = '';
        while ($row = $result->fetch_assoc()) {

            $val[] = array(
                'id' => $row['ID'],
                'descr' => $row['DESCR']
            );

        }
    } else {
        $risposta = 'no';
        $msg = 'utente inesistente';
    }

    CloseCon($conn);

    $arr = array(
        'elementi' => $val,
        'result' => $risposta,
        'errore' => $msg
    );

    return $arr;

}

function newRoom()
{
    global $conn, $tipo, $area, $capienza, $pulizia, $costo, $posizione;
    $arr = array();
    $val = array();

    //GET MAX ID
    $sql = "SELECT max(Id) as ID from stanza";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['ID'] + 1;
    } else {
        $id = 1;
    }

    //INSERT STANZA
    $sql2 = "INSERT INTO `stanza`(`id`, `area`, `capienza`, `tipologia`, `posizione`, `puliziah`, `costoh`, `status`) 
            VALUES ('" . $id . "','" . $area . "','" . $capienza . "','" . $tipo . "','" . $posizione . "','" . $pulizia . "','" . $costo . "','0')";

    $result2 = $conn->query($sql2);

    if ($result2 === TRUE) {
        $risposta = "ok";
        $msg = '';
    } else {
        $risposta = "no";
        $msg = 'errore durante la creazione dell\'utente';
    }

    CloseCon($conn);

    $arr = array(
        'result' => $risposta,
        'errore' => $msg
    );

    return $arr;
}
function allRooms()
{

    global $conn;
    $arr = array();
    $val = array();

    $sql = "SELECT A.id as ID, area as AREA, capienza as CAPIENZA, descr as TIPO, B.id as TIPOID, posizione as POSIZIONE, puliziah as PULIZIA, costoh as COSTO, status as STATUS
		FROM stanza A join tipologia B on A.tipologia=B.id ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $risposta = 'ok';
        $msg = '';

        while ($row = $result->fetch_assoc()) {

            $val[] = array(
                'id' => $row['ID'],
                'area' => $row['AREA'],
                'capienza' => $row['CAPIENZA'],
                'tipo' => $row['TIPO'],
                'tipoID' => $row['TIPOID'],
                'posizione' => $row['POSIZIONE'],
                'pulizia' => $row['PULIZIA'],
                'costo' => $row['COSTO'],
                'status' => $row['STATUS'],
            );

        }
    } else {
        $risposta = 'no';
        $msg = 'errore durante l\'elaborazione dei dati';
    }

    CloseCon($conn);

    $arr = array(
        'elementi' => $val,
        'result' => $risposta,
        'errore' => $msg
    );

    return $arr;
}

function updateRoom()
{
    global $conn, $tipo, $area, $capienza, $pulizia, $costo, $posizione, $id, $status;
    $arr = array();
    $val = array();

    //UPDATE STANZA
    $sql = "UPDATE `stanza` 
            SET `area`='" . $area . "',`capienza`='" . $capienza . "',`tipologia`='" . $tipo . "',`posizione`='" . $posizione . "',`puliziah`='" . $pulizia . "',`costoh`='" . $costo . "',`status`='" . $status . "' 
            WHERE `id`='" . $id . "'";

    $result = $conn->query($sql);

    if ($result === TRUE) {
        $risposta = "ok";
        $msg = '';
    } else {
        $risposta = "no";
        $msg = 'errore durante la creazione dell\'utente';
    }

    CloseCon($conn);

    $arr = array(
        'result' => $risposta,
        'errore' => $msg
    );

    return $arr;
}


?>