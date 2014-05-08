<?php
include("../php/mysqli.php");

/* Behavior
 * IF ! Hash : Die with error
 * IF ! Type : Return Thruput
 * Else, Return Type
 	"thru" : Thruput/Funnel Graph
 	"events" : events versus date
 	""
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

	$q_view = "CREATE VIEW V$hash_number AS SELECT * from Session WHERE hash_number=$hash_number;";
	$q_drop = "DROP VIEW V$hash_number;";

	// 1. Filter By Hash
	// 2. check for an _ALL tag# or event_id
	// 3. setup count query
	// 4. return data 
	
	$empty = true;

	if(isset($_POST['event_id'])){
		if($_POST['event_id']=="_ALL"){
			$trend = "event_id";
			$empty = false;
		}
	}
	for( $t = 0 ; $t < 5 && $empty ; $t++ ){
		$tagNum = "tag".$t;
		if(isset($_POST[$tagNum]))
		{
			if($_POST[$tagNum] == "_ALL"){
				$trend = $tagNum;
				$empty = false;
			}
		}
	}

	if($empty){
		errlog("POST_ERROR_NO_ALL","no filters POSTed with value _ALL");
		sendback(-1);
	}

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

	$q_count = "SELECT $trend AS TREND, COUNT( * ) AS CNT FROM V$hash_number GROUP BY $trend;";
	if ( $result = $db_obj->query($q_count)){
		if( $result->num_rows > 0 ){
			while($row = $result->fetch_assoc()){
				$tagstr = $row['TREND'];
				//if($debug == true){echo "filterarr[".$trend."][".$tagstr."]=";}
				if(!isset($filter_arr[$trend][$tagstr])){
					$filter_arr[$trend][$tagstr] = new line();
					$filter_arr[$trend][$tagstr]->setKey($tagstr);
				}
				$filter_arr[$trend][$tagstr]->addXY($row['TREND'],$row['CNT']);
			}
			$tempArr = array();
			foreach($filter_arr[$trend] as $filterItem){
				$tempArr[] = $filterItem->getJSON();
			}
			$tags_arr[$trend] = "{".implode(",", $tempArr)."}";
		}else{
			errlog("DB_ERROR_EMPTY_RETURN","db returned 0 rows for trend",$trend);
			//sendback(-1);
		}
	}else{
		errlog("DB_ERROR_COUNT","error counting trend",$trend);
		errlog("DB_ERROR_COUNT_SQL",mysql_error(),mysql_errno());
		sendback(-1);
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
	errlog("POST_ERROR_NO_DATA","no data sent by POST");
	sendback(-1);
}
?>