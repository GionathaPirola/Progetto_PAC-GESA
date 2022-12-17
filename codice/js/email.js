/*
 * Email addresses
 * 
 * Definitions from (unless otherwise noted):
 * - [RFC 2822] Internet Message Format
 */

// internationalized
var text =
	"(" +
		"[" +
			"\\x01-\\x09" +
			"\\x0b" +
			"\\x0c" +
			"\\x0d-\\x7f" +
		"]" +
		"|" + ucschar +
	")";

var NOWSCTL =
	"[" +
		"\\x01-\\x08" +
		"\\x0b" +
		"\\x0c" +
		"\\x0e-\\x1f" +
		"\\x7f" +
	"]";

// section 2.2.2 Header Fields
var SP = "\\x20";
var HTAB = "\\x09";
var WSP =
	"(" +
		SP +
		"|" + HTAB +
	")";

// section 2.1 General Description
var CRLF = "(\\x0d\\x0a)";

// removed obsolete folding white space (obs-FWS)
var FWS =
	"(" +
		"(" +
			WSP + "*" +
			CRLF +
		")?" +
		WSP + "+" +
	")";

var DQUOTE = "(\\x22)";

// internationalized
var qtext =
	"(" +
		NOWSCTL +
		"|\\x21" +
		"|[\\x23-\\x5b]" +
		"|[\\x5d-\\x7e]" +
		"|" + ucschar +
	")";

// removed obsolete quoted pair (obs-qp)
var quotedPair =
	"(" +
		"\\\\" +
		text +
	")";

var qcontent =
	"(" +
		qtext +
		"|" + quotedPair +
	")";

// removed comments and folding white space (CFWS)
var quotedString =
	"(" +
		DQUOTE +
		"(" +
			FWS + "?" +
			qcontent +
		")*" +
		FWS + "?" +
		DQUOTE +
	")";

// created from symbols in atext
var atextSymbols = "[!#\\$%&'\\*\\+\\-\\/=\\?\\^_`{\\|}~]";

// internationalized
var atext =
	"(" +
		ALPHA +
		"|" + DIGIT +
		"|" + atextSymbols +
		"|" + ucschar +
	")";

var dotAtomText =
	"(" +
		atext + "+" +
		"(" +
			"\\." +
			atext + "+" +
		")*" +
	")";

// removed comments and folding white space (CFWS)
var dotAtom = dotAtomText;

// removed comments and folding white space (CFWS)
var atom = atext + "+";

// ihostName from iri.http.js (http://projects.scottsplayground.com/iri)
var domain = ihostName;

// removed obsolete local part (obs-local-part)
var localPart =
	"(" +
		dotAtom +
		"|" + quotedString +
	")";

var addrSpec = localPart + "@" + domain;