<?php
include("../php/mysqli.php");

/* Behavior
 * IF ! Hash || ! Event : Die with error
 * IF ! Tags : Return counts per day of all lines in all tags
 * IF Tag && ! Specifics: All Lines within that tag
 * If Tag Selected with Specifics: use Spec to limit view
 */

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

	// 1. CREATE VIEW with $hash_number & event & any filters
	// 2. Loop through tag_alls
	// 		a. select/count query
	//		b. build JSON element
	//		c. add to array
	// 3. Return function

	$all_arr = array();

	/////////////////////////////////////////////
	// Assemble View Query & Prep for Counts

	if(isset($_POST['hash_number'])){
		$hash_number = $_POST['hash_number'];
	}else{
		// If no hash selected, die with error
		errlog("HASH_ERROR","no hash received");
		sendback(-1);
	}

	$q_view = "CREATE VIEW V$hash_number AS SELECT * from Session WHERE hash_number=$hash_number";
	$q_drop = "DROP VIEW V$hash_number;";
	
	if(isset($_POST['event_id'])){
		$event_id = $_POST['event_id'];
		$q_view .= " AND event_id=$event_id";
	}else{
		// if no event selected, die with error
		errlog("EVENT_ERROR","no event received for hash",$hash_number);
		sendback(-1);
	}

	$emptyTags = 0;
	for( $t = 0 ; $t < 5 ; $t++ ){
		$tagNum = "tag".$t;
		if(isset($_POST[$tagNum]))
		{
			if($_POST[$tagNum] == "_ALL"){
				$all_arr[] = $tagNum;
			}else{
				$tagSet = explode(",", $_POST[$tagNum]);
				$q_view .= " AND ($tagNum='".implode("' OR $tagNum='", $tagSet)."')";
			}
		}else{
			$emptyTags++;
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
	// QUERY COUNTS

	$tags_arr = array();
	$filter_arr = array();

	// If only event selected, prep for all tag lines
	if($emptyTags==5){
		$all_arr = array("tag0","tag1","tag2","tag3","tag4");
	}else{
		if(empty($all_arr)){
			$all_arr[]="event_id"
		}
	}

	foreach( $all_arr as $filter ){
		$filter_arr[$filter] = array();
		$q_count = "SELECT $filter AS FILTER, DATE( c_timestamp ) AS DAY, COUNT( * ) AS CNT FROM V$hash_number GROUP BY $filter, DATE( c_timestamp );";
		if ( $result = $db_obj->query($q_count)){
			if( $result->num_rows > 0 ){
				//$row = $result->fetch_assoc();
				while($row = $result->fetch_assoc()){
					$tagstr = $row['FILTER'];
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
				$tags_arr[$filter] = "{".implode(",", $tempArr)."}";
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

	$prejoin = array();
	foreach($tags_arr as $tag => $str){
		$prejoin[] = "\"$tag\":$str";
	}
	$return_arr["tags"]="{".join(",",$prejoin)."}";

	

	////////////////////////////////////////////////
	// ALL DONE, KILL VIEW
	if ( ! $result = $db_obj->query($q_drop)){
		errlog("DB_ERROR_DROP_VIEW","error dropping view",$hash_number);
		errlog("DB_ERROR_DROP_VIEW_SQL",mysql_error(),mysql_errno());
		sendback(-1);
	}
	sendback(0);
}else{
	errlog("POST_ERROR","no POST data received");
	sendback(-1);
}
?>