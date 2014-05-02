// ENTER CLIENT HASH HERE

var HASH = 123;

/////////////// DON'T CHANGE ANYTHING AFTER THIS LINE ///////////////

/**
*
*  MD5 (Message-Digest Algorithm)
*  http://www.webtoolkit.info/
*
**/
 
var MD5 = function (string) {
 
    function RotateLeft(lValue, iShiftBits) {
        return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
    }
 
    function AddUnsigned(lX,lY) {
        var lX4,lY4,lX8,lY8,lResult;
        lX8 = (lX & 0x80000000);
        lY8 = (lY & 0x80000000);
        lX4 = (lX & 0x40000000);
        lY4 = (lY & 0x40000000);
        lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
        if (lX4 & lY4) {
            return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
        }
        if (lX4 | lY4) {
            if (lResult & 0x40000000) {
                return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
            } else {
                return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
            }
        } else {
            return (lResult ^ lX8 ^ lY8);
        }
     }
 
     function F(x,y,z) { return (x & y) | ((~x) & z); }
     function G(x,y,z) { return (x & z) | (y & (~z)); }
     function H(x,y,z) { return (x ^ y ^ z); }
    function I(x,y,z) { return (y ^ (x | (~z))); }
 
    function FF(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    };
 
    function GG(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    };
 
    function HH(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    };
 
    function II(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    };
 
    function ConvertToWordArray(string) {
        var lWordCount;
        var lMessageLength = string.length;
        var lNumberOfWords_temp1=lMessageLength + 8;
        var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
        var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
        var lWordArray=Array(lNumberOfWords-1);
        var lBytePosition = 0;
        var lByteCount = 0;
        while ( lByteCount < lMessageLength ) {
            lWordCount = (lByteCount-(lByteCount % 4))/4;
            lBytePosition = (lByteCount % 4)*8;
            lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
            lByteCount++;
        }
        lWordCount = (lByteCount-(lByteCount % 4))/4;
        lBytePosition = (lByteCount % 4)*8;
        lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
        lWordArray[lNumberOfWords-2] = lMessageLength<<3;
        lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
        return lWordArray;
    };
 
    function WordToHex(lValue) {
        var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
        for (lCount = 0;lCount<=3;lCount++) {
            lByte = (lValue>>>(lCount*8)) & 255;
            WordToHexValue_temp = "0" + lByte.toString(16);
            WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
        }
        return WordToHexValue;
    };
 
    function Utf8Encode(string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
 
        for (var n = 0; n < string.length; n++) {
 
            var c = string.charCodeAt(n);
 
            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }
 
        }
 
        return utftext;
    };
 
    var x=Array();
    var k,AA,BB,CC,DD,a,b,c,d;
    var S11=7, S12=12, S13=17, S14=22;
    var S21=5, S22=9 , S23=14, S24=20;
    var S31=4, S32=11, S33=16, S34=23;
    var S41=6, S42=10, S43=15, S44=21;
 
    string = Utf8Encode(string);
 
    x = ConvertToWordArray(string);
 
    a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
 
    for (k=0;k<x.length;k+=16) {
        AA=a; BB=b; CC=c; DD=d;
        a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
        d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
        c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
        b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
        a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
        d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
        c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
        b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
        a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
        d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
        c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
        b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
        a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
        d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
        c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
        b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
        a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
        d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
        c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
        b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
        a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
        d=GG(d,a,b,c,x[k+10],S22,0x2441453);
        c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
        b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
        a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
        d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
        c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
        b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
        a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
        d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
        c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
        b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
        a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
        d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
        c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
        b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
        a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
        d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
        c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
        b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
        a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
        d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
        c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
        b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
        a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
        d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
        c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
        b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
        a=II(a,b,c,d,x[k+0], S41,0xF4292244);
        d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
        c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
        b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
        a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
        d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
        c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
        b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
        a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
        d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
        c=II(c,d,a,b,x[k+6], S43,0xA3014314);
        b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
        a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
        d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
        c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
        b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
        a=AddUnsigned(a,AA);
        b=AddUnsigned(b,BB);
        c=AddUnsigned(c,CC);
        d=AddUnsigned(d,DD);
    }
 
    var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);
 
    return temp.toLowerCase();
}
// END MD5

// storage handling from https://gist.github.com/remy/350433
// license: http://rem.mit-license.org/
if (!('sessionStorage' in window) && ('localStorage' in window)) (function () {

var Storage = function (type) {
	function createCookie(name, value, days) {
		var date, expires;

		if (days) {
			date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			expires = "; expires="+date.toGMTString();
		} else {
			expires = "";
		}
		document.cookie = name+"="+value+expires+"; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=",
				ca = document.cookie.split(';'),
				i, c;

		for (i=0; i < ca.length; i++) {
			c = ca[i];
			while (c.charAt(0)==' ') {
				c = c.substring(1,c.length);
			}

			if (c.indexOf(nameEQ) == 0) {
				return c.substring(nameEQ.length,c.length);
			}
		}
		return null;
	}
	
	function setData(data) {
		data = JSON.stringify(data);
		if (type == 'session') {
			window.name = data;
		} else {
			createCookie('localStorage', data, 365);
		}
	}
	
	function clearData() {
		if (type == 'session') {
			window.name = '';
		} else {
			createCookie('localStorage', '', 365);
		}
	}
	
	function getData() {
		var data = type == 'session' ? window.name : readCookie('localStorage');
		return data ? JSON.parse(data) : {};
	}


	// initialise if there's already data
	var data = getData();

	return {
		length: 0,
		clear: function () {
			data = {};
			this.length = 0;
			clearData();
		},
		getItem: function (key) {
			return data[key] === undefined ? null : data[key];
		},
		getObject: function (key) {
			return JSON.parse(getItem(key));
		},
		key: function (i) {
			// not perfect, but works
			var ctr = 0;
			for (var k in data) {
				if (ctr == i) return k;
				else ctr++;
			}
			return null;
		},
		removeItem: function (key) {
			delete data[key];
			this.length--;
			setData(data);
		},
		setItem: function (key, value) {
			data[key] = value+''; // forces the value to a string
			this.length++;
			setData(data);
		},
		setObject: function (key, object) {
			setItem(key, JSON.stringify(object));
		}
	};
};

if(!('localStorage' in window)) window.localStorage = new Storage('local');
if(!('sessionStorage' in window)) window.sessionStorage = new Storage('session');

})();
/*
 * window.localStorage.length
 * window.localStorage.clear(); empties storage
 * window.localStorage.getItem(key); returns single item
 * window.localStorage.getObject(key); returns jsonObj
 * window.localStorage.key(i); return string key at index i
 * window.localStorage.removeItem(key);
 * window.localStorage.setItem(key,value);
 * window.localStorage.setObject(key,jsonObj);
 */
// end storage


function Nesh(clientkey){

	/*********************************************/
	/* Private Member Variables                  */

	//Private Data Object
	//var _storage = new Storage();
	var _data = {
		"sid"    : 0,			// user session id
		"start"  : 0,			// time stamp of session beginning
		"hash"   : clientkey,	// client hash key
		"log" 	 : new Array(), // event log
		//"err"    : new Array(), // error log
		"needy"  : 1 			// need SID flag: 1 need, 0 success, -1 error

		/* LOG/ERR ITEM FORMAT
		{
			timestamp:Time(),
			eventid: string,
			tags: [strings],
			errmsg: string, // empty string for event
			sent: int // flag: 0=not sent, 1=success, -1=failed
			active : BOOL (false)		// active ajax call in progress
		}
		*/
		//timeout? - handled by XMLHttpReq
	}

	// Network Member Vars
	var _urlRoot = "http://nesh.co/php/";
	// XMLHttpReq for SID
	var _sxhr = createCORSRequest('POST', _urlRoot+"getSid_json.php");
	// XMLHttpReq for Events
	var _exhr = createCORSRequest('POST', _urlRoot+"getData_json.php");


	/*********************************************/
	/* Private methods of the class              */

	// DON'T NEED THIS ????
	// Compare loaded temp data with current data
	/*var compareDataSets = function(temp){
		// compare sids
		if(temp.sid == _data.sid){
			// same :: merge _log & _errlog
		}else{
			if( temp.sid == 0 || _data.sid == 0){
				// one unset :: merge & set all to live sid				
			}else{
				// diff :: ignore new data, create new object?
			}
		}
	}*/

	// BAD!!! DO NOT USE!!!
	/*var parseJSON = function(inputstr){
		// parse JSON string
		return eval("("+inputstr+")");
		// return JSON object
	}*/

	// Create CORS XMLHttpRequest
	var createCORSRequest = function(method, url) {
		var xhr = new XMLHttpRequest();
	  	if ("withCredentials" in xhr){
	    	xhr.open(method, url, true);
	  	} 
		else if (typeof XDomainRequest != "undefined") {
	    	xhr = new XDomainRequest();
	    	xhr.open(method, url);
	  	} 
		else {
	    	xhr = null;
	  	}
	  	if (!xhr) {
   			createError('CORS not supported');
 		}
	  	return xhr;
	}

	/*********************************************/
	/* Public methods of the class               */
	
	// Save Object to LocalStorage
	this.save = function(){
		window.localStorage.setObject("data",_data);
		// if HTML5 LS available
		/*if(typeof(Storage) !== "undefined"){
			// write data to localStorage
			localStorage.setItem("data", _data);
		}else{
			//try cookies
		}*/
	}
	
	// Load Object from LocalStorage
	this.load  = function(){
		// check local storage
		/*if(typeof(Storage)!=="undefined"){
			if(localStorage.data){
				var temp = localStorage.data;
				compareDataSets(temp);
			}
		}else{
			// check alternative storage methods	
			if(0){//altStorage NOT empty
				// pull altStorage into temp
				compareDataSets(temp);
			}
		}*/
		//this.save();
		_data = window.localStorage.getObject("data");
		// check for unsent elements -- send them
		for(entry in _data.log){
			if(entry.sent < 1){
				this.postEvent(entry,)
			}
		}
	}
	
	this.getSID = function(){
		// only get/verify the sid if needy
		if( ! _data.needy ) return;

		_data.active = true;
		// if the last sid call was an error, reset the sid
		if( _data.needy == -1 ) _data.sid = 0 ;
		// ajax call with sid (if 0, return unique, else verifies)
		_sxhr.send( "sid="+_data.sid );
	}
	
	//SID ajax return handler
	this._sxhr.onload = function(){
		// clear timeout - handled by XMLHttpReq
		var result = JSON.parse(_sxhr.responseText);
		_data.sid = result.sid;
		_data.active = false;
		_data.needy = 0;
		this.load();
	}
	
	//SID ajax return error handler
	this._sxhr.onerror = function(){
		// clear timeout - handled by XMLHttpReq
		_data.active = false;
		_data.needy = -1;
		// TODO add error to log?
		this.createEntry(0,"","SessionID AJAX Request Returned Error");
		// TODO retry?
	}

	// create an event element in the log
	this.track = function(evid,tagstr){
		this.createEntry(evid,tagstr,"");
	}

	// create a log entry, save local & call ajax
	this.createEntry = function(evid, tags, errmsg){
		var entry = {
			"timestamp":Math.round(+new Date()/1000), // JS gets time in microsec, PHP uses sec
			"eventid": evid,
			"tags": tagstr.split(","),
			"errmsg": errmsg,
			"sent": 0 // flag: 0=not sent, 1=success, -1=failed
		};
		// store in object array & get index
		index = _data.log.push(entry) - 1;
		// save local
		this.save();
		// postEvent
		this.postEvent(entry,index);
	}
	
	// Event ajax post
	this.postEvent = function(entry,index){
		// create string key
		var key = "key="+_data.hash+"&session="+_data.sid+"event="+entry.id+"&time="+entry.timestamp+"&tags="+entry.tagstring;
		//alert(key);
		_exhr.send(key);
	}
	
	// Event ajax return handler
	this._exhr.onload = function(){
		var temp = JSON.parse(_exhr.responseText);
		if(_data.log.length > temp.index){
			if(_data.log[temp.index].sent < 1){
				_data.log[temp.index].sent = 1;
			}
		}
		
	}
	
	// Event ajax return error handler
	this._exhr.onerror = function(){
		var temp = JSON.parse(_exhr.responseText);
		if(_data.log.length > temp.index){
			if(_data.log[temp.index].sent < 1){
				_data.log[temp.index].sent = -1;
			}
		}
	}

	// initial session ID attempt
	this.getSID();
}

// initialize nesh object
var nesh = Nesh(HASH);

/* JS Object/Class Usage
 *
 * Constructor/Definition
 * 	 function TYPE(){...(rest goes in here)...}
 *
 * Private Variables
 *   var variable = value;
 * Public Variables
 *   this.variable = value;
 *
 * Private methods
 *   var funcName = function(){}
 * Public methods
 *   this.fxnName = function(){}
 */