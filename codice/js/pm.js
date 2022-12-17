window.onerror = function(msg, url, line, col, error) {
   // Note that col & error are new to the HTML 5 spec and may not be 
   // supported in every browser.  It worked for me in Chrome.
   var extra = !col ? '' : '\ncolumn: ' + col;
   extra += !error ? '' : '\nerror: ' + error;

   // You can view the information in an alert to see things working like this:
   alert("Error: " + msg + "\nurl: " + url + "\nline: " + line + extra);

   // TODO: Report this error via ajax so you can keep track
   //       of what pages have JS issues

   var suppressErrorAlert = true;
   // If you return true, then error alerts (like in older versions of 
   // Internet Explorer) will be suppressed.
   return suppressErrorAlert;
};


function formatta(st, n){
	var stringa=trim(st);
	for (j=0;j<n;j++) {
		stringa = " " + stringa;
	}
	stringa=Right(stringa, n);
	return stringa;	
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
function isData(stringa) {
	var espressione = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;	
	if (!espressione.test(stringa))
	{
    	return false;
	}else{
		return true;
	}
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

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}

function roundTo(decimalpositions)
{
    var i = this * Math.pow(10,decimalpositions);
    i = Math.round(i);
    return i / Math.pow(10,decimalpositions);
}
Number.prototype.roundTo = roundTo; 


function numberFormat(nStr){
  nStr += '';
  nStr=nStr.replace(',','|');
  nStr=nStr.replace('.',',');
  nStr=nStr.replace('|','.');
  
  x = nStr.split(',');
  x1 = x[0];
  x2 = x.length > 1 ? ',' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1))
    x1 = x1.replace(rgx, '$1' + '.' + '$2');
  return x1 + x2;
}


function number_format(number) {
	number = '' + number;
	number = number.replace(".",",");
	if (number.length > 3) {
		var mod = number.length % 3;
		var output = (mod > 0 ? (number.substring(0,mod)) : '');
		for (i=0 ; i < Math.floor(number.length / 3); i++) {
			if ((mod == 0) && (i == 0))
				output += number.substring(mod+ 3 * i, mod + 3 * i + 3);
			else
				output+= '.' + number.substring(mod + 3 * i, mod + 3 * i + 3);
			}
			return (output);
		}
	else return number;
}

function $_(id, tag) {
	if ($(id)) {
		if ($(id).attributes[tag]) {
			return $(id).attributes[tag].value;
		}else{
			return false;
		}	
   	}else{
		//alert ("non esiste:" + id );
		return false;
	}
}

function getRadio(name) {
		for (var i=0; i < document.buttonform.elements[name].length; i++) {
		if (document.buttonform.elements[name][i].checked) {
           	return document.buttonform.elements[name][i].value;
     		}
   	}
}

function hasClass(ele,cls) {
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}
function addClass(ele,cls) {
	if (!this.hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass(ele,cls) {
	if (hasClass(ele,cls)) {
		var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
		ele.className=ele.className.replace(reg,' ');
	}
}

function defouter(){
  if (document.body.__defineGetter__) {
	if (HTMLElement) {
		var element = HTMLElement.prototype;
		if (element.__defineGetter__) {
			element.__defineGetter__("NewouterHTML",
				function () {
					var parent = this.parentNode;
					var el = document.createElement(parent.tagName);
					el.appendChild(this);
					var shtml = el.innerHTML;
					parent.appendChild(this);
					return shtml;
				}
			);
		}
	}
  } 
}


if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}

function getColore(t, cod){
	var c;
	switch (t){
		case "diam":
			c=cod.substring(1, 3)
			switch (c){
				case "16":
					return "colorA";
					break;
				case "20":
					return "colorB";
					break;
				case "25":
					return "colorY";
					break;
				case "32":
					return "colorL";
					break;
				case "40":
					return "colorN";
					break;
				case "50":
					return "colorM";
					break;
				case "63":
					return "colorX";
					break;
				default:
					return "";
					break;
			}
			break;
		case "dia2":
			c=cod;
			switch (c){
				case "16":
					return "colorA";
					break;
				case "20":
					return "colorB";
					break;
				case "25":
					return "colorY";
					break;
				case "32":
					return "colorL";
					break;
				case "40":
					return "colorN";
					break;
				case "50":
					return "colorM";
					break;
				case "63":
					return "colorX";
					break;
				default:
					return "";
					break;
			}
			break;
		case "tipr":
			c=cod.substring(3, 4)
			switch (c){
				case "P":
					return "colorX";
					break;
				case "V":
					return "colorB";
					break;
				default:
					return "";
					break;
			}
			break;
		case "tip2":
			c=cod.substring(0, 1)
			switch (c){
				case "P":
					return "colorX";
					break;
				case "V":
					return "colorB";
					break;
				default:
					return "";
					break;
			}
			break;
		case "cate":
			c=cod.substring(4, 5)
			switch (c){
				case "S":
					return "colorC";
					break;
				case "X":
					return "colorX";
					break;
				case "A":
					return "colorM";
					break;
				case "L":
					return "colorL";
					break;
				case "F":
					return "colorB";
					break;
				default:
					return "";
					break;
			}
			break;
		case "cat2":
			c=cod.substring(0, 10)
			switch (c){
				case "Standard":
					return "colorC";
					break;
				case "Standard T":
					return "colorC";
					break;
				case "Extra Larg":
					return "colorX";
					break;
				case "Antispigol":
					return "colorM";
					break;
				case "Largo":
					return "colorL";
					break;
				case "Stretto Fr":
					return "colorB";
					break;
				case "Medio":
					return "colorG";
					break;
				default:
					return "";
					break;
			}
			break;
		case "mate":
			c=cod
			switch (c){
				case "PVC":
					return "colorG";
					break;
				case "PP":
					return "colorL";
					break;
				default:
					return "";
					break;
			}
			break;
		case "corr":
			c=cod
			switch (c){
				case "8":
					return "colorA";
					break;
				case "9":
					return "colorB";
					break;
				case "10":
					return "colorY";
					break;
				case "4":
					return "colorL";
					break;
				case "5":
					return "colorN";
					break;
				case "6":
					return "colorM";
					break;
				case "7":
					return "colorX";
					break;
				default:
					return "";
					break;
			}
			break;
	
		default:
			return "";
	}	
}

function getType(s){
	switch (s){
		case "I":
			return "Impegno di produzione";
			break;
		case "G":
			return "Giacenza";
			break;
		case "H":
			return "Consumo calcolato da inizio mese";
			break;
		case "P":
			return "Ordine di Produzione";
			break;
		case "F":
			return "Ordine di Acquisto";
			break;
		case "OPG": case "f10":
			return "Ordine di produzione suggerito";
			break;
		case "IPG": case "f10":
			return "Impegno di produzione per ordine produzione suggerito";
			break;
		case "OAG": case "f20":
			return "Ordine di acquisto suggerito";
			break;
		case "O":
			return "Ordine Cliente";
			break;
		default:
			return s;
	}	
}
