var s;
function track(properties){	
	//var regex = /([\w]+: \{.+\})/;
	//var events = properties.split(regex);
	//for(var i = 0; i < events.length; i++){
		//alert(events[i]);
	//}
	//alert("bla");
	//alert(properties);
	alert("before post");
	//alert(getTime());
	alert(properties);
	$.post("http://www.nesh.co/php/getData.php", {key: "1", time: "2014, 12, 12, 03, 23, 34", event_id: "properties"});
	alert("after post");
	// _POST = "www.nesh.co?"+ properties; //instead of www.nesh.co we will have the actual url.
	//alert(_POST); //then use the below function calls asynchronously.
	//xmlhttp.open("POST","demo_get.asp",true);
	//xmlhttp.send(_POST);
	return true;
}