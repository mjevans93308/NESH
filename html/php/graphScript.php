<?php
include("../php/mysqli.php");

global $db_obj;
$return_arr = array();
//$filter_arr = array();

class line {
	public $_k = "";
	public $_x = array();
	public $_y = array();

    public function addXY($x,$y){
    	$_x[] = $x;
    	$_y[] = $y;
    }
    
    public function setKey($k){
    	$_k = $k;
    }

    public function getJSON(){
    	$xstr = "[".implode(",", $_x)."]";
    	$ystr = "[".implode(",", $_y)."]";
    	return "\"$_k\":{\"x\":\"$xstr\",\"y\":\"$ystr\"}";
    }
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

if(isset($_POST)){
	/*
	$events = array();
	$tags0 = array();
	$tags1 = array();
	$tags2 = array();
	$tags3 = array();
	$tags4 = array();
	*/

	// 1. CREATE VIEW with $hash_number & event & any filters
	// 2. Loop through tag_alls
	// 		a. select/count query
	//		b. build JSON element
	//		c. add to array
	// 3. Return function

//	$final_query = "CREATE VIEW $hash_number AS SELECT * from $hash_number WHERE ";
	$all_arr = array();

	/////////////////////////////////////////////
	// Assemble View Query & Prep for Counts

	if(isset($_POST['hash_number'])){
		$hash_number = $_POST['hash_number'];
	}else{
		errlog("HASH_ERROR","no hash received");
		sendback(-1);
	}
	
	if(isset($_POST['event_id'])){
		$event_id = $_POST['event_id'];
		$q_view .= " AND event_id = $event_id";
	}else{
		$all_arr[] = "event_id";
		//$events = $_POST['event_id'].split(",");
		//$events = explode(",", $_POST['event_id']);
		//$final_query .= "(event_id =".$events.join(" OR event_id=").")";
		//$final_query = "(event_id =".implode(" OR event_id=", $events).")";
	}

	$q_view = "CREATE VIEW $hash_number AS SELECT * from Session WHERE hash_number = $hash_number";
	$q_drop = "DROP VIEW $hash_number";

	for( $t = 0 ; $t < 5 ; $t++ ){
		$tagNum = "tag".$t;
		if(isset($_POST[$tagNum]))
		{
			if($_POST[$tagNum] == "_ALL"){
				$all_arr[] = $tagNum;
			}else{
				//$tags0 = $_POST['tag0'].split(',');
				$tagSet = explode(",", $_POST[$tagNum]);
				//$final_query .= "AND (tag0 =".$tags0.join(" OR tag0=").")";
				$q_view .= " AND ($tagNum =".implode(" OR $tagNum=", $tagSet).")";
			}
		}
	}

	/////////////////////////////////////////////
	// CREATE VIEW
	
	if ( ! $result = $db_obj->query($q_view)){
		errlog("DB_ERROR_CREATE_VIEW","error creating view",$hash_number);
		errlog("DB_ERROR_CREATE_VIEW_SQL",mysql_error(),mysql_errno());
		sendback(-1);
	}

	/////////////////////////////////////////////
	// CREATE VIEW

	$filter_arr = array();

	foreach( $all_arr as $filter ){
		$filter_arr[$filter] = array();
		$q_count = "SELECT $filter AS TAG, DATE( C_TIMESTAMP ) AS DAY, COUNT( * ) AS CNT FROM $hash_number GROUP BY  $filter, DATE( C_TIMESTAMP )";
		if ( $result = $db_obj->query($q_count)){
			if( $result->num_rows > 0 ){
				$row = $result->fetch_assoc();
				while($row = $result->fetch_assoc()){
					if(!isset($filter_arr[$filter][$row['TAG']])){
						$filter_arr[$filter][$row['TAG']] = new line();
						$filter_arr[$filter][$row['TAG']].setKey($row['TAG']);
					}
					$filter_arr[$filter][$row['TAG']].addXY($row['DAY'],$row['CNT']);
				}
				$tempArr = array();
				foreach($filter_arr[$filter] as $filterItem){
					$tempArr[] = $filterItem.getJSON();
				}
				$return_arr[$filter] = "{".implode(",", $tempArr)."}";
			}else{
				errlog("DB_ERROR_RETURN","db returned 0 rows for filter",$filter);
				//sendback(-1);
			}
		}else{
			errlog("DB_ERROR_COUNT","error counting filter",$filter);
			errlog("DB_ERROR_COUNT_SQL",mysql_error(),mysql_errno());
			sendback(-1);
		}
	}

	////////////////////////////////////////////////
	// ALL DONE, KILL VIEW
	if ( ! $result = $db_obj->query($q_drop)){
		errlog("DB_ERROR_DROP_VIEW","error dropping view",$hash_number);
		errlog("DB_ERROR_DROP_VIEW_SQL",mysql_error(),mysql_errno());
		sendback(-1);
	}
	sendback(0);
}
else
	echo  "Didn't even get here";
?>