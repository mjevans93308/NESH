<?php
include("../php/mysqli.php");


if(isset($_POST)){
	/*
	$events = new Array();
	$tags0 = new Array();
	$tags1 = new Array();
	$tags2 = new Array();
	$tags3 = new Array();
	$tags4 = new Array();
	*/

	$q_view = "CREATE VIEW $hash_number AS SELECT * from Session WHERE hash_number = $hash_number";
	$q_drop = "DROP VIEW $hash_number";
	$final_query = "CREATE VIEW $hash_number AS SELECT * from $hash_number WHERE ";


	if(isset($_POST['hash_number']))
		$hash_number = $_POST['hash_number'];
	
	if(isset($_POST['event_id']))
	{
		//$events = $_POST['event_id'].split(",");
		$events = explode(",", $_POST['event_id']);
		//$final_query .= "(event_id =".$events.join(" OR event_id=").")";
		$final_query = "(event_id =".implode(" OR event_id=", $events).")";
	}

	if(isset($_POST['tag0']))
	{
		//$tags0 = $_POST['tag0'].split(',');
		$tags0 = explode(",", $_POST['tag0']);
		//$final_query .= "AND (tag0 =".$tags0.join(" OR tag0=").")";
		$final_query = "AND (tag0 =".implode(" OR tag0=", $tags0).")";
	}
	if(isset($_POST['tag1']))
	{
		//$tags1 = $_POST['tag1'].split(',');
		$tags1 = explode(",", $_POST['tag1']);
		//$final_query .= "AND (tag1 =".$tags1.join(" OR tag1=").")";
		$final_query = "AND (tag1 =".implode(" OR tag1=", $tags1).")";
	}
	if(isset($_POST['tag2']))
	{
		//$tags2 = $_POST['tag2'].split(',');
		$tags2 = explode(",", $_POST['tag2']);
		//$final_query .= "AND (tag2 =".$tags2.join(" OR tag2=").")";
		$final_query = "AND (tag2 =".implode(" OR tag2=", $tags2).")";
	}
	if(isset($_POST['tag3']))
	{
		//$tags3 = $_POST['tag3'].split(',');
		$tags3 = explode(",", $_POST['tag3']);
		//$final_query .= "AND (tag3 =".$tags3.join(" OR tag3=").")";
		$final_query = "AND (tag3 =".implode(" OR tag3=", $tags3).")";
	}
	if(isset($_POST['tag4']))
	{
		//$tags4 = $_POST['tag4'].split(',');
		$tags4 = explode(",", $_POST['tag4']);
		//$final_query .= "AND (tag4 =".$tags4.join(" OR tag4=").")";
		$final_query = "AND (tag4 =".implode(" OR tag4=", $tags4).")";
	}
	

	if(isset($_POST['event_id'])){
		echo "recieved event_id=".$_POST['event_id'];
	}
	else
		echo "didn't recieve anythings";

	
}
else
	echo  "Didn't even get here";
?>