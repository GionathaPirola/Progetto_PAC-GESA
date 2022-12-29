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
$idstanza = strtoupper(getvar("idstanza"));

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
    case 4: //Cerca stanza per evento
        $arr = newEvento();
        break;
    case 5: //Nuovo Evento
            $arr = addEvento();
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

function addEvento(){
    global $conn, $posti, $user, $nome, $data, $time, $durata, $privacy, $idstanza;
    $arr = array();

    $inizio = substr($data,0,4)."".substr($data,5,2)."".substr($data,8,2)."".substr($time,0,2)."00";

    $sqlID = "SELECT max(`id`) as ID FROM `eventi`";

    $resultID = $conn->query($sqlID);

    $id = 1;

    if ($resultID->num_rows > 0) {
        while ($rowID = $resultID->fetch_assoc()) {
            $id = $rowID['ID'] + 1;
        }
    }

    $sql = "INSERT INTO `eventi`(`id`, `descr`, `private`, `stanza`, `organizz`, `data`, `durata`, `iscritti`) 
    VALUES ('".$id."','".$nome."','".$privacy."','".$idstanza."','".$user."','".$inizio."','".$durata."','".$posti."')";

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

function newEvento()
{
    global $conn, $posti, $user, $nome, $data, $time, $durata, $privacy, $tipo, $luogo, $infrastrutture;
    $arr = array();
    $val = array();
    $val2 = array();

    $inizio = substr($data,0,4)."".substr($data,5,2)."".substr($data,8,2)."".substr($time,0,2)."00";

    //INFRASTRUTTURE
    $sql = "SELECT id as ID, descr as DESCR
		FROM infrastrutture ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $temp = strtoupper(getvar("INFR".$row['ID']));
            if( $temp == "ON"){
                $infrastrutture[$i] =  $row['ID']; 
                $i++;
            }
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
                    if($row['POSIZIONE'] == $luogo || $luogoBOOL == 0){
                        $luogoBOOL = 1;
                        if( (($row['CAPIENZA'] - $posti)<=$diffMIN && $diffMIN>=0) || (($row['CAPIENZA'] - $posti)>=$diffMIN && $diffMIN<=0)){
                            $diffMIN = $row['CAPIENZA'] - $posti;
                        //conta infrastrutture SQL
                        $sql2 = "SELECT infr as INFR
                        FROM infostanza WHERE stanza='".$row['ID']."'";
                        $infrCOUNT = 0;
                        $result2 = $conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            while ($row2 = $result2->fetch_assoc()) {
                                for($k=0; $k<$numInfr; $k++){
                                    if($infrastrutture[$k]==$row2['INFR']){
                                        $infrCOUNT++;
                                        break;
                                    }
                                }
                            }
                        }

                        if($infrCOUNT >= $infrMAX){
                            $bestID = $row['ID'];
                            $infrMAX = $infrCOUNT;
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

    if($tipoBOOL == 1){
        $sql3 = "SELECT A.id as ID, area as AREA, capienza as CAPIENZA, descr as TIPO, B.id as TIPOID, posizione as POSIZIONE, puliziah as PULIZIA, costoh as COSTO, status as STATUS
                FROM stanza A join tipologia B on A.tipologia=B.id
                WHERE A.id='".$bestID."'";

        $sql4 = "SELECT descr as DESCR
        FROM infrastrutture join infostanza on id = infr
        WHERE stanza ='".$bestID."'";
        
        $result3 = $conn->query($sql3);
        $result4 = $conn->query($sql4);

        if ($result3->num_rows > 0) {
            $risposta = 'ok';
            $msg = '';
            while ($row3 = $result3->fetch_assoc()) {
                $val[] = array(
                    'id' => $row3['ID'],
                    'area' => $row3['AREA'],
                    'capienza' => $row3['CAPIENZA'],
                    'tipo' => $row3['TIPO'],
                    'tipoID' => $row3['TIPOID'],
                    'posizione' => $row3['POSIZIONE'],
                    'pulizia' => $row3['PULIZIA'],
                    'costo' => $row3['COSTO'],
                    'status' => $row3['STATUS'],
                    'utente' => $user,
                    'durata' => $durata,
                    'evento' => $nome,
                    'data' => $data,
                    'time' => $time,
                    'privacy' => $privacy,
                    'posti' => $posti
                );
            }
        } else {
            $risposta = 'no';
            $msg = 'errore nell\'estrazione dei dati';
        }

        if ($result4->num_rows > 0) {
            $risposta = 'ok';
            $msg = '';
            while ($row4 = $result4->fetch_assoc()) {
                $val2[] = array(
                    'infr' => $row4['DESCR'],
                );
            }
        }
    }else{
        $risposta = 'no';
        $msg = 'nessuna stanza adatta trovata'; 
    }

    CloseCon($conn);

    $arr = array(
        'elementi' => $val,
        'infrastrutture' => $val2,
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