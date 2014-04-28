// ENTER CLIENT HASH HERE
var HASH = 123;

/////////////// DON'T CHANGE ANYTHING AFTER THIS LINE ///////////////

function Nesh(clientkey){

	/*********************************************/
	/* Private Member Variables                  */

	//Private Data Object
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

	// Compare loaded temp data with current data
	var compareDataSets = function(temp){
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
	}

	var parseJSON = function(inputstr){
		// parse JSON string
		return eval("("+inputstr+")");
		// return JSON object
	}

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
		// if HTML5 LS available
		if(typeof(Storage) !== "undefined"){
			// write data to localStorage
			localStorage.setItem("data", _data);
		}else{
			//try cookies
		}
	}
	
	// Load Object from LocalStorage
	this.load  = function(){
		// check local storage
		if(typeof(Storage)!=="undefined"){
			if(localStorage.data){
				var temp = localStorage.data;
				compareDataSets(temp);
			}
		}else{
			// check alternative storage methods	
			if(/*altStorage NOT empty*/){
				// pull altStorage into temp
				compareDataSets(temp);
			}
		}
		this.save();
		// check for unsent elements -- send them
		for(entry in _data.log){

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
		var result = parseJSON(_sxhr.responseText);
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
		// add error to log?
		this.createEntry(0,"","SessionID AJAX Request Returned Error");
		// retry?
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
		// store in object array
		//_data.log += entry;
		// !! get index in log
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
		var temp = parseJSON(_exhr.responseText);
		if(_data.log.length > temp.index){
			if(_data.log[temp.index].sent < 1){
				_data.log[temp.index].sent = 1;
			}
		}
		
	}
	
	// Event ajax return error handler
	this._exhr.onerror = function(){
		var temp = parseJSON(_exhr.responseText);
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