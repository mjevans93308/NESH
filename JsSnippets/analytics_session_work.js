//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!//
// ******************************** //
//                                  //
// ! ! DON'T USE THIS FILE YET ! !  //
//                                  //
// IT IS A WORK IN PROGRESS WHILE I //
// DETERMINE THE BEST WAY TO HANDLE //
// LOCAL SESSION INFO               //
// ******************************** //
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!//

// JavaScript Document
function createCORSRequest(method, url) {
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
  	return xhr;
}

function getTitle(text) {
  return text.match('<title>(.*)?</title>')[1];
}

function storeUID(uid){
  // store id
  // set date
}

function requestUID(){
  var xhs = createCORSRequest('GET','http://nesh.co/php/guid.php');
  if(!xhs) return null;
  xhs.onload = function(){
    sendData(getTitle(xhs.responseText));
  }
  xhs.onerror = function(){
    sendData();
  }
  xhs.send();
}

function verifyUID(uid){
  var xhv= createCORSRequest('GET','http://nesh.co/php/vuid.php');
  if(!xhv) requestUID();
  xhv.onload = function(){
    if(getTitle(xhv.responseText))
      sendData(uid);
    else
      requestUID();
  }
  xhv.onerror = function(){
    requestUID();
  }
  xhv.send();
}

function getSession(){
  // maybe do most of this stuff with a library to handle local storage?
  // I. Check for existing local storage (check all means)
    // A. Local storage exists
      // 1. Check for session_id and use_date
        // a. session_id exists & is fresh
          // i. verifyUID(session_id);
          // ii. reset use_date
        // b. session_id is stale OR does not exist
          // i. requestUID()
          // ii. store new session_id & set use_date
          // ii. return session_id
    // B. No local storage
      // 1. Find best means of storage
        // a. requestUID()
        // b. store new session_id & set use_date
        // c. return session_id
      // 2. If no storage possible, do what? need a work around? or just kill the whole deal?

}

function track(string) {
  var time_stamp = Math.round(+new Date()/1000); // JS gets time in microsec, PHP uses sec
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