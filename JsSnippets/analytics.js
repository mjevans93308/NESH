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

function track(string) {
  var time_stamp = Math.round(+new Date()/1000); // JS gets time in microsec, PHP uses sec
	var key = "key=7102&event=11&time="+time_stamp+"&tags=5.4,120";// + string;
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
	alert('Gets here 1!');
	xhr.send(key);
	alert('Gets here 2!');
}