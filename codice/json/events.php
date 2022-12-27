<?php

include 'db_connection.php';

$arr = array();
$info = getvar("info");
$evento = strtoupper(getvar("idEvento"));
$posti = strtoupper(getvar("partecipanti"));
$user = strtoupper(getvar("uname"));
$nome = strtoupper(getvar("nome"));
$data = strtoupper(getvar("data"));
$time = strtoupper(getvar("time"));
$durata = strtoupper(getvar("durata"));
$privacy = strtoupper(getvar("public"));
$tipo = strtoupper(getvar("tipo"));
$luogo = strtoupper(getvar("luogo"));

$infrastrutture = array();


$conn = OpenCon();

switch ($info) {
    case 1: //Elenco Tipologie
        $arr = newSubscr();
        break;
    case 2: //Elenco Infrastrutture
        $arr = getInfrastrutture();
        break;
    case 3: //Elenco Tipologie
        $arr = getTipo();
        break;
    case 4: //Nuovo Evento
        $arr = newEvento();
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

function newEvento()
{
    global $conn, $posti, $user, $nome, $data, $time, $durata, $privacy, $tipo, $luogo;
    $arr = array();
    $val = array();

    $inizio = substr($data,0,4) + ""+ substr($data,5,2) + ""+ substr($data,8,2) + "" + substr($time,0,2) + ":00";

    //INFRASTRUTTURE
    $sql = "SELECT id as ID, descr as DESCR
		FROM infrastrutture ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $infrastrutture[$i] = strtoupper(getvar("INFR" + $row['ID'])); 
            $i++;
        }
        $numInfr = $i;
    }

    //EVENTO
    $sql = "SELECT A.id as ID, area as AREA, capienza as CAPIENZA, descr as TIPO, B.id as TIPOID, posizione as POSIZIONE, puliziah as PULIZIA, costoh as COSTO, status as STATUS
    FROM stanza A join tipologia B on A.tipologia=B.id 
    WHERE not exists (SELECT * FROM eventi C WHERE C.stanza = A.id and (C.data > (".$inizio." + ".$durata."*100 + A.puliziah*100) or (C.data + C.durata*100 + A.puliziah*100)<".$inizio.") )";

    $result = $conn->query($sql);

    //contatori per trovare la stanza migliore
    $bestID = 0;
    $tipoBOOL = 0;
    $diffMIN = 30;
    $luogoBOOL = 0;
    $infrMAX = 0;

    if ($result->num_rows > 0) {
        $risposta = 'ok';
        $msg = '';
        while ($row = $result->fetch_assoc()) {
            if($row['TIPOID'] == $tipo){
                $tipoBOOL = 1;
                if($row['CAPIENZA'] >= $posti || $diffMIN >= 30 || $diffMIN < 0){
                    if($row['POSIZIONE'] == $luogo || $luogoBOOL = 0){
                        if( (($row['CAPIENZA'] - $posti)<=$diffMIN && $diffMIN>=0) || (($row['CAPIENZA'] - $posti)>=$diffMIN && $diffMIN<=0)){
                            $diffMIN = $row['CAPIENZA'] - $posti;
                        //conta infrastrutture SQL
                        $sql = "SELECT A.id as ID, area as AREA, capienza as CAPIENZA, descr as TIPO, B.id as TIPOID, posizione as POSIZIONE, puliziah as PULIZIA, costoh as COSTO, status as STATUS
                        FROM stanza A join infrastruttura B on A.id=B.stanza";
                        //finire questo 
                        if($row2['COUNT'] >= $infrMAX){
                            $bestID == $row['ID'];
                        }
                    }
                    }
                }
            }
        }
    } else {
        $risposta = 'no';
        $msg = 'errore nell\'estrazione dei dati';
    }

    if($tipoBOOL){
        //seleziona tutte le info e le infrastrutture della stanza e inviale
    }else{
        $risposta = 'no';
        $msg = 'nessuna stanza adatta trovata'; 
    }

    CloseCon($conn);

    $arr = array(
        'elementi' => $val,
        'result' => $risposta,
        'errore' => $msg
    );

    return $arr;

}

function getInfrastrutture()
{
    global $conn;
    $arr = array();
    $val = array();

    $sql = "SELECT id as ID, descr as DESCR
		FROM infrastrutture ";

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
        $msg = 'errore nell\'estrazione dei dati';
    }

    CloseCon($conn);

    $arr = array(
        'elementi' => $val,
        'result' => $risposta,
        'errore' => $msg
    );

    return $arr;
}

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

function newSubscr()
{
    global $conn, $evento, $user, $posti;
    $arr = array();
    $val = array();

    //GET PARTECIPANTI
    $sql = "SELECT count(*) as ISCRITTI 
            from pubblico
            where evento = '" . $evento . "'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $iscritti = $row['ISCRITTI'];
    } else {
        $iscritti = 0;
    }

    if ($iscritti == $posti) {
        $risposta = "no";
        $msg = "l'evento è già al completo";
    } else {
        //CHECK IF EXISTS
        $sql3 = "SELECT * FROM pubblico
                WHERE evento = '" . $evento . "' and utente = '" . $user . "'";

        $result3 = $conn->query($sql3);

        if ($result3->num_rows > 0) {
            $risposta = "no";
            $msg = "l'utente è già iscritto";
        } else {
            //INSERT UTENTE
            $sql2 = "INSERT INTO pubblico (evento, utente)
            VALUES ('" . $evento . "', '" . $user . "')";

            $result2 = $conn->query($sql2);

            if ($result2 === TRUE) {
                $risposta = "ok";
                $msg = '';
            } else {
                $risposta = "no";
                $msg = 'errore durante l\'iscrizione';
            }
        }
    }

    CloseCon($conn);

    $arr = array(
        'result' => $risposta,
        'errore' => $msg
    );

    return $arr;
}


?>