/* Copyright(C) 2005,2006,2007 Salvatore Sanfilippo <antirez@gmail.com>
 * All Rights Reserved. */

// Create the XML HTTP request object. We try to be
// more cross-browser as possible.
function CreateXmlHttpReq(handler) {
  var xmlhttp = null;
  try {
    xmlhttp = new XMLHttpRequest();
  } catch(e) {
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
  xmlhttp.onreadystatechange = handler;
  return xmlhttp;
}

// An handler that does nothing, used for AJAX requests that
// don't require a reply and are non-critical about error conditions.
function DummyHandler() {
    return true;
}

// Shortcut for creating a GET request and get the reply
// This few lines of code can make Ajax stuff much more trivial
// to write, and... to avoid patterns in programs is sane!
function ajaxGet(url,handler) {
    var a = new Array("placeholder");
    for (var j=2; j<arguments.length; j++) {
        a[a.length] = arguments[j];
    }
    var ajax_req = CreateXmlHttpReq(DummyHandler);
    var myhandler = function() {
        var content = ajaxOk(ajax_req);
        if (content !== false) {
            a[0] = content;
            try {
                return handler.apply(this, a);	            
            } catch(e) {
	            return myDummyApply(handler, a);
            }
        }
    }
    ajax_req.open("GET",url);
    ajax_req.onreadystatechange = myhandler;
    ajax_req.send(null);
}

function ajaxPost(url,handler,params) {
    var a = new Array("placeholder");
    for (var j=3; j<arguments.length; j++) {
        a[a.length] = arguments[j];
    }
    var ajax_req = CreateXmlHttpReq(DummyHandler);
    var myhandler = function() {
        var content = ajaxOk(ajax_req);
        if (content !== false) {
            a[0] = content;
            try {
                return handler.apply(this, a);
            } catch(e) {
                return myDummyApply(handler, a);
            }
        }
    }
    ajax_req.open("POST",url);
    ajax_req.onreadystatechange = myhandler;
    ajax_req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax_req.setRequestHeader("charset", "UTF-8");
	ajax_req.setRequestHeader("Content-length", params.length);
	//ajax_req.setRequestHeader("Connection", "close");
    ajax_req.send(params);
}


// IE 5.0 does not support the apply() method of the function object,
// we resort to this eval-based solution that sucks because it is not
// capable of preserving 'this' and is ugly as hell, but it works for us.
function myDummyApply(funcname,args) {
    var e = "funcname(";
    for (var i = 0; i < args.length; i++) {
        e += "args["+i+"]";
        if (i+1 != args.length) {
            e += ",";
        }
    }
    e += ");"
    return eval(e);
}

// Add a random parameter to the get request to avoid
// IE caching madness.
function ajaxGetRand(url,handler) {
    url += (url.indexOf("?") == -1) ? "?" : "&";
    url += "rand="+escape(Math.random());
    arguments[0] = url;
    try {
        return ajaxGet.apply(this,arguments);
    } catch(e) {
        return myDummyApply(ajaxGet,arguments);
    }
}

function ajaxOk(req) {
    if (req.readyState == 4 && req.status == 200) {
        return req.responseText;
    } else {
        return false;
    }
}


function $(id,TarGet) {
	if(TarGet==null) TarGet=window;
	if (TarGet.document.getElementById && TarGet.document.getElementById(id) && TarGet.document.getElementById(id).style) {
   		return TarGet.document.getElementById(id); 
  	} else if (TarGet.document.all && TarGet.document.all[id] && TarGet.document.all[id].style) {
   		return TarGet.document.all[id]; 
   	} else if (TarGet.document.layers && TarGet.document.layers[id]) {
   		TarGet.document.layers[id].style=TarGet.document.layers[id];
		return TarGet.document.layers[id];
	} else if (TarGet.document.getElementById && TarGet.document.getElementById(id.id)) {
		return TarGet.document.getElementById(id.id); 
	} else return null;
} 

function $hide(id) {
	if ($(id)) {
    	$(id).style.visibility = "hidden";
    	return true;
	}else{
		//alert ("non esiste:" + id );
		return false;
	}
}

function $show(id) {
	if ($(id)) {
	    $(id).style.visibility = "visible";
    	return true;
	}else{
		//alert ("non esiste:" + id );
		return false;
	}
}

function $html(id) {
	if ($(id)) {
	    return $(id).innerHTML;
   	}else{
		//alert ("non esiste:" + id );
		return false;
	}

}

function $sethtml(id,html) {
	if ($(id)) {
			    $(id).innerHTML = html;
   	}else{
		//alert ("non esiste:" + id );
		return false;
	}

}

function $apphtml(id,html) {
	if ($(id)) {
    	$(id).innerHTML += html;
   	}else{
		//alert ("non esiste:" + id );
		return false;
	}
}

function $$(id, tag) {
	if ($(id)) {
		return $(id).attributes[tag].value;
		//return $(id).getAttribute(tag);
   	}else{
		//alert ("non esiste:" + id );
		return false;
	}
}

function $setouthtml(id, html){
	ele=$(id);
	if (typeof(ele.outerHTML)=='undefined') {
		var r=ele.ownerDocument.createRange();
     	r.setStartBefore(ele);
     	ele.parentNode.replaceChild(r.createContextualFragment(html), ele);
    	}
 	else {
	 	ele.outerHTML=html;
     }
}


function $pid(partialid,tagname){
	var r= new Array();
	var re= new RegExp(partialid,'g')
	if (tagname==''||tagname==null) tagname = '*';
	var el = document.getElementsByTagName(tagname);
	var f=0;
	for(var i=0;i<el.length;i++){
		if(el[i].id.match(re)){
			r[f]=el[i].id;
			f++;
		}
	}
	return r;
}

	
	
