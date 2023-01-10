<?php
session_start();
$user = strtoupper($_SESSION['username']);
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
                <h3> HOMEPAGE</h3>
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
                    <a href="Event.php">
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
            <h3>ELENCO STANZE <br>
                <button onclick="document.getElementById('newRoom').style.display='block'" style="width:20%"> Nuova stanza</button> 
                <button onclick="document.getElementById('newInfr').style.display='block'" style="width:20%"> Nuova infrastruttura </button> 
                <button onclick="document.getElementById('newTipo').style.display='block'" style="width:20%"> Nuova tipologia stanza</button> </h3>

            <div id="result" class="scroll">

            </div>
        </div>

        <!-- POP UP per INSERIRE UNA NUOVA INFRASTRUTTURA -->
        <div id="newInfr" class="modal two" hidden>
        <form id="newInfrForm" class="modal-content animate">
            <div id="allinfr"></div>
            <label for="newinfr"><b>Nuova infrastruttura</b></label>
                    <input type="text" placeholder="Inserire infrastruttura" name="newinfr" required>
            <button type="button" onclick="document.getElementById('newInfr').style.display='none'"
                        class="cancelbtn">Cancel</button>
            <button type="button" onclick="newInfr()">Inserisci infrastruttura</button>
        </form>
        </div>

        <!-- POP UP per INSERIRE UNA NUOVA TIPOLOGIA DI STANZA -->
        <div id="newTipo" class="modal two" hidden>
        <form id="newTipoForm" class="modal-content animate">
            <div id="alltipo"></div>
            <label for="newtype"><b>Nuova tipologia</b></label>
                    <input type="text" placeholder="Inserire tipologia" name="newtype" required>
            <button type="button" onclick="document.getElementById('newTipo').style.display='none'"
                        class="cancelbtn">Cancel</button>
            <button type="button" onclick="newTipo()">Inserisci tipologia</button>
        </form>
        </div>

        <!-- POP UP per INSERIRE UNA NUOVA STANZA -->
        <div id="newRoom" class="modal two" hidden>

            <form id="newRoomForm" class="modal-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('newRoom').style.display='none'" class="close"
                        title="Close Modal">&times;</span>
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

                    <label><b>Infrastrutture</b></label><br>
                    <div id="infrastrutture">
                    </div>

                    <button type="button" onclick="newStanza()">Insert</button>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('newRoom').style.display='none'"
                        class="cancelbtn">Cancel</button>
                </div>
            </form>
        </div>

        <!-- POP UP per MODIFICARE UNA STANZA -->
        <div id="editRoom" class="modal two" hidden>

            <form id="editRoomForm" class="modal-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('editRoom').style.display='none'" class="close"
                        title="Close Modal">&times;</span>
                </div>

                <div class="container">

                    <label for="id"><b>ID</b></label>
                    <input id="idE" type="number" name="id" value="0" readonly>

                    <label for="tipo"><b>Tipologia</b></label>
                    <select id="tipologieE" name="tipo"></select>

                    <label for="area"><b>Area</b></label>
                    <input id="areaE" type="number" placeholder="Inserisci area" name="area" required>

                    <label for="capienza"><b>Capienza</b></label>
                    <input id="capienzaE" type="number" placeholder="Max persone" name="capienza" required>

                    <label for="pulizia"><b>Tempo pulizia</b></label>
                    <input id="puliziaE" type="number" placeholder="tempo pulizia" name="pulizia" required>

                    <label for="costo"><b>Costo orario</b></label>
                    <input id="costoE" type="number" placeholder="Costo orario" name="costo" required>

                    <label for="aperto">APERTO</label><input type="radio" id="apertoE" name="posizione" value="1"><br>
                    <label for="chiuso">CHIUSO</label><input type="radio" id="chiusoE" name="posizione" value="0"><br>

                    <label for="disp">DISPONIBILE</label><input type="radio" id="dispE" name="status" value="1"><br>
                    <label for="blocked">NON DISPONIBILE</label><input type="radio" id="blockedE" name="status"
                        value="0"><br>

                    <button type="button" onclick="editStanza()">Update</button>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('editRoom').style.display='none'"
                        class="cancelbtn">Cancel</button>
                </div>
            </form>
        </div>

</body>

<script language="JavaScript" type="text/javascript">

    $j(function () {
        IDnewroom.style.display = "none";
        getInfrastrutture();
        getTipologie();
        getStanze();
    });

    var IDnewroom = document.getElementById('newRoom');
    var IDeditroom = document.getElementById('editRoom');

    window.onclick = function (event) {
        if (event.target == IDnewroom) {
            IDnewroom.style.display = "none";
        }
        if (event.target == IDeditroom) {
            IDeditroom.style.display = "none";
        }
    }

    var hamburger = document.querySelector(".hamburger");
    hamburger.addEventListener("click", function () {
        document.querySelector("body").classList.toggle("active");
        $j("#showIcon").toggleClass("fas fa-caret-left fas fa-caret-right");
        var text = $j('#showText').text();
        $j('#showText').text(text == "STANZE" ? "" : "STANZE");
    })

    function getInfrastrutture() {
        var param = 'info=5';

        $j.ajax({
            url: 'json/rooms.php',
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

    function newInfr(){
        var param = 'info=6&';
        param += "infr=" +$j("input[name='newinfr']").val();
        
        $j.ajax({
            url: 'json/rooms.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    alert("inserimento completato");
                    getInfrastrutture();
                } else {
                    alert("inserimento fallito");
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function newTipo(){
        var param = 'info=7&';
        param += "tipo=" + $j("input[name='newtype']").val();

        $j.ajax({
            url: 'json/rooms.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    alert("inserimento completato");
                    getTipologie();
                } else {
                    alert("inserimento fallito");
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function getTipologie() {
        var param = 'info=1';

        $j.ajax({
            url: 'json/rooms.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    $j("#tipologie").empty();
                    $j("#tipologieE").empty();
                    $j.each(response.elementi, function () {
                        $j("<option/>", { "value": this.id, "text": this.descr }).appendTo($j("#tipologie"));
                        $j("<option/>", { "value": this.id, "text": this.descr }).appendTo($j("#tipologieE"));
                    });
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function getStanze() {
        var param = 'info=3';

        $j.ajax({
            url: 'json/rooms.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    $j('#result').empty();
                    var table = $j("<table/>", { "id": "tabella" });
                    table.appendTo($j("#result"));
                    var row = "";

                    $j.each(response.elementi, function () {
                        row = $j("<tr/>").appendTo(table);
                        $j("<button/>", { "html": "EDIT", "onclick": "edit(" + this.id + "," + this.area + "," + this.capienza + ",'" + this.tipoID + "'," + this.posizione + "," + this.pulizia + "," + this.costo + "," + this.status + ")" }).appendTo(row);
                        $j("<td/>", { "html": "ID: " + this.id + "; " }).appendTo(row);
                        $j("<td/>", { "html": "AREA: " + this.area + "; " }).appendTo(row);
                        $j("<td/>", { "html": "CAPIENZA: " + this.capienza + "; " }).appendTo(row);
                        $j("<td/>", { "html": "TIPO: " + this.tipo + "; " }).appendTo(row);
                        if (this.posizione == 0) {
                            $j("<td/>", { "html": "POSIZIONE: chiuso; " }).appendTo(row);
                        } else {
                            $j("<td/>", { "html": "POSIZIONE: aperto; " }).appendTo(row);
                        }
                        $j("<td/>", { "html": "PULIZIA: " + this.pulizia + "; " }).appendTo(row);
                        $j("<td/>", { "html": "COSTO: " + this.costo + "; " }).appendTo(row);
                        if (this.status == 0) {
                            $j("<td/>", { "html": "STATUS: NON DISPONIBILE; " }).appendTo(row);
                        } else {
                            $j("<td/>", { "html": "STATUS: DISPONIBILE; " }).appendTo(row);
                        }
                    });
                } else {
                    alert(response.msg);
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });
    }

    function edit(id, area, capienza, tipo, posizione, pulizia, costo, status) {
        IDeditroom.style.display = "block";
        $j('#idE').attr('value', id);
        $j('#areaE').attr('value', area);
        $j('#capienzaE').attr('value', capienza);
        $j('#tipologieE').attr('value', tipo);
        if (posizione == '0') $j('#chiusoE').attr('checked', "ischecked");
        else $j('#apertoE').attr('checked', "ischecked");
        $j('#puliziaE').attr('value', pulizia);
        $j('#costoE').attr('value', costo);
        if (status == '0') $j('#blockedE').attr('checked', "ischecked");
        else $j('#dispE').attr('checked', "ischecked");
    }

    function newStanza() {
        var param = 'info=2&';
        param += $j('#newRoomForm').serialize()

        $j.ajax({
            url: 'json/rooms.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    alert("inserimento completato");
                    IDnewroom.style.display = "none";
                    getStanze();
                } else {
                    alert("inserimento fallito");
                    IDnewroom.style.display = "none";
                }
            },
            error: function () {
                alert("Could not find data");
            }
        });

    }

    function editStanza() {
        var param = 'info=4&';
        param += $j('#editRoomForm').serialize()

        $j.ajax({
            url: 'json/rooms.php',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: param,
            success: function (response) {
                if (response.result == 'ok') {
                    alert("modifica completata");
                    IDeditroom.style.display = "none";
                    getStanze();
                } else {
                    alert("modifica fallita");
                    IDeditroom.style.display = "none";
                }
            },
            error: function () {
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