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

    input[type=text], select {
        width: 50%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="date"]{
        padding: 10px;
        border: none;
        outline: none;
        border-radius: 5px;
        width: 50%;
    }

    input[type="range"]{
        padding: 10px;
        border-radius: 5px;
        width: 50%;
    }
    
    label{
        color: rgb(228, 159, 21);
        font-size: 20px;
        margin-top: 10px;
        display: block;
    }

    select {
        width: 50%;
    }
   
   input[type="radio"]{
   }

   h3{
    font-size: 18px;
   }
</style>

<head>
    <link rel="stylesheet" href="fontawesome-free-5.8.1-web/css/all.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizzazione eventi</title>
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
                <h3> <?php echo $user ?> </h3>
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
                    <a style="color: rgb(228, 159, 21)">
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

                    <p>Powered By</p>
                    <p>Alessandro Colombo, Gionatha Pirola</p>

                <p class="indirizzo"></p>
            </div>
        </div>

        <div id="content" class="outer">
            <div id="result" class="scroll">
                <form id="form">

                    <label for="name"><b>Nome evento</b></label>
                    <input type="text" placeholder="Inserire nome dell'evento" name="nome" required>
                </br>
                    <label for="data"><b>Data</b></label>
                    <input type="date" placeholder="Data" name="data" required>

                    <label for="time"><b>Orario di inizio</b></label>
                    <select name="time" required>
                        <option value="08:00"> 8:00 </option>
                        <option value="09:00"> 9:00 </option>
                        <option value="10:00"> 10:00 </option>
                        <option value="11:00"> 11:00 </option>
                        <option value="12:00"> 12:00 </option>
                        <option value="13:00"> 13:00 </option>
                        <option value="14:00"> 14:00 </option>
                        <option value="15:00"> 15:00 </option>
                        <option value="16:00"> 16:00 </option>
                        <option value="17:00"> 17:00 </option>
                        <option value="18:00"> 18:00 </option>
                        <option value="19:00"> 19:00 </option>
                    </select>

                    <label for="durata"><b>Durata oraria</b></label>
                    <input name="durata" type="range"  min="1" max="12" 
                        oninput="this.nextElementSibling.value = this.value" required> <output style="font-size:17px;">7</output><br>

                    <label for="partecipanti"><b>Numero massimo di partecipanti</b></label>
                    <input type="text" placeholder="Inserire numero di partecipanti" name="partecipanti" required>

                    <label for="public"><b>Visibilità</b></label>
                    <h3 for="pubblico">PUBBLICO</h3><input type="radio" id="pubblico" name="public" value="0">
                    <h3 for="privato">PRIVATO<h3><input type="radio" id="privato" name="public" value="1">

                    <label for="asso"><b>Associazione</b></label>
                    <select name="asso" id="associazione" required>
                        <option value="All"> GENERICO </option>
                    </select>

                    <label for="tipo"><b>Tipologia</b></label>
                    <select name="tipo" id="tipologia" required>
                        <option value="All"> GENERICO </option>
                    </select>

                    <label for="luogo"><b>Posizione stanza</b></label>
                    
                    <h3 for="aperto">APERTA</h3><input type="radio" id="aperto" name="luogo" value="1">
                    <h3 for="chiuso">CHIUSA</h3><input type="radio" id="chiuso" name="luogo" value="0">

                    <label><b>Infrastrutture</b></label><br>
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

            </div>
        </div>
        </div>

</body>

<script language="JavaScript" type="text/javascript">

    var pickRoom = document.getElementById('pickRoom');

    var today = new Date();
    today.setDate(today.getDate() + 5);
    today = today.toISOString().split('T')[0];
    document.getElementsByName("data")[0].setAttribute('min', today);

    $j(function () {
        getInfrastrutture();
        getTipologie();
        getAssociazioni()
    });

    var hamburger = document.querySelector(".hamburger");
    hamburger.addEventListener("click", function () {
        document.querySelector("body").classList.toggle("active");
        $j("#showIcon").toggleClass("fas fa-caret-left fas fa-caret-right");
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
                        $j("<h3/>", { "for": this.descr, "html": this.descr }).appendTo($j("#infrastrutture"));
                        $j("<input/>", { "type": "checkbox", "name": "INFR" + this.id }).appendTo($j("#infrastrutture"));
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

    function getAssociazioni() {
        <?php echo "var utente = '" . $user . "'" ?>;
        var param = 'info=10&uname='+utente;

        $j.ajax({
            url: 'json/events.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    $j("#associazione").empty();
                    $j("<option/>", { "value": "", "text": "APERTO A TUTTI" }).appendTo($j("#associazione"));
                    $j.each(response.elementi, function () {
                        $j("<option/>", { "value": this.descr, "text": this.descr }).appendTo($j("#associazione"));
                    });
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function newEvento() {
        //ORARIO
        var time = $j('select[name=time] option').filter(':selected').val().split(":");
        var hour = parseInt(time[0]);
        var minute = parseInt(time[1]);
        var long = parseInt($j("input[name=durata]").val());
        //DATA
        if(hour < 8 || (hour + long) > 20 ){
            alert("Gli eventi devono iniziare e terminare tra le 8.00 e terminare per le 20.00");
        }else{
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
                            innertext += "AREA: " + this.area + " <br>CAPIENZA: " + this.capienza ;
                            innertext += " <br>TIPO: " + this.tipo + "<br>COSTO : " + this.costo*(parseInt(this.pulizia)+parseInt(this.durata)) + " $ <br>";
                            innertext += " DATA: " + this.data + " " + this.time ;
                            innertext += " <br>POSTI: " + this.posti ;
                            if (this.privacy == '0') innertext += "<br>VISIBILITA': pubblico ";
                            else innertext += " <br>VISIBILITA': privato ";
                            if (this.posizione == '0') innertext += "<br>LUOGO: chiuso ";
                            else innertext += "<br>LUOGO: aperto ";
                            innerbutton= "<button type='button' style='width:50%' onclick=\"pickStanza('"+this.evento+"','"+this.utente+"','"+this.id+"','"+this.data+"','"+this.time+"','"+this.durata+"','"+this.posti+"','"+this.privacy+"','"+this.asso+"')\">Conferma</button>";
                            bestbutton= "<button type='button' style='width:50%' onclick=\"bestStanza()\">Mostra Stanza Migliore</button>";

                        });
                        innertext += "<br>INFR: ";
                        $j.each(response.infrastrutture, function(){
                            innertext +=  this.infr + "  ";
                        });
                        innertext += "<br>";
                        innertext += innerbutton;
                        innertext += bestbutton;
                        $j('#recap').html(innertext);

                    }else{
                        pickRoom.style.display = "block";
                        innertext += "NESSUNA STANZA ADATTA TROVATA PER QUESTO ORARIO<br>" ;
                        bestbutton= "<button type='button' style='width:50%' onclick=\"bestStanza()\">Mostra Stanza Migliore</button>";
                        innertext += bestbutton;
                        $j('#recap').html(innertext);
                    }
                },
                error:function(){
                    alert("Could not find data");
                }
            });
        }
    }

    function bestStanza(){
        <?php echo "var utente = '" . $user . "'" ?>;
        var param = 'info=6&uname=' + utente + '&';
        param += $j('#form').serialize()
        $j.ajax({
                url:'json/events.php', 
                cache:false,
                type:'post',
                dataType:'json',
                data: param,
                success:function(response) {
                if (response.result=='ok') {
                    $j('#recap').empty();
                    innertext = "";
                    $j.each(response.elementi, function(){
                        pickRoom.style.display = "block";
                        innertext += "<b style='color:blue'>STANZA MIGLIORE</b> <br>" ;
                        innertext += "NOME: " + this.evento + " di " + this.utente + "<br>" ;
                        innertext += "AREA: " + this.area + " <br>CAPIENZA: " + this.capienza ;
                        innertext += " <br>TIPO: " + this.tipo + " <br>COSTO : " + this.costo*(parseInt(this.pulizia)+parseInt(this.durata)) + " $ <br>";
                        innertext += " DATA: " + this.beststart.substring(0,4) + "-" + this.beststart.substring(4,6) + "-" + this.beststart.substring(6,8);
                        innertext += " " + this.beststart.substring(8,10) + ":" + this.beststart.substring(10,12) ;
                        innertext += "<br>POSTI: " + this.posti ;
                        if (this.privacy == '0') innertext += " <br>VISIBILITA': pubblico ";
                        else innertext += " <br>VISIBILITA': privato ";
                        if (this.posizione == '0') innertext += " <br>LUOGO: chiuso ";
                        else innertext += "<br>LUOGO: aperto ";
                        dataTMP =  this.beststart.substring(0,4) + "-" + this.beststart.substring(4,6) + "-" + this.beststart.substring(6,8);
                        oraTMP = this.beststart.substring(8,10) + ":" + this.beststart.substring(10,12) ;
                        innerbutton= "<button type='button' style='width:50%' onclick=\"pickStanza('"+this.evento+"','"+this.utente+"','"+this.id+"','"+dataTMP+"','"+oraTMP+"','"+this.durata+"','"+this.posti+"','"+this.privacy+"','"+this.asso+"')\">Conferma</button>";
                    });
                    innertext += "<br>INFR: ";
                    $j.each(response.infrastrutture, function(){
                        innertext +=  this.infr + "  ";
                    });
                    innertext += "<br>";
                    innertext += innerbutton;
                    $j('#recap').html(innertext);

                }else{
                    alert("nessuna stanza trovata con le caratteristiche richieste");
                }
            },
            error:function(){
                alert("Could not find data");
            }
        });
    }

    function pickStanza(nome,utente,idstanza,data,ora,durata,posti,privacy,asso){
        var param = 'info=5&';
        param += 'uname=' + utente + '&';
        param += 'nome=' + nome + '&';
        param += 'idstanza=' + idstanza + '&';
        param += 'data=' + data + '&';
        param += 'time=' + ora + '&';
        param += 'durata=' + durata + '&';
        param += 'partecipanti=' + posti + '&';
        param += 'public=' + privacy + '&' ;
        param += 'asso=' + asso ;

        $j.ajax({
                url:'json/events.php', 
                cache:false,
                type:'post',
                dataType:'json',
                data: param,
                success:function(response) {
                if (response.result=='ok') {
                    alert("inserimento completato");
                    location.reload(); 
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

    function formatData(data){
        anno = data.substr(0,4);
        mese = data.substr(4,2);
        giorno= data.substr(6,2);
        ora = data.substr(8,2);
        return giorno + "/" + mese + "/" + anno + " "+ ora + ":00";
    }


</script>

</html>