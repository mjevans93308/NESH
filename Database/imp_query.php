<?php
include("mysqli.php")


if(isset($_POST))
{
	/*
	0$events = new Array();
	1$tags0 = new Array();
	2$tags1 = new Array();
	3$tags2 = new Array();
	4$tags3 = new Array();
	5$tags4 = new Array();
	
	Does it need to have event_id or can it search without one.	 
	*/

	if(isset($_POST['hash_number']))
		$hash_number = $_POST['hash_number'];

	$queryset = array();
	$q_view = "CREATE VIEW $hash_number AS SELECT * from Session WHERE hash_number = $hash_number";
	$q_drop = "DROP VIEW $hash_number";
	$final_query = "CREATE VIEW $hash_number AS SELECT * from $hash_number WHERE ";

	if(isset($_POST['event_id']))
	{
		$events = $$_POST['event_id'].split(",");
		//$query_event = "SELECT * from $hash_number WHERE (event_id =".$events.join(" OR event_id=").")";
		$queryset[] = "(event_id =".$events.join(" OR event_id=").")";	
	}

	if(isset($_POST['tag0']))
	{
		$tags0 = $_POST['tag0'].split(',');
		//$query_tag0 = "SELECT * from $hash_number WHERE (tag0 =".$tags0.join(" OR tag0=").")";
		$queryset[] = "(tag0 =".$tags0.join(" OR tag0=").")";
	}
	if(isset($_POST['tag1']))
	{
		$tags1 = $_POST['tag1'].split(',');
		//$query_tag1 = "SELECT * from $hash_number WHERE (tag1 =".$tags1.join(" OR tag1=").")";
		$queryset[] = "(tag1 =".$tags1.join(" OR tag1=").")";
	}
	if(isset($_POST['tag2']))
	{
		$tags2 = $_POST['tag2'].split(',');
		//$query_tag2 = "SELECT * from $hash_number WHERE (tag2 =".$tags2.join(" OR tag2=").")";
		$queryset[] = "(tag2 =".$tags2.join(" OR tag2=").")";
	}
	if(isset($_POST['tag3']))
	{
		$tags3 = $_POST['tag3'].split(',');
		//$query_tag3 = "SELECT * from $hash_number WHERE (tag3 =".$tags3.join(" OR tag3=").")";
		$queryset[] = "(tag3 =".$tags3.join(" OR tag3=").")";
	}
	if(isset($_POST['tag4']))
	{
		$tags4 = $_POST['tag4'].split(',');
		//$query_tag4 = "SELECT * from $hash_number WHERE (tag4 =".$tags4.join(" OR tag4=").")";
		$queryset[] = "(tag4 =".$tags4.join(" OR tag4=").")";
	}
	$final_query .= queryset.join(" AND ");

	//$dia = is the date being passed to me that will be seen on chart
	//$more_query selects distinct tags from the tag that is selected in the range of whatever date to present time.
	$more_query = "SELECT DISTINCT $tagnum from $hash_number WHERE DATEDIFF(CURDATE(), DATE($dia))";
	
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
	

	
}

?>