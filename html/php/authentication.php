<?php
session_start();
include ("../php/mysqli.php");

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
$suERRpwm ="pwm" ; // Password Mismatch
$suERRivu ="ivu" ; // Invalid Username: must be ASCII Alphanumberic (plus - and _), and contain between 6 and 20 characters.
$suERRivn ="ivn" ; // Invalid Real Name: At least one name field (first or last) must contain UTF8 letters.
$suERRivp ="ivp" ; // Invalid Password: must be between 8 and 20 characters
$suERRive ="ive" ; // Invalid Email Address: must contain an @ and at least one . after the @.
$suERRnuu ="nuu" ; // Non-Unique Username: Username already taken.
$suERRnue ="nue" ; // Non-Unique Email: An Email address can only be registered once.
$suERRdbe ="dbe" ; // Error Writing to DB

// LOGIN ERROR MESSAGES
$loginERR ="upf" ; // User/Pass Authenication Fail

// SUCCESS MESSAGES:
$loginMSG ="login_ok" ; // Login Success
$logoutMSG="logout_ok" ; // Logout Success
$signupMSG="signup_ok" ; // Sign Up Success

/* * * * * "Main" Form Processing * * * * */

// LOGIN FORM
if(isset($_GET['login'])){
  unset($_GET['login']);
  // authenticate in DB
	$login = authenticate($_POST["uid"], $_POST["password"]);
	if($login == $_POST["uid"]){
    // login successful
    write_url($successTAIL,$loginMSG); 
	}else{
    // authentication failed - invalid user/password
    set_error($loginERR);
    write_url($errorTAIL,$errorMSG); 
	}
}

// SIGNUP FORM
else if(isset($_GET['signup'])){
  unset($_GET['signup']);
  // validate form entries
  if(verify_form($_POST["uid"], $_POST["last"], $_POST["first"], $_POST["email"], $_POST["nPassword"], $_POST["confPassword"])){
    // add user to DB
    if(add_member($_POST["uid"], $_POST["last"], $_POST["first"], $_POST["email"], $_POST["nPassword"])){
      // successfully added, automatically login
      $_SESSION['userid']=$_POST["uid"];
      write_url($successTAIL,$signupMSG);
    }else{
      // Failed to add user
      write_url($errorTAIL,$errorMSG);
    }
	}else{
    // validation failed
		write_url($errorTAIL,$errorMSG);
	}
}

// LOGOUT REQUEST
else if(isset($_GET['logout'])){
	logout();
}
//header("Location: $rootURL");
//die();

/* Verify Form Function 
 * Input: USER, LASTNAME, FIRSTNAME, EMAIL, PASSWORD, CONFIRMPASSWORD
 * Return: Boolean: TRUE if form validates, else FALSE
 */
function verify_form($un, $ln, $fn, $em, $p1, $p2){
  global $suERRpwm, $suERRivu, $suERRivn, $suERRive, $suERRivp;
    $flag = true;
    // Username: alphanumeric-_ 6-20 chars
    $userx = "/^[A-Za-z0-9_\-]{6,20}$/";
    // Name: one or more ASCII or UTF-8 letters
    $namex = "/^[A-Za-z\\p{L}]+$/u";
    // Email: contains an @ with at least one . following it: [any]@[any].[any]
    $emailx = "/^[^@]+?@([^@\\.]+?)(\\.([^@\\.])+?)+$/";
    // Password: 8-20 characters, any chars
    $passx = "/[^\\n]{8,20}/"; //"/^[\w\d]{8,20}$/";

    // Check for Password Mismatch
    if($p1 != $p2){
        $flag = false;
        set_error($suERRpwm);
    }
    // Check valid username
    if(!preg_match($userx,$un)){
        $flag = false;
        set_error($suERRivu);
    }
    // Check valid name: need at least one name
    if(!(preg_match($namex,$fn)||preg_match($namex, $ln))){
        $flag = false;
        set_error($suERRivn); // 
    }
    // check valid email
    if(!preg_match($emailx,$em)){
        $flag = false;
        set_error($suERRive);
    }
    // check valid password length
    if(!preg_match($passx,$p1)){
        $flag = false;
        set_error($suERRivp);
    }
    return $flag;
}

/* Add Member Function
 * Input: USERNAME, LASTNAME, FIRSTNAME, EMAIL, PASSWORD
 * Returns: Boolean: TRUE if added successfully to DB, else FALSE
 * Exceptions: checks for unique username & email address, returns FALSE if not
 */
function add_member($uid1, $last1, $first1, $email1, $passwd1)
{ 
  global $db_obj, $suERRdbe, $suERRnuu, $suERRnue;

  // strip strings for security
  $uid=$db_obj->escape_string($uid1);      // (A)
  $last=$db_obj->escape_string($last1);
  $first=$db_obj->escape_string($first1);
  $email=$db_obj->escape_string($email1);
  $pass=$db_obj->escape_string($passwd1);  // (B)
  
  // check for uniqueness of username
  $unique=true;
  $uniqueUser=$db_obj->query("SELECT * FROM Members WHERE username ='$uid'");
  if($uniqueUser->num_rows != 0){
    set_error($suERRnuu);
    $unique=false;
  }
  
  // check for uniqueness of email addr
  $uniqueEmail=$db_obj->query("SELECT * FROM Members WHERE email ='$email'");
  if($uniqueEmail->num_rows != 0){
    set_error($suERRnue);
    $unique=false;
  }

  if(!$unique)
    // if not unique, ERROR
    return false;
  
  // insert new user into the DB
  $query="INSERT INTO Members(first, last, email, username, password) VALUES('$first',  
             '$last', '$email', '$uid', PASSWORD('$pass'))"; // (D)
  $result = $db_obj->query($query);                    // (E)

  if($result){
    // user added successfully, return the username
    return $result;
  }else{
    // failed to write to the DB, ERROR
    set_error($suERRdbe);
    return false;
  }
}

function authenticate($uid, $pass)
{  global $db_obj;
   $userid=$db_obj->escape_string($uid);
   $passwd=$db_obj->escape_string($pass);
   $query="SELECT * FROM Members WHERE username ='$userid' AND password = PASSWORD('$passwd')";            // (F)

   if ( ($result = $db_obj->query($query))           // (G)
            && $result->num_rows == 1 ){  
			// success!
				$_SESSION['userid']=$userid;
				
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
  global $errorMSG;
  if($errorMSG==""){
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
    $errorMSG.="&".$e;
}

function write_url($u,$m){

  global $rootURL;
  $finalURL = $rootURL . $u;
  if($m!="")
    $finalURL .= "?" . $m;
  header("Location: $finalURL");
  die();
  //echo "<script>window.location='$finalURL';
}

function logout(){
  global $errorTAIL, $logoutMSG;
	$_SESSION = array();
  $_GET = array();
  $_POST = array();
	session_destroy();
  write_url($errorTAIL,$logoutMSG);
}
?>
</body>
</html>