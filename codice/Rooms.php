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
<style> @import "layout.css";
.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
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
                <a href="Profile.html"> 
                <img src="img/profile.png" width="30%"></img></a>
                <h3> HOMEPAGE</h3>
                <p> woof woof </p>
            </div>

            <ul>
                <li> 
                    <a href="HomePage.html">
                        <i class="fas fa-home"></i> HOMEPAGE 
                    </a>
                </li>
                <li> 
                    <a href="Calendar.html">
                        <i class="fas fa-home"></i> CALENDARIO 
                    </a>
                </li>
                <li> 
                    <a href="Event.html">
                        <i class="fas fa-home"></i> ORGANIZZA EVENTO 
                    </a>
                </li>
                <li> 
                    <a style="color: blueviolet">
                        <i class="fas fa-home"></i> VISUALIZZA STANZE
                    </a>
                </li>
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
            <h3>ELENCO STANZE <button onclick="document.getElementById('newRoom').style.display='block'" > Nuova stanza</button> </h3>

            <div id="result" class="scroll">

            </div>
    </div>


    <!-- POP UP per INSERIRE UNA NUOVA STANZA -->
    <div id= "newRoom" class="modal two">
        
        <form id= "newRoomForm" class="modal-content animate" >
            <div class="imgcontainer">
            <span onclick="document.getElementById('newRoom').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="container">

            <label for="tipo"><b>Tipologia</b></label>
            <select id="tipologie" name="tipo"></select>

            <label for="area"><b>Area</b></label>
            <input type="number" placeholder="Inserisci area" name="area" required>

            <label for="capienza"><b>Capienza</b></label>
            <input type="number" placeholder="Max persone" name="capienza" required>

            <label for="pulizia"><b>Tempo pulizia</b></label>
            <input type="number" placeholder="tempo pulizia" name="pulizia" required>

            <label for="costo"><b>Costo orario</b></label>
            <input type="number" placeholder="Costo orario" name="costo" required>

            <label for="aperto">APERTO</label><input type="radio" id="aperto" name="posizione" value="1"><br>
            <label for="chiuso">CHIUSO</label><input type="radio" id="chiuso" name="posizione" value="0"><br>
            
                
            <button type="button" onclick="newStanza()">Insert</button>
            </div>

            <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('newRoom').style.display='none'" class="cancelbtn">Cancel</button>
            </div>
        </form>
    </div>

</body>

<script language="JavaScript" type="text/javascript"> 

    $j(function() {
        IDnewroom.style.display = "none";
        getTipologie();
    });

    var IDnewroom = document.getElementById('newRoom');

    window.onclick = function(event) {
        if (event.target == IDnewroom) {
            IDnewroom.style.display = "none";
        }
    }

	var hamburger = document.querySelector(".hamburger");
    hamburger.addEventListener("click", function(){
        document.querySelector("body").classList.toggle("active");
        $j("#showIcon").toggleClass("fas fa-caret-left fas fa-caret-right");
        var text = $j('#showText').text();
        $j('#showText').text( text == "STANZE" ? "" : "STANZE");
    })

    function getTipologie(){
        var param ='info=1';

        $j.ajax({
                url:'json/rooms.php', 
                cache:false,
                type:'post',
                dataType:'json',
                data: param,
                success:function(response) {
                if (response.result=='ok') {
                    $j("#tipologie").empty();
                    $j.each(response.elementi, function(){
                        $j("<option/>", {"value":this.id, "text":this.descr}).appendTo($j("#tipologie"));
                    });
                }
            },
            error:function(){
                alert("Could not find data");
            }
        });
    }

    function getStanze(){

    }

    function newStanza(){
        var param ='info=2&';
        param += $j('#newRoomForm').serialize()

        $j.ajax({
            url:'json/rooms.php', 
            cache:false,
            type:'post',
            dataType:'json',
            data: param,
                success:function(response) {
                if (response.result=='ok') {
                    alert("inserimento completato");
                    IDnewroom.style.display = "none";
                }else{
                    alert("inserimento fallito");
                    IDnewroom.style.display = "none";
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
