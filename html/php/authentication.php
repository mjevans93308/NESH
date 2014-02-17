<?php
	session_start();
	include ("../php/mysqli.php");
?>
<html>
<body>
<?php

if(isset($_GET['login'])){
	$login = authenticate($_POST["uid"], $_POST["password"]);
	if($login == $_POST["uid"]){
		unset($_GET['login']);
		echo "<script>window.location= 'http://nesh.co/basicPages/first.php'</script>";
	}
}
else if(isset($_GET['signup'])){
	if($_POST["nPassword"] == $_POST["confPassword"]){
		$flag = add_member($_POST["uid"], $_POST["last"], $_POST["first"], $_POST["email"], $_POST["nPassword"]);
		if($flag == true){	
			unset($_GET['signup']);
			echo "<script>window.location= 'http://nesh.co/basicPages/login.html'</script>";
		}
		else
			echo("error");
	}
	else{
		echo '<p> "Passwords do not match!" </p>';
	}
}

else if(isset($_GET['logout'])){
	unset($_SESSION['userid']);
	logout();
	echo "<script>window.location= 'http://nesh.co/index.html'</script>";
}

function add_member($uid1, $last1, $first1, $email1, $passwd1)
{ 
  global $db_obj;
  $uid=$db_obj->escape_string($uid1);      // (A)
  $last=$db_obj->escape_string($last1);
  $first=$db_obj->escape_string($first1);
  $email=$db_obj->escape_string($email1);
  $pass=$db_obj->escape_string($passwd1);  // (B)
  
  $query="INSERT INTO Members VALUES ('$uid','$first',  
             '$last', '$email', PASSWORD('$pass'))"; // (D)
  return ($db_obj->query($query));                    // (E)
}

function authenticate($uid, $pass)
{  global $db_obj;
   $userid=$db_obj->escape_string($uid);
   $passwd=$db_obj->escape_string($pass);
   $query="SELECT * FROM Members WHERE uid ='$userid'"
     . " AND password = PASSWORD('$passwd')";            // (F)

   if ( ($result = $db_obj->query($query))           // (G)
            && $result->num_rows == 1 ){  
			// success!
				$_SESSION['userid']=$uid;
				
				return $uid;  
			}
   else{  
   return "";  
   }
}

function change_pw($uid, $oldpw, $newpw)
{ global $db_obj;
  $uid=$db_obj->escape_string($uid);
  $oldpw=$db_obj->escape_string($oldpw);
  $newps=$db_obj->escape_string($newpw);
  if ( authenticate($uid,$oldpw) )              // (I)
  {  $query="UPDATE Members " .                  // (II)
            "SET passwd=PASSWORD('$newpw') " .
            "WHERE uid='$uid'";
     return ($db_obj->query($query));  // TRUE or FALSE
  }
  return FALSE;
}

function logout(){
killSession();
echo "<script>window.location= 'http://nesh.co/index.html'</script>";
}
?>
</body>
</html>