<?php
	session_start();
	if(!isset($_SESSION['userid'])){
			header("Location: ../index.php");
	}
?>


<html>
	<body>
    <?php
		include ("../php/mysqli.php");
		global $db_obj;
		
    	if(isset($_GET['newproj'])){
			//getting the uid
			$query = "SELECT * FROM Members where username = '".$_SESSION['userid']."'";
			if ( ($result = $db_obj->query($query))&& $result->num_rows == 1 ){  
				while ($row = $result->fetch_assoc()) {
					$userIdNum = $row['uid'];
				}
			}
			
			//echo $userIdNum;
			$product = $db_obj->escape_string($_POST['projectName']);
			//echo $product;
			
			
			
			$totalTags = 0;
			$totalEvents = 0;
			
			while($totalTags < 5){
				foreach($_POST['tagArr'] as $cnt => $tagArr){
					if($tagArr != NULL){
						${'tag_id' . $totalTags} = $tagArr;
						$totalTags = $totalTags + 1;
					}
				}
				${'tag_id' . $totalTags} = $_POST['tag'];
				$totalTags = $totalTags + 1;
				break;
			}
			
			if($totalTags != 4){ //assigning null to the total tags that not have been set yes
			//Doing this so that it will be easier for me to insert. 
				for($c = $totalTags; $c < 5; $c++){
					${'tag_id'.$totalTags} = NULL;
				}
			}
			
			$query2 = "INSERT INTO Products (product, uid, tag0, tag1, tag2, tag3, tag4) VALUES('$product', '$userIdNum', '$tag_id0', '$tag_id1', '$tag_id2', '$tag_id3', '$tag_id4')";
			//echo $query2;
			if ( ($result2 = $db_obj->query($query2))){
				$insertProd = true;
				$regComplete = true;
				//echo "Inserted into Prodcuts";
			}
			else{
				$insertProd = false;
				$regComplete = false;
				//echo "Error inserting into products";
			}
			
			if($insertProd){
				
				$query3 = "SELECT * FROM Products where product = '".$product."'";
				if ( ($result3 = $db_obj->query($query3))&& $result3->num_rows == 1 ){  
					while ($row3 = $result3->fetch_assoc()) {
						$prodIdNum = $row3['pid'];
					}
				}
				//echo $prodIdNum;
				$hash_Num = hashGenerate($userIdNum, $prodIdNum);
				$query5 = "INSERT into Hash_Products (pid, hash_number) VALUES ('$prodIdNum', '$hash_Num')";
				if ( ($result5 = $db_obj->query($query5))){
					$regComplete = true;
					//echo "Inserted into Hash_Prodcuts";
				}
				else{
					$regComplete = false;
					//echo "Error inserting into Hash_products";
				}
			
			
			foreach($_POST['eventArr'] as $cnt => $eventArr){
				if($eventArr != NULL){
					${'event_id' . $totalEvents} = $eventArr;
					$totalEvents = $totalEvents + 1;
				}
			}
			${'event_id' . $totalEvents} = $_POST['events'];
			$totalEvents = $totalEvents + 1;
			
			for($i = 0; $i < $totalEvents; $i++){
				$eventNum = $db_obj->escape_string(${'event_id' . $i});
				$query1 = "INSERT INTO Events (hash_number, description) VALUES('$hash_Num', '$eventNum')";
				if($db_obj->query($query1)){
					$regComplete = true;
					//echo "Inserted into events";
				}
			}
			}
			
			if($regComplete){
				echo "<script>window.location= 'http://nesh.co/basicPages/first.php'</script>";
			}
		}
		
		
		function hashGenerate($uid, $pid){
			global $db_obj;
			if ( ($result4 = $db_obj->query("SELECT * FROM Products")) ){ 
				$count = $result4->num_rows;
			}
			$hashNum = $uid.$pid.$count;
			return $hashNum;
		}
		
	?>
	</body>
</html>