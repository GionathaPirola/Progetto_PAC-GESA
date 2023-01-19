<?php
session_start();
$user=strtoupper($_SESSION['username']);
include 'json\db_connection.php';

$conn = OpenCon();

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
<style> @import "layout.css"; </style>
<head>
<link rel="stylesheet" href="fontawesome-free-5.8.1-web/css/all.css">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HOMEPAGE</title> 
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
                <h3> <?php echo $user ?></h3>
            </div>

            <ul>
                <li> 
                    <a style="color: rgb(228, 159, 21)">
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
                <p class="indirizzo">
			        <p>Powered By</p>
                    <p>Alessandro Colombo, Gionatha Pirola</p>
                <p class="indirizzo"></p>
            </div>
 	</div>

        <div id="content" class="outer">  
            <div id="result" class="scroll">
                <h1 style="color: rgb(255, 194, 14);font-size : 500%" >G.E.S.A</h1>
                <h3 style="color: rgb(228, 159, 21);">Gestione Eventi Stanze Attività</h3>

                <p >Benvenuti in G.E.S.A, il software per la gestione di eventi e prenotazioni stanze.</p>

                <p >&nbsp </p>
                <h2 style="color:  rgb(228, 159, 21);">COME FUNZIONA?</h2>
                <p > Tramite questa pagina web è possibile svolgere tre funzioni principali: </p>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp   1. Prenotare una stanza per un evento privato.</p>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp    2. Prenotare una stanza per un evento pubblico, a cui tutti gli iscritto alla vostra associazione potranno iscriversi.</p>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp    3. Iscriversi ad un evento della propria associazione.</p>
                <p>&nbsp </p>

                <h2 style="color:  rgb(228, 159, 21);">QUALI STANZE SONO PRESENTI?</h2>
                <p > Le stanze sono inserite dal gestore dell'edificio.</p>
                <p > Ogni stanza ha caratteristiche differenti, il software cercherà di assegnare la stanza pù adatta alle vostre esigenze.</p>

                <p >&nbsp </p>
                <h2 style="color:  rgb(228, 159, 21);">COSA SI PUÒ VISUALIZZARE?</h2>
                <P>É disponibile una visualizzazione del calendario dove sono inseriti sia gli eventi della proprio organizzazione, sia le stanze che si hanno prenotato per un evento privato. </P>
            </div>
    </div>

</body>

<script language="JavaScript" type="text/javascript"> 

    $j(function() {
    });

	var hamburger = document.querySelector(".hamburger");
    hamburger.addEventListener("click", function(){
        document.querySelector("body").classList.toggle("active");
        $j("#showIcon").toggleClass("fas fa-caret-left fas fa-caret-right");
    })


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
<style>
    p{
        color: white;
        line-height: 25px;
    }
</style>
</html>
