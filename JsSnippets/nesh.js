// JavaScript Document
function Nesh(clientkey){
	//Private variables.
	var _sid;				// user session id
	var _hash = clientkey;	// client hash key

	/*var events = {//"key1" = "value1", "key2" = "value2"
				  };
	var tags = {//"key1" = "value1", "key2" = "value2"
				};
	//var events = new Array();
	//var tags = new Array();	*/

	var _log = new Array();		// event log
	var _errlog = new Array();	// error log
	var _jsonObj;				// JSON Obj for load/save

	var _active = false; 	// active request
	var _needy = 1;			// need sid: 1 need, 0 have, -1 error
	//timeout? - handled by XMLHttpReq

	var _urlRoot = "http://nesh.co/php/";
	var _sxhr;				// XMLHttpReq for SID
	var _exhr;				// XMLHttpReq for Events

	
	//Public Variables
	//this.variable = value;
	
	//Private methods
	//var funcName = function(){}
	var setJSON = function(){
		_jsonObj = {
			"sid" : _sid,
			"hash": _hash,
			"log" : _log,
			"err" : _errlog
		};
	}

	//Public methods of the class
	this.save = function(){
		//save object to localStorage
		setJSON(); // update the JSON Object
		if(typeof(Storage) !== "undefined")
		{

		}else{
			//try cookies
		}
	}
	
	this.load  = function(){
		//load object from localStorage
		// check local storage
		// if local storage NOT empty
			// pull local storage into temp
			// compare sids
				// same :: merge _log & _errlog
				// one unset :: merge & set all to live sid
				// diff :: ignore new data, create new object?
		// save back to localstorage
		// check for unsent elements -- send them
	}
	
/*	this.get_sid = function(){
		return sid; //return the private variable
	}
*/	
	this.getSID = function(){
		//ajax call to server to get a unique session id
		// set timeout - handled by XMLHttpReq
		this.active = true;
		this.needy = 1;
		// ajax call
	}
	
	this.SIDSuccess = function(){
		//ajax return handler
		// clear timeout - handled by XMLHttpReq
		this.active = false;
		this.needy = 0;
		this.load();
	}
	
	this.SIDError = function(){
		//ajax return error handler
		// clear timeout - handled by XMLHttpReq
		this.active = false;
		this.needy = -1;
		// add error to log
		// retry?
	}

	this.createEvent = function(){
		// create event
		// check sid ? sid : 0

		
		// create string key
		var time_stamp = Math.round(+new Date()/1000); // JS gets time in microsec, PHP uses sec

		// store in object array
		// save local
		// postEvent
	}
	
	this.postEvent = function(){
		//ajax call to server with new event
  var sid = getSession(xhr);
  var sidstr = "";
	var key = "key=7102&session="+sid+"event=11&time="+time_stamp+"&tags=5.4,120";// + string;
	alert(key);
	var url = 'http://nesh.co/php/getData.php';
  var xhr = createCORSRequest('POST', url);
  if (!xhr) {
   	alert('CORS not supported');
   	return;
  }
	xhr.onload = function() {
   	//var text = xhr.responseText;
   	//var title = getTitle(text);
   	alert('Success: Response from CORS request:' + xhr.responseText);
	};

	xhr.onerror = function() {
		//alert('Woops, there was an error making the request.');
    //  var text = xhr.responseText;
    //  var title = getTitle(text);
    alert('Failure: Response from CORS request:' + xhr.responseText);
	};
	//alert('Gets here 1!');
	xhr.send(key);
	//alert('Gets here 2!');
	}
	
	this.postSuccess = function(){
		//ajax return handler
	}
	
	this.postError = function(){
		//ajax return error handler
	}
}

var nesh = Nesh(/*client hash key goes here*/ 123);