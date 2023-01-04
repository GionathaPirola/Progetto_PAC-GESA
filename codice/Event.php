<?php
session_start();
$user = strtoupper($_SESSION['username']);

include 'json\db_connection.php';

$conn = OpenCon();

$admin = isAdmin(); //1 se admin

function isAdmin()
{
    global $conn, $user;
    $arr = array();
    $val = array();

    $sql = "SELECT admin as ADMIN
		FROM utente
        WHERE username = '" . $user . "'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['ADMIN'];
    }
}

$admin = isAdmin(); //1 se admin

?>
<html>

<!--<script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>-->

<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.draggable.min.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.position.min.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.resizable.min.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.dialog.min.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.datepicker-it.js"></script>
<script type="text/javascript" src="js/ui/jquery.ui.button.min.js"></script>

<!--<script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.12.1/jquery-ui.js"></script>-->

<script type="text/javascript" src="js/ui/ui.selectmenu.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.mini.js"></script>
<script type="text/javascript" src="js/jquery.number_format.js"></script>
<script type="text/javascript" src="js/jquery.jeditable-1.6.1.js"></script>

<link href="js/select2/css/select2.min.css" rel="stylesheet" />
<script src="js/select2/js/select2.min.js"></script>

<script type="text/javascript">
    var $j = jQuery.noConflict();
</script>

<script type="text/javascript" src="js/jquery.jeditable.datepicker.js"></script>
<script language="JavaScript" type="text/javascript" src="js/ajax.js"></script>
<script language="JavaScript" type="text/javascript" src="js/pm.js"></script>
<script language="JavaScript" type="text/javascript" src="js/calendar.js"></script>
<script language="JavaScript" type="text/javascript" src="js/calendar-it.js"></script>
<!-- HTML-->
<style>
    @import "layout.css";

    input {
        width: 50%;
        color: black;
    }

    select {
        width: 50%;
    }
</style>

<head>
    <link rel="stylesheet" href="fontawesome-free-5.8.1-web/css/all.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Casa di Bombo</title>
</head>

<body>

    <div class="wrapper">
        <div class="section">
            <div class="top_navbar">
                <div class="hamburger">
                    <a>
                        <i id="showIcon" class="fas fa-caret-left"></i>
                        <span id="showText"></span>
                    </a>
                </div>

            </div>
        </div>
        <div class="sidebar" style="overflow:auto;">
            <!-- Title -->
            <div class="profile">
                <a href="Profile.php">
                    <img src="img/profile.png" width="30%"></img></a>
                <h3> ORGANIZZA EVENTO </h3>
                <p> woof woof </p>
            </div>

            <ul>
                <li>
                    <a href="HomePage.php">
                        <i class="fas fa-home"></i> HOMEPAGE
                    </a>
                </li>
                <li>
                    <a href="Calendar.php">
                        <i class="fas fa-home"></i> CALENDARIO
                    </a>
                </li>
                <li>
                    <a style="color: blueviolet">
                        <i class="fas fa-home"></i> ORGANIZZA EVENTO
                    </a>
                </li>
                <?php
                if($admin == 1){
                    echo ('<li><a href="Rooms.php"> <i class="fas fa-home"></i> VISUALIZZA STANZE </a></li>');
                }
                ?>
            </ul>


            <div id="footer" class="footer">
                <p class="indirizzo">

                    Indirizzo<br />
                    Paese<br />
                    Telefono<br />
                    Fax</p>

                <p class="indirizzo"></p>
            </div>
        </div>

        <div id="content" class="outer">
            <div id="result" class="scroll">
                <form id="form">

                    <label for="name"><b>Nome</b></label>
                    <input type="text" placeholder="descrizione" name="nome" required>

                    <label for="data"><b>Data</b></label>
                    <input type="date" placeholder="data" name="data" required>

                    <label for="time"><b>Ora</b></label>
                    <input type="time" placeholder="ora" name="time" required>

                    <label for="durata"><b>Durata</b></label>
                    <input name="durata" type="range" min="1" max="12"
                        oninput="this.nextElementSibling.value = this.value" required> <output>7</output> ore <br>

                    <label for="partecipanti"><b>Max. Partecipanti</b></label>
                    <input type="text" placeholder="partecipanti" name="partecipanti" required>

                    <label for="public"><b>Visibilità</b></label>
                    <input type="radio" id="publlico" name="public" value="0">
                    <label for="pubblico">PUBBLICO</label><br>
                    <input type="radio" id="privato" name="public" value="1">
                    <label for="privato">PRIVATO</label><br>

                    <label for="tipo"><b>Tipologia</b></label>
                    <select name="tipo" id="tipologia">
                        <option value="All"> GENERICO </option>
                    </select>

                    <label for="luogo"><b>Spazio</b></label>
                    <input type="radio" id="aperto" name="luogo" value="1">
                    <label for="aperto">APERTO</label><br>
                    <input type="radio" id="chiuso" name="luogo" value="0">
                    <label for="chiuso">CHIUSO</label><br>

                    <b>Infrastrutture:</b><br>
                    <div id="infrastrutture">
                    </div>

                    <button type="button" onclick="newEvento()">Inserisci evento</button>

                </form>
            </div>
        </div>

        <!-- POP UP DI CONFERMA STANZA -->
        <div id="pickRoom" class="modal two" hidden>

        <div id="pickRoomForm" class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('pickRoom').style.display='none'" class="close"
                    title="Close Modal">&times;</span>
            </div>

            <div class="container">

                <div id ="recap">
                </div>

            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('pickRoom').style.display='none'"
                    class="cancelbtn">Annulla Prenotazione</button>
            </div>
        </div>
        </div>

</body>

<script language="JavaScript" type="text/javascript">

    var pickRoom = document.getElementById('pickRoom');

    $j(function () {
        getInfrastrutture();
        getTipologie();
    });

    var hamburger = document.querySelector(".hamburger");
    hamburger.addEventListener("click", function () {
        document.querySelector("body").classList.toggle("active");
        $j("#showIcon").toggleClass("fas fa-caret-left fas fa-caret-right");
        var text = $j('#showText').text();
        $j('#showText').text(text == "ORGANIZZA" ? "" : "ORGANIZZA");
    })

    function getInfrastrutture() {
        var param = 'info=2';

        $j.ajax({
            url: 'json/events.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    $j.each(response.elementi, function () {
                        $j("<input/>", { "type": "checkbox", "name": "INFR" + this.id }).appendTo($j("#infrastrutture"));
                        $j("<label/>", { "for": this.descr, "html": this.descr }).appendTo($j("#infrastrutture"));
                        $j("<br/>").appendTo($j("#infrastrutture"));
                    });
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function getTipologie() {
        var param = 'info=3';

        $j.ajax({
            url: 'json/events.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    $j("#tipologia").empty();
                    $j.each(response.elementi, function () {
                        $j("<option/>", { "value": this.id, "text": this.descr }).appendTo($j("#tipologia"));
                    });
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function newEvento() {
        <?php echo "var utente = '" . $user . "'" ?>;
        var param = 'info=4&uname=' + utente + '&';
        param += $j('#form').serialize()
        innertext = "";
        innerbutton = "";
        $j.ajax({
                url:'json/events.php', 
                cache:false,
                type:'post',
                dataType:'json',
                data: param,
                success:function(response) {
                if (response.result=='ok') {
                    $j.each(response.elementi, function(){
                        pickRoom.style.display = "block";
                        innertext += "NOME: " + this.evento + " di " + this.utente + "<br>" ;
                        innertext += "AREA: " + this.area + " CAPIENZA: " + this.capienza ;
                        innertext += " TIPO: " + this.tipo + " COSTO : " + this.costo*(parseInt(this.pulizia)+parseInt(this.durata)) + " $ <br>";
                        innertext += " DATA: " + this.data + " ORA: " + this.time ;
                        innertext += " POSTI: " + this.posti ;
                        if (this.privacy == '0') innertext += " VISIBILITà: pubblico ";
                        else innertext += "VISIBILITà: privato ";
                        if (this.posizione == '0') innertext += " LUOGO: chiuso ";
                        else innertext += "LUOGO: aperto ";
                        innerbutton= "<button type='button' style='width:50%' onclick=\"pickStanza('"+this.evento+"','"+this.utente+"','"+this.id+"','"+this.data+"','"+this.time+"','"+this.durata+"','"+this.posti+"','"+this.privacy+"')\">Conferma</button>";
                    });
                    innertext += "INFR: ";
                    $j.each(response.infrastrutture, function(){
                        innertext +=  this.infr + ", ";
                    });
                    innertext += "<br>";
                    innertext += innerbutton;
                    $j('#recap').html(innertext);

                }
            },
            error:function(){
                alert("Could not find data");
            }
        });
    }

    function pickStanza(nome,utente,idstanza,data,ora,durata,posti,privacy){
        var param = 'info=5&';
        param += 'uname=' + utente + '&';
        param += 'nome=' + nome + '&';
        param += 'idstanza=' + idstanza + '&';
        param += 'data=' + data + '&';
        param += 'time=' + ora + '&';
        param += 'durata=' + durata + '&';
        param += 'partecipanti=' + posti + '&';
        param += 'public=' + privacy ;

        $j.ajax({
                url:'json/events.php', 
                cache:false,
                type:'post',
                dataType:'json',
                data: param,
                success:function(response) {
                if (response.result=='ok') {
                    alert("inserimento completato");
                }else{
                    alert(response.errore);
                }
            },
            error:function(){
                alert("Could not find data");
            }
        });
    }


    // AJAX

    var AJAXobj = new Array();
    var AJAXloader = new Array();

    function waitAJAX(ts) {
        var add = Number(arguments[1]) || 0;
        var pos = AJAXloader.indexOf(ts);
        if (add == 1 & pos < 0) {
            AJAXloader.push(ts);
        } else if (add == 0 & pos >= 0) {
            AJAXloader.splice(pos, 1);
        } else if (add == 1 & pos >= 0) {
            //do nothing 
        }
        if (add == 1 & AJAXloader.length == 1) {
            startTime = new Date().getTime();
        }
        if (AJAXloader.length > 0) {
            $j("#wait").show();
            //$show("waitsched");	
        } else {
            $j("#wait").hide();
            //$hide("waitsched");	

            endTime = new Date().getTime();
            window.status = "Execution time: " + (endTime - startTime);
        }
    }

    function Left(str, n) {
        if (n <= 0)
            return "";
        else if (n > String(str).length)
            return str;
        else
            return String(str).substring(0, n);
    }

    function Right(str, n) {
        if (n <= 0)
            return "";
        else if (n > String(str).length)
            return str;
        else {
            var iLen = String(str).length;
            return String(str).substring(iLen, iLen - n);
        }
    }

    function trim(stringToTrim) {
        return stringToTrim.replace(/^\s+|\s+$/g, "");
    }

    function hidewaitAJAX() {
        AJAXloader = [];
        $hide("waitsched");
        $j.each(AJAXobj, function () {
            this.abort();
        });
        AJAXobj = [];
    }

</script>

</html>