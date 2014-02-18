<?php
session_start();

include("mysqli.php");
include("mysqli_verify.php");
global $return_arr=array();

if(isset($_POST['key'])){
	$key = $_POST['key'];
	global $db_ver;
	$hash = $db_ver->escape_string($key);
	$query="SELECT * FROM Hash_Products WHERE hash = '$hash'";
	if ( $result = $db_ver->query($query)){
		if($result->num_rows == 1){
			createEvent($hash);
		}else{
			errlog("HASH_ERROR","invalid hash",$key);
			sendback(-1);
		}
	}
}

function errlog($errid, $errdesc, $errval){
	$return_arr[$errid]=$errdesc.": ".$errval; 
}

function sendback($rval){
	if($rval == 0){
		$return_arr["STATUS"]="SUCCESS";
	}else{
		$return_arr["STATUS"]="FAILURE";
	}
	echo json_encode($return_arr);
}

function createEvent($h){
	global $db_obj;
	$hash = $db_obj->escape_string($hash);
	$event = $db_obj->escape_string($_POST['event']);
	$session = $db_obj->escape_string(session_id());
	$time = $db_obj->escape_string($_POST['time']);

	// check Events tbl to verify event_id
	$query = "SELECT * FROM Events WHERE event_id = '$event'";
	if ( $result = $db_obj->query($query) ){
		$add_row="";
		if( $result->num_rows == 1 ){
			// Add new row to session tbl
			$add_row = "INSERT INTO Session (hash_number,usession_id,event_id,c_timestamp)";
			$add_row += "VALUES ('$hash','$session','$event','$time');";
		}else{
			// or log error message to DB & locally
			errlog("EVENT_ID_ERROR","invalid event_id",$event);
			$add_row = "INSERT INTO Session (hash_number,usession_id,event_id,c_timestamp)";
			$add_row += "VALUES ('$hash','$session','error: invalid event_id: $event','$time');";
		}
		if( ! $result = $db_obj->query($add_row) ){
			errlog("DB_WRITE_ERROR","error writing error msg to db",$event);
			sendback(-1);
		}else{
			sendback(0);
		}
	}
}

// if( ! $_SERVER['HTTPS'] )
//		return a 404 error with https suggestion

//$regex = '/[:{}\s].?/'
//$tokens = preg_split('/')

// get data from POST
	// break up into assoc array
// verify client & project w/ db
// 

var s;
function track(properties){	
var regex = /([\w]+: \{.+\})/;
var events = properties.split(regex);
for(var i = 0; i < events.length; i++){
alert(events[i]);
}
alert("bla");
alert(properties);
//var _POST = "www.nesh.co?"+ properties; //instead of www.nesh.co we will have the actual url.
//alert(_POST); //then use the below function calls asynchronously.
//	xmlhttp.open("POST","demo_get.asp",true);
//	xmlhttp.send(_POST);
return true;
}

?>