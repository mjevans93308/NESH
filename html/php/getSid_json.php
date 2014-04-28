<?php
/* USAGE
	- $_POST should include
		key = hash key generated at project registration. unique to each project
		time = timestamp local to user
		event = event_id
		tags = list of tags as a string of tags separated by commas "tag A,tag B,tag C"??
		// euid coming soon
		OPTIONAL:
		euid = end user id. this should be included with a unique device ID for mobile apps, since we will not be able to store session data
*/
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: text/html; charset=utf-8');

//header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization, Content-Type");
//header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');//, GET, OPTIONS'); 
header('Access-Control-Max-Age: 2419200');
//header('content-type: application/json; charset=utf-8;');
?>
<?php
include("mysqli.php");
if(isset($HTTP_RAW_POST_DATA)) {
	global $db_obj;
	$return_arr=array();

	// clean input data
	parse_str($HTTP_RAW_POST_DATA,$_SET); // here you will get variables
	// verified _SET variables transmitted properly (JS)
	foreach ($_SET as $k => $value) {
		$_CLEAN[$k] = htmlentities($value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED);
		//unset($_SET[$k]);
		//unset($value);
	}
	// verified _CLEAN variables properly interpreted (JS)

	$inputSID = 0;
	// verify needed data & clean for DB
	if(isset($_CLEAN['sid'])){ $inputSID=$_CLEAN['sid']; }

	//include("mysqli_verify.php"); // we should store the hash table in a seperate database for security purposes

	if($inputSID){
		$query="SELECT * FROM USID WHERE usession_id = '$inputSID'";
		if ($result = $db_obj->query($query)){
			if($result->num_rows == 1){
				// unique
			}else{
				// not in table / not unique
				// generate error
				// generate unique
				// send back
			}
		}
	}else{
		// add new SID to DB & return it
	}
		
		$query="SELECT * FROM USID WHERE usession_id = '$inputSID'";
		if ( $result = $db_obj->query($query)){
			if($result->num_rows == 1){
				createEvent($hash,$event,$time,$tags);
			}
			else{
				//error(3); // invalid hash in db (too many or not exist)
				errlog("HASH_ERROR","invalid hash",$hash);
				errlog("HASH_ERROR_SQL",mysql_error(),mysql_errno());
				sendback(-1);
			}
		}
		else{
			errlog("HASH_QUERY_ERROR","query error with hash",$hash);
			errlog("HASH_QUERY_ERROR_SQL",mysql_error(),mysql_errno());
			sendback(-1);		
		}
	}
	else{
		sendback(-1);
	}
}
else{
	errlog("POST_ERROR","no post data");
	sendback(-1);
}

function errlog($errid, $errdesc="", $errval=""){
	global $return_arr;
	$return_arr[$errid]="";
	if($errdesc)
		$return_arr[$errid]=$errdesc; 
	if($errval)
		$return_arr[$errid].=": ".$errval; 
}

function sendback($rval){
	global $return_arr;
	if($rval == 0){
		$return_arr["STATUS"]="SUCCESS";
	}
	else{
		$return_arr["STATUS"]="FAILURE";
	}
	$prejoin = array();
	foreach($return_arr as $tag => $str){
		$prejoin[] = "\"$tag\":\"$str\"";
	}
	$echostring = join(",",$prejoin);
	$index = $_CLEAN['index'];
	echo "{\"index\":\"$index\",$echostring}";
}

function tagcount($h,$c){
	global $db_obj;
	$tags = 0;
	$queryH = "SELECT * FROM Hash_Products WHERE hash_number = '$h'";
	if($resultH = $db_obj->query($queryH)){
		if($rowH = mysqli_fetch_array($resultH)){
			$queryP = "SELECT * FROM Products WHERE pid = '{$rowH['pid']}'";
			if($resultP = $db_obj->query($queryP)){
				if($rowQ = mysqli_fetch_array($resultP)){
					for($i=0;$i<$c;$i++){
						if($rowQ['tag'.$i]){
							$tags++;
						}
					}
				}
			}
		}
	}
	return $tags;
}

// hash, user, event, time, tags, error
function createEvent($h,$e,$t,$ta = array()){
	global $db_obj, $return_arr;
	$session = $db_obj->escape_string(session_id());
	//errlog('time_t_precheck',$t); // DEBUG FEEDBACK
	if(!$t){
		if(isset($_SERVER['REQUEST_TIME']))
			$t=$_SERVER['REQUEST_TIME'];
		else
			$t=time();
	}
	//errlog('time_t_postcheck',$t); // DEBUG FEEDBACK
	$tf = date("Y-m-d H:i:s",$t); // timestamp formatted to SQL
	//errlog('time_tf',$tf); // DEBUG FEEDBACK
	
	// check Events tbl to verify event_id
	$query = "SELECT * FROM Events WHERE event_id = '$e'";
	if ( $result = $db_obj->query($query) ){
		$add_row="";
		$ret_val=1;

		// build tag strings
		$tagnums="";
		$tagvals="";
		for($i=0;$i<count($ta);$i++){
			$tagnums .= ",tag".$i;
			$tagvals .= ",'".$ta[$i]."'";
		}

		if( $result->num_rows == 1 ){
			// Add new row to session tbl
			$add_row = "INSERT INTO Session (hash_number,usession_id,event_id,c_timestamp$tagnums)";
			$add_row .= " VALUES ('$h','$session','$e','$tf'$tagvals);";
			$ret_val = 0;
			// reporting
			errlog('key',$h);errlog('session',$session);errlog('event_id',$e);errlog('time',$tf);errlog('tags',$tagvals);
		}
		else{
			// or log error message to DB & locally
			errlog("EVENT_ID_ERROR","invalid event_id",$e);
			errlog("EVENT_ID_ERROR_SQL",mysql_error(),mysql_errno());
			$add_row = "INSERT INTO Session (hash_number,usession_id,event_id,c_timestamp$tagnums,errors)";
			$add_row .= " VALUES ('$h','$session','ERROR','$tf'$tagvals,'invalid event_id: $e');";
			$ret_val = -1;
			//reporting
			errlog('key',$h);errlog('session',$session);errlog('event_id',$e);errlog('time',$tf);errlog('tags',$tagvals);
		}
		if( ! $result = $db_obj->query($add_row) ){
			errlog("DB_WRITE_ERROR","error writing to db",$e);
			errlog("DB_WRITE_ERROR_SQL",mysql_error(),mysql_errno());
			sendback(-1);
		}
		else{
			sendback($ret_val);
		}
	}
	else{
		// or log error message to DB & locally
		errlog("EVENT_QUERY_ERROR","query error with event_id",$event);
		errlog("EVENT_QUERY_ERROR_SQL",mysql_error(),mysql_errno());
		sendback(-1);
	}

}
?>