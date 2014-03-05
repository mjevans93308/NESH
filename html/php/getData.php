<?php 
if($_SERVER['REQUEST_METHOD'] == "GET")
{
    header('Content-Type: text/plain');
    echo "This HTTP resource is designed to handle POSTed XML input from arunranga.com and not be retrieved with GET";
   
}
elseif($_SERVER['REQUEST_METHOD'] == "OPTIONS")
{
    // Tell the Client we support invocations from arunranga.com and that this preflight holds good for only 20 days
    if($_SERVER['HTTP_ORIGIN'] == "http://students.engr.scu.edu/~anarra/bMI/index.html")
    {
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: X-PINGARUNER');
    header('Access-Control-Max-Age: 1728000');
    //header("Content-Length: 0");
    header("Content-Type: text/html");
    //exit(0);
    }
    else
    {
    header("HTTP/1.1 403 Access Forbidden");
    header("Content-Type: text/html");
    echo "You cannot repeat this request";
   
    }
}
elseif($_SERVER['REQUEST_METHOD'] == "POST")
{
    /* Handle POST by first getting the XML POST blob, and then doing something to it, and then sending results to the client
    */
    if($_SERVER['HTTP_ORIGIN'] == "http://students.engr.scu.edu/~anarra/bMI/index.html")
    {
            $postData = file_get_contents('php://input');
            $document = simplexml_load_string($postData);
            
            // do something with POST data

            $ping = $_SERVER['HTTP_X_PINGARUNER'];
           
                       
            header('Access-Control-Allow-Origin:*');
            header('Content-Type: text/html');
            echo "This worked!"; // some string response after processing
    }
    else
        die("POSTing Only Allowed from arunranga.com");
}
else
    die("No Other Methods Allowed");

/*
// ADD HERE: check if HTTPS, if not, return error! Once we have https setup

session_start();

/* USAGE
	- $_POST should include
		key = hash key generated at project registration. unique to each project
		time = timestamp local to user
		event = event_id
		// tags coming soon
		tags = list of tags as a string of tags separated by commas "tag A,tag B,tag C"
		OPTIONAL:
		euid = end user id. this should be included with a unique device ID for mobile apps, since we will not be able to store session data
*

include("mysqli.php");
//include("mysqli_verify.php"); // we should store the hash table in a seperate database for security purposes

$return_arr=array();

// this block would use $db_ver when mysqli_verify.php is implemented & a seperate table is created for hash key
if(isset($_POST['key'])){
	$key = $_POST['key'];
	global $db_obj;
	$hash = $db_obj->escape_string($key);
	$query="SELECT * FROM Hash_Products WHERE hash = '$hash'";
	if ( $result = $db_obj->query($query)){
		if($result->num_rows == 1){
			createEvent($hash);
		}else{
			errlog("HASH_ERROR","invalid hash",$key);
			errlog("HASH_ERROR_SQL",mysql_error(),mysql_errno());
			sendback(-1);
		}
	}else{
		errlog("HASH_ERROR","invalid hash",$key);
		errlog("HASH_ERROR_SQL",mysql_error(),mysql_errno());
		sendback(-1);		
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
	$event = $db_obj->escape_string($_POST['event_id']);
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
			errlog("EVENT_ID_ERROR","invalid event_id ",$event);
			errlog("EVENT_ID_ERROR_SQL",mysql_error(),mysql_errno());
			$add_row = "INSERT INTO Session (hash_number,usession_id,event_id,c_timestamp)";
			$add_row += "VALUES ('$hash','$session','error: invalid event_id: $event','$time');";
		}
		if( ! $result = $db_obj->query($add_row) ){
			errlog("DB_WRITE_ERROR","error writing to db",$event);
			errlog("DB_WRITE_ERROR_SQL",mysql_error(),mysql_errno());
			sendback(-1);
		}else{
			sendback(0);
		}
	}else{
		// or log error message to DB & locally
		errlog("EVENT_ID_ERROR","invalid event_id ",$event);
		errlog("EVENT_ID_ERROR_SQL",mysql_error(),mysql_errno());
		sendback(-1);
	}
*/
?>
