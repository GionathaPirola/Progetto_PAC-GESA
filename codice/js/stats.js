function apriExcel(){
	if ($("datai").value!='' & $("dataf").value!='') {
		var tipo=getTipo()=='1'?'3':'4';
		var opti="?tipo=" + tipo;
		opti+='&datai=' + getData(trim($("datai").value), 'ymd') 
		opti+='&dataf=' + getData(trim($("dataf").value), 'ymd') 	
		if ($("cdcli").value!='all' && $("cdcli").value!='') opti += '&cdcls='+trim($("cdcli").value);
		location.href='cl_stats_xls.php' + opti;
	}else{
		alert("Please select date first.");
	}
}


function around(numero,decimali) {
	var potenza = Math.pow(10,decimali);
	return Math.round(numero * potenza)/potenza;
}

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function formattaNumero(num, nDec){
	return addSeparatorsNF(num, '.', ',', '.', nDec)
}
function addSeparatorsNF(nStr, inD, outD, sep, nDec)
{
	decPos = '0000000000000000';
	nStr += '';
	var dpos = nStr.indexOf(inD);
	var nStrEnd = '';
	if (dpos != -1) {
		nStrEnd = outD + nStr.substring(dpos + 1, nStr.length);
		if (nDec>0 & nStrEnd.length<nDec+2) {
			nStrEnd=nStrEnd + decPos.substring(1, nDec + 2 - nStrEnd.length);
		}
		nStr = nStr.substring(0, dpos);
	}
	var rgx = /(\d+)(\d{3})/;
	if (sep!='') {
		while (rgx.test(nStr)) {
			nStr = nStr.replace(rgx, '$1' + sep + '$2');
		}
	}
	return nStr + nStrEnd;
}
function getData (stringa, tp) {
	if (tp=='ymd') {
		var espressione = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;	
		if (!espressione.test(stringa))
		{
	    	return stringa;
		}else{
			anno = parseInt(stringa.substring(6),10);
			mese = parseInt(stringa.substring(3, 5),10);
			giorno = parseInt(stringa.substring(0, 2),10);
		
			var data=new Date(anno, mese-1, giorno);
			if(data.getFullYear()==anno && data.getMonth()+1==mese && data.getDate()==giorno){
				return "" + stringa.substring(6) +"" + stringa.substring(3, 5) +""+ stringa.substring(0, 2)

			}else{
				return stringa
			}
		}
	} else {
			
			anno = parseInt(stringa.substring(0, 4),10);
			mese = parseInt(stringa.substring(4, 6),10);
			giorno = parseInt(stringa.substring(6, 8),10);
			var data=new Date(anno, mese-1, giorno);
			if(data.getFullYear()==anno && data.getMonth()+1==mese && data.getDate()==giorno){
				return stringa.substring(6, 8) + "/" + stringa.substring(4, 6)+"/"+stringa.substring(0, 4);
			}else{
				return stringa;
			}

	}	
}
function chgFilter(){
	if ($("datai").value!='' & $("dataf").value!='') {
		getResult('');
	}
}
function getCdcli() {
	ajaxGetRand('/json/jsclstat.cgi?tipo=S', myHandlerCdcli, "label_cli");
}
function myHandlerCdcli(content, txt) {
	var response = eval("(" + content + ")");
	if (response.result=='ok' | response.result=='0' | response.result=='00000 0' ){
		var Testo = '';
		for(i=0;i < response.elementi.length; i++) {
			Testo += '<option value="' + trim(response.elementi[i].cdcli) + '">' + Left(trim(response.elementi[i].rascl), 20) + '</option>';
		}
		Testo = '<option value="all">All customers</option>' + Testo;
		Testo = '<select onchange="chgFilter();" id="cdcli">' + Testo +'</select>';
		$sethtml(txt,Testo);
		$show("label_cli");
	} else {
		alert(response.result);
	}
}
function getResult() {
	
	if ($("datai").value!='' & $("dataf").value!='') {
		var tipo=getTipo();
		$show("wait");	
		//$hide("showresult");
		var opti="?tipo=" + tipo;
		opti+='&datai=' + getData(trim($("datai").value), 'ymd') 
		opti+='&dataf=' + getData(trim($("dataf").value), 'ymd') 	
		if ($("cdcli").value!='all' && $("cdcli").value!='') opti += '&cdcls='+trim($("cdcli").value);
		ajaxGetRand('/json/jsclstat.cgi' + opti, myHandler, "showresult", tipo);
	}else{
		alert("Please select date first.");
	}
}

function nascondi(riffo){
	Testo = '<tr id="cont'+ riffo + '" class="nascosto"><td>&nbsp;</td></tr>';
	
	els=$pid("cont"+riffo, "tr");
	//alert("cont"+riffo + ' ' + els.length);
	
	$setouthtml(els[0],Testo);
	
	
	for(var k=1;k < els.length; k++) {
		//alert(els[k]);
		$sethtml(els[k],'');
		$hide(els[k]);
	}
	$hide("of"+riffo);
	$show("on"+riffo);
}

function scopri(riffo){
		$show("wait");	
		$hide("cont"+riffo);
		var opti='?dummy=dummy';
		if (getTipo()=='1'){
			var tipo='2';
			opti+='&anno='+ riffo.substring(6, 10);
			opti+='&mese='+ riffo.substring(10);
		}else{
			var tipo='1';
			opti+='&anno='+ riffo.substring(6, 10);
			opti+='&rgme='+ riffo.substring(10);
		}
		opti+='&tipo='+tipo;
		opti+='&datai=' + getData(trim($("datai").value), 'ymd') 
		opti+='&dataf=' + getData(trim($("dataf").value), 'ymd') 
		opti+='&cdcls=' + riffo.substring(0, 6);

		//alert(opti);
		ajaxGetRand('/json/jsclstat.cgi' + opti, myHandler, "cont"+riffo, tipo);

		$hide("on"+riffo);
		$show("of"+riffo);
}


function myHandler(content, txt, tipo) {
	var Testo="";
	var cols=8;
	var response = eval("(" + content + ")");
	if (response.result=='ok' | response.result=='0' | response.result=='00000 0' ){
		if (Left(txt, 4)=='cont') {
			//Testo += '<table style="margin-left:0px">\n';
				i=0;
				for(j=0;j < response.stats[i].stats.length; j++) {
					if (tipo=='2') {
						riffo=response.stats[i].cdcls+response.stats[i].stats[j].anno+response.stats[i].stats[j].mese;
					}else if (tipo=='1') {
						riffo=response.stats[i].cdcls+response.stats[i].stats[j].anno+response.stats[i].stats[j].srgme;
					}
			
					Testo += '<tr id="cont'+ riffo + j + '">\n';	
					
					Testo += '<td>&nbsp;</td>\n';	
					if (tipo=='1') {
						Testo += '<td>' + response.stats[i].stats[j].anno + ' - ' +Calendar._MN[parseFloat(response.stats[i].stats[j].mese)-1] +'</td>\n';	
					}else if (tipo=='2') {
						Testo += '<td>' + response.stats[i].stats[j].dergm +'</td>\n';	
					}else{
						Testo += '<td>&nbsp;</td>\n';	
					}
					Testo += '<td class="R">' + formattaNumero(""+response.stats[i].stats[j].qtfat) +'</td>\n';	
					Testo += '<td class="R">' + formattaNumero(""+response.stats[i].stats[j].vlfat) +'</td>\n';	
					Testo += '<td class="R">' + formattaNumero(""+response.stats[i].stats[j].qtspe) +'</td>\n';	
					Testo += '<td class="R">' + formattaNumero(""+response.stats[i].stats[j].vlspe) +'</td>\n';	
					Testo += '<td class="R">' + formattaNumero(""+response.stats[i].stats[j].qtfatp) +'</td>\n';	
					Testo += '<td class="R">' + formattaNumero(""+response.stats[i].stats[j].vlfatp) +'</td>\n';	
					Testo += '</tr>\n';
				}
			//Testo += '</table>\n';
		}else{
			Testo += '<table style="margin-left:0px">\n';
			Testo += '<tr>\n';	
			Testo += '<td class="th">&nbsp;</td>\n';	
			if (tipo=='1') {
				Testo += '<td class="th">Month</td>\n';	
			}else if (tipo=='2') {
				Testo += '<td class="th">Group</td>\n';	
			}
	
			Testo += '<td class="th">Qty Turnover</td>\n';	
			Testo += '<td class="th">Value Turnover</td>\n';	
			Testo += '<td class="th">Delivered Qty</td>\n';	
			Testo += '<td class="th">Delivered Value</td>\n';	
			Testo += '<td class="th">Prev Qty Turnover</td>\n';	
			Testo += '<td class="th">Prev Value Turnover</td>\n';	
			Testo += '</tr>\n';								
			for(i=0;i < response.stats.length; i++) {

				Testo += '<tr><td colspan="'+cols+'"><h1>' + response.stats[i].cdclf +' '+response.stats[i].rascl+'</h1></td></tr>\n';	
				if (response.stats[i].cdclf!=response.stats[i].cdcls) {
					Testo += '<tr><td  colspan="'+cols+'"><h2>' + response.stats[i].cdcls +'</h2></td></tr>\n';	
				}
				var tqtfat=0;
				var tvlfat=0;
				var tqtspe=0;
				var tvlspe=0;
				var tqtfatp=0;
				var tvlfatp=0;
				for(j=0;j < response.stats[i].stats.length; j++) {
					if (tipo=='1') {
						riffo=response.stats[i].cdcls+response.stats[i].stats[j].anno+response.stats[i].stats[j].mese;
					}else if (tipo=='2') {
						riffo=response.stats[i].cdcls+response.stats[i].stats[j].anno+response.stats[i].stats[j].srgme;
					}
					Testo += '<tr>\n';	
					Testo += '<td>';
					Testo += '<a id="on' + riffo + '" href="javascript:scopri(\''+ riffo + '\');"  style="position:absolute;text-decoration:none"><img src="/images/show.png"/></a>';
					Testo += '<a id="of' + riffo + '" href="javascript:nascondi(\''+ riffo + '\');"  style="position:absolute;visibility:hidden;text-decoration:none"><img src="/images/hide.png"/></a>';
					Testo += '&nbsp; &nbsp;</td>\n';	
									
					if (tipo=='1') {
						Testo += '<td class="viewOnly">'+ response.stats[i].stats[j].anno + ' - '+ Calendar._MN[parseFloat(response.stats[i].stats[j].mese)-1] +'</td>\n';	
					}else if (tipo=='2') {
						Testo += '<td class="viewOnly">' + response.stats[i].stats[j].dergm +'</td>\n';	
					}else{
						Testo += '<td class="viewOnly">&nbsp;</td>\n';	
					}
							
					Testo += '<td class="viewOnlyR">' + formattaNumero(""+response.stats[i].stats[j].qtfat) +'</td>\n';	
					Testo += '<td class="viewOnlyR">' + formattaNumero(""+response.stats[i].stats[j].vlfat) +'</td>\n';	
					Testo += '<td class="viewOnlyR">' + formattaNumero(""+response.stats[i].stats[j].qtspe) +'</td>\n';	
					Testo += '<td class="viewOnlyR">' + formattaNumero(""+response.stats[i].stats[j].vlspe) +'</td>\n';	
					Testo += '<td class="viewOnlyR">' + formattaNumero(""+response.stats[i].stats[j].qtfatp) +'</td>\n';	
					Testo += '<td class="viewOnlyR">' + formattaNumero(""+response.stats[i].stats[j].vlfatp) +'</td>\n';	
					Testo += '</tr>\n';
					tqtfat+=response.stats[i].stats[j].qtfat;
					tvlfat+=response.stats[i].stats[j].vlfat;
					tqtspe+=response.stats[i].stats[j].qtspe;
					tvlspe+=response.stats[i].stats[j].vlspe;
					tqtfatp+=response.stats[i].stats[j].qtfatp;
					tvlfatp+=response.stats[i].stats[j].vlfatp;
					Testo += '<tr id="cont'+ riffo + '" class="nascosto"><td>&nbsp;</td></tr>';
					//Testo += '<tr>';	
					//Testo += '<td><div style="position:relative;visibility:hidden; background-color:#fff; border:1px solid grey;"></div></td>';
					//Testo += '<td colspan="' + (cols-1) + '"><div id="cont'+ riffo + '" style="position:relative;visibility:hidden; background-color:#fff; border:1px solid grey;"></div></td>\n';	
					//Testo += '<td colspan="' + (cols-1) + '"><div id="cont'+ riffo + '" style="position:relative;visibility:hidden; background-color:#fff; border:1px solid grey;"></div></td>\n';	
					//Testo += '</tr>\n';
				}
				Testo += '<tr>\n';	
				Testo += '<td class="viewOnly view10" colspan="2">Total</td>\n';	
				Testo += '<td class="viewOnlyR view10">' + formattaNumero(""+tqtfat.roundTo(2)) +'</td>\n';	
				Testo += '<td class="viewOnlyR view10">' + formattaNumero(""+tvlfat.roundTo(2)) +'</td>\n';	
				Testo += '<td class="viewOnlyR view10">' + formattaNumero(""+tqtspe.roundTo(2)) +'</td>\n';	
				Testo += '<td class="viewOnlyR view10">' + formattaNumero(""+tvlspe.roundTo(2)) +'</td>\n';	
				Testo += '<td class="viewOnlyR view10">' + formattaNumero(""+tqtfatp.roundTo(2)) +'</td>\n';	
				Testo += '<td class="viewOnlyR view10">' + formattaNumero(""+tvlfatp.roundTo(2)) +'</td>\n';	
				Testo += '</tr>\n';
			}
			Testo += '</table>\n';	
		}
	} else {
		Testo += 'non ci sono dati da visualizzare';
		Testo += response.result;
	}
	if (Left(txt, 4)=='cont') {
		$setouthtml(txt,Testo);
	}else{	
		$sethtml(txt,Testo);
	}
    $hide("wait");
	$show(txt);
}

function getTipo(){
	var d=document.myform.tipo;
	for (var h=0; h < d.length; h++) {
		if (d[h].checked==true){
			return d[h].value;
		}
	}
}

function init() {
	getCdcli();
}


window.onload = function () {init();}

function catcalc(cal) {
   //var date = new Date(cal.sel.value.substr(6,4), (cal.sel.value.substr(3,1)-1), cal.sel.value.substr(0,2) );
   //var time = date.getTime()
	
	var cal1 = document.getElementById("datai");
	var d1=new Date(cal1.value.substr(6,4), (cal1.value.substr(3,2)-1), cal1.value.substr(0,2));

	var cal2 = document.getElementById("dataf");
	var d2=new Date(cal2.value.substr(6,4), (cal2.value.substr(3,2)-1), cal2.value.substr(0,2));

	var t1=d1.getTime()
	var t2=d2.getTime()
	
	if (t1>t2) {
       		var date2 = new Date(t1);
       		cal2.value = date2.print("%d/%m/%Y");
   		
	}
}


function selected(cal, date) {
  cal.sel.value = date; 
  if (cal.dateClicked ) {
    	cal.callCloseHandler();
	}
}
function closeHandler(cal) {
  //catcalc(cal);
  chgFilter();
  cal.hide();
  
  _dynarch_popupCalendar = null;
}

function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    _dynarch_popupCalendar.hide();     
  } else {
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}



