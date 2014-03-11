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
	var key = "key=1&" + "event_id=" + string;
	alert(key);
	var url = 'http://nesh.co/php/getData.php';
  	var xhr = createCORSRequest('POST', url);
  	if (!xhr) {
    	alert('CORS not supported');
    	return;
  	}
	xhr.onload = function() {
    	var text = xhr.responseText;
    	var title = getTitle(text);
    	alert('Response from CORS request to ' + url + ': ' + title);
	};

	xhr.onerror = function() {
		alert('Woops, there was an error making the request.');
	};
	alert('Gets here 1!');
	xhr.send(key);
	alert('Gets here 2!');
}