function get_XmlHttp() {
  // create the variable that will contain the instance of the XMLHttpRequest object (initially with null value)
  var xmlHttp = null;

  if(window.XMLHttpRequest) {		// for Forefox, IE7+, Opera, Safari, ...
    xmlHttp = new XMLHttpRequest();
  }
  else if(window.ActiveXObject) {	// for Internet Explorer 5 or 6
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  return xmlHttp;
}


function ajaxrequest(php_file, properties) {
	alert("Get here 1");
  var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
  alert("Get here 2");
  // create pairs index=value with data that must be sent to server
  //"key": "1", "time": "2014, 12, 12, 03, 23, 34", "event_id": "properties"
  var the_data = 'key="1", time="2014, 12, 12, 03, 23, 34", event_id="'+properties+'"';
  alert("Get here 3");
  request.open("POST", php_file, true);			// set the request
  alert("Get here 4");
  // adds  a header to tell the PHP script to recognize the data as is sent via POST
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  alert("Get here 5");
  request.send(the_data);		// calls the send() method with datas as parameter
  alert(the_data);
  alert("Get here 6");
  // Check request status
  // If the response is received completely, will be transferred to the HTML tag with tagID
  request.onreadystatechange = function() {
  	if (request.readyState == 4) {
  		alert(request.responseText)
  	}
  }
}
