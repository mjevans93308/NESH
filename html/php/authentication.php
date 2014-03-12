<?php
	session_start();
?>
<html>
<body>
<?php
include ("../php/mysqli.php");
$error="";
if(isset($_GET['login'])){
	$login = authenticate($_POST["uid"], $_POST["password"]);
	if($login == $_POST["uid"]){
		//header("Location: basicpages/first.php");
		echo "<script>window.location= 'http://nesh.co/basicPages/first.php'</script>";
		unset($_GET['login']);
	}
	else{
		echo "<script>window.location= 'http://nesh.co/index.php'</script>";
	}
}
else if(isset($_GET['signup'])){
  if(verify_form($_POST["uid"], $_POST["last"], $_POST["first"], $_POST["email"], $_POST["nPassword"], $_POST["confPassword"])){
    //if($_POST["nPassword"] == $_POST["confPassword"]){
    //		$flag = add_member($_POST["uid"], $_POST["last"], $_POST["first"], $_POST["email"], $_POST["nPassword"]);
    if(add_member($_POST["uid"], $_POST["last"], $_POST["first"], $_POST["email"], $_POST["nPassword"])){//($flag == true){	
      echo "<script>window.location= 'http://nesh.co/index.php'</script>";
    	unset($_GET['signup']);
    }else
    	echo("error");
    //}else{
          
    //}
	}else{
		echo '<p> "Passwords do not match!" </p>';
	}
}

else if(isset($_GET['logout'])){
	logout();
	//unset($_SESSION['userid']);
	echo "<script>window.location= 'http://nesh.co/index.php'</script>";

}

function verify_form($un, $ln, $fn, $em, $p1, $p2){
    $flag = true;
    $userx = "/^[A-Za-z0-9_\-]{6,20}$/";
    $namex = "/^[A-Za-z\\p{L}]*$/u";
    $emailx = "/^[^@]+?@([^@\\.]+?)(\\.([^@\\.])+?)+$/";
    $passx = "/^[a]{8,20}$/";

    if($p1 != $p2){
        $flag = false;
        echo '<p>Passwords do not match!</p>';
    }
    if(!preg_match($userx,$un)){
        $flag = false;
        echo '<p>Invalid Username: must be ASCII Alphanumberic (plus - and _), and contain between 6 and 20 characters.</p>';
    }
    if(!preg_match($namex,$fn)&&!preg_match($namex, $ln)){
        $flag = false;
        echo '<p>Invalid Real Name: At least one name field (first or last) must contain UTF8 letters.</p>';
    }
    if(!preg_match($emailx,$em)){
        $flag = false;
        echo '<p>Invalid Email Address: must contain an @ and at least one . after the @.</p>';
    }
    return $flag;
}

function add_member($uid1, $last1, $first1, $email1, $passwd1)
{ 
  global $db_obj;
  $uid=$db_obj->escape_string($uid1);      // (A)
  $last=$db_obj->escape_string($last1);
  $first=$db_obj->escape_string($first1);
  $email=$db_obj->escape_string($email1);
  $pass=$db_obj->escape_string($passwd1);  // (B)
 
  $query="INSERT INTO Members(first, last, email, username, password) VALUES('$first',  
             '$last', '$email', '$uid', PASSWORD('$pass'))"; // (D)
  return ($db_obj->query($query));                    // (E)
}

function authenticate($uid, $pass)
{  global $db_obj;
   $userid=$db_obj->escape_string($uid);
   $passwd=$db_obj->escape_string($pass);
   $query="SELECT * FROM Members WHERE username ='$userid'"
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
	$_SESSION = array();
	session_destroy();
	echo "<script>window.location= 'http://nesh.co/index.php'</script>";
}
?>
</body>
</html>