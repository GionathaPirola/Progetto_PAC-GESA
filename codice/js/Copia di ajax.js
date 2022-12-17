/* Copyright(C) 2005,2006,2007 Salvatore Sanfilippo <antirez@gmail.com>
 * All Rights Reserved. */

/* Browser compatibilty.
 * Tested with:
 *
 * Firefox 1.0 to 1.5
 * Konqueror 3.4.2
 * Internet Explorer 5.0
 * internet Explorer 6.0
 * internet Explorer 7.0
 *
 * It should work also in Opera and Safari without troubles. */

// Create the XML HTTP request object. We try to be
// more cross-browser as possible.
function CreateXmlHttpReq(handler) {
  var xmlhttp = null;
  try {
    xmlhttp = new XMLHttpRequest();
    try {
        // Fix for some version of Mozilla browser.
        http_request.overrideMimeType('text/xml');
    } catch(e) {
    }
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
var ajax_req = null;

function ajaxGet(url,handler) {
    var a = new Array("placeholder");
    for (var j=2; j<arguments.length; j++) {
        a[a.length] = arguments[j];
    }
    var myhandler = function() {
        var content = ajaxOk();
        if (content !== false) {
            a[0] = content;
            try {
                return handler.apply(this, a);
            } catch(e) {
                return myDummyApply(handler, a);
            }
        }
    }
    ajax_req = CreateXmlHttpReq(myhandler);
    ajax_req.open("GET",url);
    ajax_req.send(null);
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

function ajaxOk() {
    if (ajax_req.readyState == 4 && ajax_req.status == 200) {
        return ajax_req.responseText;
    } else {
        return false;
    }
}
