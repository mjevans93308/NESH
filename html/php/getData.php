<?php
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Credentials: true');
		header('Content-Type: text/html; charset=utf-8');
		if(isset($HTTP_RAW_POST_DATA)) {
  			parse_str($HTTP_RAW_POST_DATA); // here you will get variable $foo
  			//if($_POST['event_id'] == 'calcBmi') {
    			echo "<title>".$HTTP_RAW_POST_DATA."</title>";
  			//}
		}
?>