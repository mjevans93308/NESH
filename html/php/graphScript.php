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
		$events = $_POST['event_id'].split(",");
		//$query_event = "SELECT * from $hash_number WHERE (event_id =".$events.join(" OR event_id=").")";
		$final_query .= "(event_id =".$events.join(" OR event_id=").")";	
	}

	if(isset($_POST['tag0']))
	{
		$tags0 = $_POST['tag0'].split(',');
		//$query_tag0 = "SELECT * from $hash_number WHERE (tag0 =".$tags0.join(" OR tag0=").")";
		$final_query .= "AND (tag0 =".$tags0.join(" OR tag0=").")";
	}
	if(isset($_POST['tag1']))
	{
		$tags1 = $_POST['tag1'].split(',');
		//$query_tag1 = "SELECT * from $hash_number WHERE (tag1 =".$tags1.join(" OR tag1=").")";
		$final_query .= "AND (tag1 =".$tags1.join(" OR tag1=").")";
	}
	if(isset($_POST['tag2']))
	{
		$tags2 = $_POST['tag2'].split(',');
		//$query_tag2 = "SELECT * from $hash_number WHERE (tag2 =".$tags2.join(" OR tag2=").")";
		$final_query .= "AND (tag2 =".$tags2.join(" OR tag2=").")";
	}
	if(isset($_POST['tag3']))
	{
		$tags3 = $_POST['tag3'].split(',');
		//$query_tag3 = "SELECT * from $hash_number WHERE (tag3 =".$tags3.join(" OR tag3=").")";
		$final_query .= "AND (tag3 =".$tags3.join(" OR tag3=").")";
	}
	if(isset($_POST['tag4']))
	{
		$tags4 = $_POST['tag4'].split(',');
		//$query_tag4 = "SELECT * from $hash_number WHERE (tag4 =".$tags4.join(" OR tag4=").")";
		$final_query .= "AND (tag4 =".$tags4.join(" OR tag4=").")";
	}
	

	if(isset($_POST['event_id'])){
		echo "recieved event_id=".$_POST['event_id'];
	}
	else
		echo "didn't recieve anythings";

	
}
else
	echo  "Didn;t even get here";
?>