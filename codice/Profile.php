<?php
session_start();
$user=strtoupper($_SESSION['username']);

include 'json\db_connection.php';

$conn = OpenCon();

$admin = isAdmin();

$events = getEvents();

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

function getEvents()
{
    global $conn, $user, $admin;
    $val = array();

    //seleziona -> stesso organizzatore o -> stessa associazione,pubbliche
    $sql = "SELECT distinct id as ID, descr as DESCR, private as PRIVATE, stanza as STANZA, organizz as ORGANIZZ, data as DATA, durata as DURATA, iscritti as ISCRITTI
            FROM eventi A left join pubblico B on B.evento = A.id
            WHERE  (A.organizz = '" . $user . "') or (B.utente = '" . $user . "') ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $val[] = array(
            'rows' => $result->num_rows
        );

        while ($row = $result->fetch_assoc()) {

            $val[] = array(
                'id' => $row['ID'],
                'descr' => $row['DESCR'],
                'private' => $row['PRIVATE'],
                'stanza' => $row['STANZA'],
                'organizz' => $row['ORGANIZZ'],
                'data' => $row['DATA'],
                'durata' => $row['DURATA'],
                'iscritti' => $row['ISCRITTI']
            );

        }
    }

    CloseCon($conn);

    return $val;

}
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

 .associazione:hover{
    color: rgb(170, 55, 55) !important;
    cursor: pointer;
 }

 td {

    vertical-align: middle;
    text-align: center;
    border-color: white;
 }

 .thD{
    padding: 10px;
    color : white;
    border: 2px solid white; 
 }

 .thD2{
    padding: 2px;
    border-radius: 20px;
    border: 2px solid white;
    color:black;
    font-weight:bold; 
    background-color: white;
 }
 
 </style>
<head>
<link rel="stylesheet" href="fontawesome-free-5.8.1-web/css/all.css">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profilo</title> 
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
                <img src="img/profile.png" width="30%"></img>
                <h3><?php echo $user ?> </h3>
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
                    <a href="Event.php">
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
			<p>Powered By</p>
            <p>Alessandro Colombo, Gionatha Pirola</p>

        </div>
 	</div>

    <div id="content" class="outer">  
        <?php
        if ($admin == 1) {
            echo ( " <button onclick=\"document.getElementById('newAssociazione').style.display='block'\" style=\"width:20%\"> Nuova associazione </button> ");
        }else{
            echo ( " <button onclick=\"document.getElementById('subAssociazione').style.display='block'\" style=\"width:20%\"> Iscriviti ad associazione </button> ");
        }
        ?>
            <div id="result" class="scroll">
                <div id="rnome"> </div>
                <div id="rmail"> </div>
                <div id="rasso"> </div>
            </div>
            <div id="eventsResult" class="scroll">

            </div>
    </div>
        <!-- POP UP per VEDERE GLI ISCRITTI -->
    <div id="iscrittiAll" class="modal two" hidden>

    <form id="iscrittiAllForm" class="modal-content animate">
    <div class="imgcontainer">
        <span onclick="document.getElementById('iscrittiAll').style.display='none'" class="close"
            title="Close Modal">&times;</span>
    </div>
    <div class="container">
        <div id="iscrittiResult"></div>
    </form>
    </div>
    </div>
    
    <!-- POP UP per INSERIRE UNA NUOVA ASSOCIAZIONE -->
    <div id="newAssociazione" class="modal two" hidden>
    <form id="newAssoForm" class="modal-content animate">
    <div class="imgcontainer">
        <span onclick="document.getElementById('newAssociazione').style.display='none'" class="close"
            title="Close Modal">&times;</span>
    </div>
    <div class="container">
        <div id="allasso"></div>
        <label for="newasso"><b>Nuova associazione</b></label>
                <input type="text" placeholder="Inserire Associazione" name="newasso" required>
        <label for="pswnew"><b>Password associazione</b></label>
                <input type="text" placeholder="Inserire Password" name="pswnew" required>
        <button type="button" onclick="newAssociazione()">Inserisci Associazione</button>
    </form>
    </div>
    </div>

    <!-- POP UP per ISCRIVERSI AD UNA NUOVA ASSOCIAZIONE -->
    <div id="subAssociazione" class="modal two" hidden>
    <form id="subAssoForm" class="modal-content animate">
    <div class="imgcontainer">
        <span onclick="document.getElementById('subAssociazione').style.display='none'" class="close"
            title="Close Modal">&times;</span>
    </div>
    <div class="container">
        <div id="subasso"></div>
        <label for="subasso"><b>Iscriviti ad associazione</b></label>
                <input type="text" placeholder="Inserire Associazione" name="subasso" required>
        <label for="pswasso"><b>Password associazione</b></label>
                <input type="text" placeholder="Inserire Password" name="pswasso" required>
        <button type="button" onclick="subAssociazione()">Inserisci Associazione</button>
    </form>
    </div>
    </div>
</body>

<script language="JavaScript" type="text/javascript"> 

    var jArray = <?php echo json_encode($events); ?>;
    var utenteSessh = <?php echo "'".$user."'"; ?>;

    $j(function() {
        getUserInfo();
        printEvents();
    });

	var hamburger = document.querySelector(".hamburger");
    
    hamburger.addEventListener("click", function(){
        document.querySelector("body").classList.toggle("active");
        $j("#showIcon").toggleClass("fas fa-caret-left fas fa-caret-right");
        var text = $j('#showText').text();
    })

    function newAssociazione(){
        var param = 'info=2&';
        param += "asso=" +$j("input[name='newasso']").val();
        param += "&psw=" +$j("input[name='pswnew']").val();
        
        $j.ajax({
            url: 'json/user.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    alert("inserimento completato");
                } else {
                    alert("inserimento fallito");
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function subAssociazione(){
        var param = 'info=3&';
        param += "asso=" +$j("input[name='subasso']").val();
        <?php echo "var utente = '" . $user . "'" ?>;
        param += '&uname=' + utente ;
        param += "&psw=" +$j("input[name='pswasso']").val();
        
        $j.ajax({
            url: 'json/user.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    alert("inserimento completato");
                    location.reload(); 
                } else {
                    alert("inserimento fallito");
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function printEvents(){
        <?php echo "var utente = '" . $user . "'" ?>;
        $j('#eventsResult').empty();
        var table=$j("<table/>", {"id":"tabella"});
        table.appendTo($j("#eventsResult"));
        var row = $j("<tr/>", { "class":"thR"}).appendTo(table); 
        $j("<td/>", { "html":"DESCRIZIONE", "class":"thD" }).appendTo(row);
        $j("<td/>", { "html":"ORGANIZZATORE", "class":"thD" }).appendTo(row);
        $j("<td/>", { "html":"DATA", "class":"thD" }).appendTo(row);
        $j("<td/>", { "html":"DURATA", "class":"thD" }).appendTo(row);
        $j("<td/>", { "html":"N. MAX ISCRITTI", "class":"thD" }).appendTo(row);
        $j("<td/>", { "html":"VISIBILITA'", "class":"thD" }).appendTo(row);
        if(jArray[0]!=null){
            for (var j = 1; j <= jArray[0].rows; j++) {
                row = $j("<tr/>", { "class":"thR"}).appendTo(table); 
                $j("<td/>", { "html":jArray[j].descr , "class":"thD2" }).appendTo(row);
                $j("<td/>", { "html":jArray[j].organizz , "class":"thD2" }).appendTo(row);
                $j("<td/>", { "class":"thD2" ,"html":jArray[j].data.substr(6,2) + "/" + jArray[j].data.substr(4,2)+ "/"+jArray[j].data.substr(0,4)+" "+jArray[j].data.substr(8,2)+":"+jArray[j].data.substr(10,2) }).appendTo(row);
                $j("<td/>", { "class":"thD2" ,"html":jArray[j].durata + " ore"}).appendTo(row);
                if(trim(utente) == trim(jArray[j].organizz)) $j("<td/>", {  "class":"thD2" ,"html":jArray[j].iscritti, "style":"cursor:pointer","onclick":"getIscritti("+jArray[j].id+")" }).appendTo(row);
                else $j("<td/>", {  "class":"thD2" ,"html":jArray[j].iscritti }).appendTo(row);
                if (jArray[j].private == 1) $j("<td/>", {  "class":"thD2" ,"html":"privato" }).appendTo(row);
                else $j("<td/>", {  "class":"thD2" ,"html":"pubblico" }).appendTo(row);
                if(trim(utente) == trim(jArray[j].organizz)){
                    $j("<td/>", {  "html":"<button onclick=deleteEvento("+jArray[j].id+")> Elimina </button>" }).appendTo(row);
                }else{
                    $j("<td/>", {  "html":"<button onclick=disiscriviEvento("+jArray[j].id+",'"+trim(utente)+"')> disiscriviti </button>" }).appendTo(row);
                }
            }            
        }
    }

    function getIscritti(id){
        var param = 'info=9&idEvento=' + id;

        $j.ajax({
            url: 'json/events.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                $j('#iscrittiResult').empty();
                if (response.result == 'ok') {
                    document.getElementById('iscrittiAll').style.display='block';
                    var table=$j("<table/>", {"id":"tabellaIscritti"});
                    table.appendTo($j("#iscrittiResult"));
                    var row = $j("<tr/>", { "class":"thR"}).appendTo(table);
                    $j.each(response.elementi, function(){
                        $j("<td/>", { "html":this.nome }).appendTo(row);
                    });
                } else {
                    alert(response.errore);
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function disiscriviEvento(evento,utente){
        var param = 'info=8&idEvento=' + evento + '&uname=' + utente;

        $j.ajax({
            url: 'json/events.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    alert("disiscrizione completata");
                    location.reload(); 
                } else {
                    alert(response.errore);
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function deleteEvento(id){
        var param = 'info=7&idEvento=' + id;

        $j.ajax({
            url: 'json/events.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    alert("eliminazione completata");
                    location.reload(); 
                } else {
                    alert(response.errore);
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function desub(asso){
        <?php echo "var utente = '".$user."'" ?>;
        var param ='info=4&uname='+ utente ; 
        param +='&asso='+ asso ;  
        
        let text = "Vuoi disiscriverti da " + asso + " ?";
        if (confirm(text) == true) {
            $j.ajax({
                url: 'json/user.php',
                cache: false,
                type: 'post',
                dataType: 'json',
                data: param,
                success: function (response) {
                    if (response.result == 'ok') {
                        alert("disicrizione completata");
                        location.reload(); 
                    } else {
                        alert(response.errore);
                    }
                },
                error: function () {
                    alert("Could not find data");
                }
            });
        }
    }

    function getUserInfo(){
        <?php echo "var utente = '".$user."'" ?>;
        var param ='info=1&uname='+ utente ;

        var textAsso = "";
        $j.ajax({
            url:'json/user.php', 
            cache:false,
            type:'post',
            dataType:'json',
            data: param,
            success:function(response) {
                if (response.result=='ok') {
                    $j.each(response.elementi, function(){
                        $j('#rnome').html("<h3>NOME:<cc style='color:white'> "+this.username+" </cc></h3>");
                        $j('#rnome').css('color', 'rgb(255, 194, 14)');
                        $j('#rmail').html("<h3>EMAIL: <cc style='color:white'>"+this.mail+" </cc></h3>");
                        $j('#rmail').css('color', 'rgb(255, 194, 14)');

                    });
                    $j.each(response.associazioni, function(){
                        textAsso += "<i style='color:white' class='associazione' onclick='desub(\""+ this.associazione +"\")'>" + this.associazione + "</i> | ";
                    });
                    textAsso = textAsso.slice(0, -2); 
                    $j('#rasso').html("<h3>ASSOCIAZIONE: "+textAsso+"</h3>");
                    $j('#rasso').css('color', 'rgb(255, 194, 14)');
                }else{
                    alert(response.error);
                }
            },
            error:function(){
                alert("Could not find data");
            }
        });
    }


    // AJAX
        
    var AJAXobj=new Array();
    var AJAXloader=new Array();

    function waitAJAX(ts){
        var add=Number(arguments[1]) || 0;
        var pos=AJAXloader.indexOf(ts);
        if (add==1 & pos<0){
            AJAXloader.push(ts);
        } else if (add==0 & pos>=0){
            AJAXloader.splice(pos,1);
        } else if(add==1 & pos>=0) {
            //do nothing 
        }
        if (add==1 & AJAXloader.length==1){
            startTime = new Date().getTime();
        }
        if (AJAXloader.length>0){
            $j("#wait").show();
            //$show("waitsched");	
        }else{
            $j("#wait").hide();
            //$hide("waitsched");	
                    
            endTime = new Date().getTime();
            window.status = "Execution time: " + (endTime - startTime);
        }
    }

    function Left(str, n){
        if (n <= 0)
            return "";
        else if (n > String(str).length)
            return str;
        else
            return String(str).substring(0,n);
    }

    function Right(str, n){
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
        return stringToTrim.replace(/^\s+|\s+$/g,"");
    }

    function hidewaitAJAX(){
        AJAXloader=[];
        $hide("waitsched");	
        $j.each(AJAXobj, function(){
            this.abort();
        });
        AJAXobj=[];
    }
	
</script>
</html>
