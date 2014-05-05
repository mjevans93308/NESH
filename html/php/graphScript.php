<?php
include("../php/mysqli.php");

$debug = false;
global $db_obj;
$return_arr = array();
//$filter_arr = array();

class line {
	public $_k = "";
	public $_x = array();
	public $_y = array();

	public function __construct(){
		$this->_k = "";
		$this->_x = array();
		$this->_y = array();
	}

    public function addXY($x,$y){
    	global $debug;
    	if($debug==true){echo "($x,$y)";}
    	$this->_x[]=$x;
    	$this->_y[]=$y;
    }
    
    public function setKey($k){
    	$this->_k = $k;
    }

    public function getJSON(){
    	global $debug;
    	$xstr = "[\"".implode("\",\"", $this->_x)."\"]";
    	$ystr = "[".implode(",", $this->_y)."]";
    	if($debug==true){echo "\"$this->_k\":{\"x\":$xstr,\"y\":$ystr}";}
    	return "\"$this->_k\":{\"x\":$xstr,\"y\":$ystr}";
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
		if($str[0] == "{" || $str[0] == "[" )
			$prejoin[] = "\"$tag\":$str";
		else
			$prejoin[] = "\"$tag\":\"$str\"";
	}
	$echostring = join(",",$prejoin);
	echo "{".$echostring."}";
	exit($rval);
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

	$q_view = "CREATE VIEW V$hash_number AS SELECT * from Session WHERE hash_number=$hash_number";
	$q_drop = "DROP VIEW V$hash_number;";

	// IF Nothing Selected : Event Lines
	// IF Only Event Selected : All Tag Lines
	// IF Tag Selected with no specifics: All Line within that tag
	// If Tag Selected with Specifics: use spec to limit view
	
	if(!isset($_POST['event_id'])&&!isset($_POST['tag0'])&&!isset($_POST['tag1'])&&!isset($_POST['tag2'])&&!isset($_POST['tag3'])&&!isset($_POST['tag4'])){
		// get all event_id's
		// get all tags for all events 
	}

	if(isset($_POST['event_id'])){
		$event_id = $_POST['event_id'];
		$q_view .= " AND event_id=$event_id";
	}else{
		$all_arr[] = "event_id";
		$evt_arr = $array();
		$q_events = "SELECT event_id FROM Events WHERE hash_number=$hash_number";
		if ( $evt_result = $db_obj->query($q_events)){
			if( $evt_result->num_rows > 0 ){
				while($evt_row = $evt_result->fetch_assoc()){
					$evt_arr[] = $evt_row['event_id'];
					if($debug == true){echo "event[]=".$evt_row['event_id'];}
				}
				if( $result = $db_obj->query($q_view)){

				}
			}else{
				errlog("DB_GRAPHING_NO_EVENTS","db returned 0 rows for events for hash",$hash_number);
			}
		}else{
			errlog("DB_ERROR_EVENT_COUNT","error counting events for hash",$hash_number);
			errlog("DB_ERROR_EVENT_COUNT_SQL",mysql_error(),mysql_errno());
			sendback(-1);
		}
	}

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
				$q_view .= " AND ($tagNum='".implode("' OR $tagNum='", $tagSet)."')";
			}
		}
	}
	$q_view .= ";";
	/////////////////////////////////////////////
	// CREATE VIEW
	
	if ( ! $result = $db_obj->query($q_view)){
		errlog("DB_ERROR_CREATE_VIEW","error creating view",$q_view);
		errlog("DB_ERROR_CREATE_VIEW_SQL",mysql_error(),mysql_errno());
		sendback(-1);
	}

	/////////////////////////////////////////////
	// CREATE VIEW

	$filter_arr = array();

	foreach( $all_arr as $filter ){
		$filter_arr[$filter] = array();
		$q_count = "SELECT $filter AS TAG, DATE( c_timestamp ) AS DAY, COUNT( * ) AS CNT FROM V$hash_number GROUP BY $filter, DATE( c_timestamp );";
		if ( $result = $db_obj->query($q_count)){
			if( $result->num_rows > 0 ){
				//$row = $result->fetch_assoc();
				while($row = $result->fetch_assoc()){
					$tagstr = $row['TAG'];
					if($debug == true){echo "filterarr[".$filter."][".$tagstr."]=";}
					if(!isset($filter_arr[$filter][$tagstr])){
						$filter_arr[$filter][$tagstr] = new line();
						$filter_arr[$filter][$tagstr]->setKey($tagstr);
					}
					$filter_arr[$filter][$tagstr]->addXY($row['DAY'],$row['CNT']);
				}
				$tempArr = array();
				foreach($filter_arr[$filter] as $filterItem){
					$tempArr[] = $filterItem->getJSON();
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