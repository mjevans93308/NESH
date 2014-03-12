<?php
session_start();
include ("../php/mysqli.php");
?>

<html>
<body>
<?php

/*
 * File: authentication.php
 * 
 * Description:
 * Users sign in/up/out.
 * 
 * Note: There are a few sets of variables to be set/referenced just after this header.
 *  - URL variables are for the destination locations for success/failure of authentication
 *    - Note: logout goes to errorTAIL
 *  - FORM variables are the expected names of the form variables
 *    - $variables names are for internal use, if I decide to use them
 *    - "" values are the names of the variables expected from the form
 *  - ERROR MESSAGES are the variables that will be passed by GET indicating success/failure
 *    - They must be checked for in the scripts and printed in DIVs
 *    - This should be eventually placed in another php file for easier use
 */


// URL VARIABLES:
$rootURL="http://nesh.co/";
$successTAIL="basicPages/first.php";
$errorTAIL="index.php";
//$successURL=$rootURL+$successTAIL;
//$errorURL=$rootURL+$errorTAIL;
$errorMSG="";

/* 
//FORM VARIABLES:
//$_GET[]:
$login = "login";        // login form referral
$sign  = "signup";       // sign up form referral
$logout= "logout";       // logout message
//$_POST[]:
$user = "uid";           // username
$passL = "password";     // password - Login Form
$pass1 = "nPassword";    // password - Sign Up Form
$pass2 = "confPassword"; // password - Sign Up Form confirmation
$fname = "first";        // first name
$lname = "last";         // last name
$email = "email";        // email address
*/

// SIGNUP ERROR MESSAGES:
$suERRpwm ="pwm=1" ; // Password Mismatch
$suERRivu ="ivu=1" ; // Invalid Username
$suERRivn ="ivn=1" ; // Invalid Name
$suERRivp ="ivp=1" ; // Invalid Password
$suERRive ="ive=1" ; // Invalid Email Address
$suERRdbe ="dbe=1" ; // Error Writing to DB

// LOGIN ERROR MESSAGES
$loginERR ="upf=1" ; // User/Pass Authenication Fail

// SUCCESS MESSAGES:
$loginMSG ="lis=1" ; // Login Success
$logoutMSG="los=1"
$signupMSG="sus=1" ; // Sign Up Success

/* * * * * "Main" Form Processing * * * * */

// LOGIN FORM
if(isset($_GET['login'])){
  // authenticate in DB
	$login = authenticate($_POST["uid"], $_POST["password"]);
	if($login == $_POST["uid"]){
    // login successful
    write_url($successTAIL,$loginMSG); //echo "<script>window.location='$successURL?$loginMSG</script>";
	}else{
    // authentication failed - invalid user/password
    set_error($loginERR);
    write_url($errorTAIL,$errorMSG); //echo "<script>window.location='$errorURL?$errorMSG'</script>";
	}
  unset($_GET['login']);
}

// SIGNUP FORM
else if(isset($_GET['signup'])){
  // validate form entries
  if(verify_form($_POST["uid"], $_POST["last"], $_POST["first"], $_POST["email"], $_POST["nPassword"], $_POST["confPassword"])){
    // add user to DB
    if(add_member($_POST["uid"], $_POST["last"], $_POST["first"], $_POST["email"], $_POST["nPassword"])){
      // successfully added, automatically login
      write_url($successTAIL,$signupMSG); //echo "<script>window.location='$successURL?$signupMSG'</script>";
    }else{
      // DB write failed - DB? double user? 
      set_error($suERRdbe);
      write_url($errorTAIL,$errorMSG);
    }
	}else{
		write_url($errorTAIL,$errorMSG);
	}
  unset($_GET['signup']);
}

else if(isset($_GET['logout'])){
	logout();
	//unset($_SESSION['userid']);
	//echo "<script>window.location= 'http://nesh.co/index.php'</script>";

}

function verify_form($un, $ln, $fn, $em, $p1, $p2){
    $flag = true;
    $userx = "/^[A-Za-z0-9_\-]{6,20}$/";
    $namex = "/^[A-Za-z\\p{L}]*$/u";
    $emailx = "/^[^@]+?@([^@\\.]+?)(\\.([^@\\.])+?)+$/";
    $passx = "/^[a]{8,20}$/";

    if($p1 != $p2){
        $flag = false;
        //echo '<p>Passwords do not match!</p>';
        set_error($suERRpwm);
    }
    if(!preg_match($userx,$un)){
        $flag = false;
        set_error($suERRivu);
        //echo '<p>Invalid Username: must be ASCII Alphanumberic (plus - and _), and contain between 6 and 20 characters.</p>';
    }
    if(!preg_match($namex,$fn)&&!preg_match($namex, $ln)){
        $flag = false;
        set_error($suERRivn);
        //echo '<p>Invalid Real Name: At least one name field (first or last) must contain UTF8 letters.</p>';
    }
    if(!preg_match($emailx,$em)){
        $flag = false;
        set_error($suERRive);
        //echo '<p>Invalid Email Address: must contain an @ and at least one . after the @.</p>';
    }
    if(!preg_match($passx,$p1)){
        $flag = false;
        set_error($suERRivp);
        //echo '<p>Invalid Email Address: must contain an @ and at least one . after the @.</p>';
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

function set_error($e){
  if($errorMSG=""){
    $errorMSG=$e;
    // backup form data for reuse
    if(isset($_GET['login'])){
      if(isset($_POST['uid'])){
        $_SESSION['uid']=$_POST['uid'];
      }
    }else if(isset($_GET['signup'])){
      if(isset($_POST['uid']))
        $_SESSION['uid']=$_POST['uid'];
      if(isset($_POST['last']))
        $_SESSION['last']=$_POST['last'];
      if(isset($_POST['first']))
        $_SESSION['first']=$_POST['first'];
      if(isset($_POST['email']))
        $_SESSION['email']=$_POST['email'];
    }
  }else
    $errorMSG+="&".$e
}

function write_url($u,$m){
  $finalURL = $rootURL . $u;
  if($m!='')
    $finalURL += "?" . $m;
  echo "<script>window.location='$finalURL'</script>"
}

function logout(){
	$_SESSION = array();
	session_destroy();
	//echo "<script>window.location= 'http://nesh.co/index.php'</script>";
  write_url($errorTAIL,$logoutMSG);
}
?>
</body>
</html>