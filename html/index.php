<?php
	session_start();
		if(isset($_SESSION['userid'])){
			header("Location: ../basicPages/first.php");
		}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nesh.co</title>
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
     <link rel="stylesheet" type="text/css" href="styles/addon.css">
     <link rel="stylesheet" type="text/css" href="styles/style.css">
     <link href='styles/animate.min.css' rel='stylesheet' type='text/css'>
</head>

<body>
	<?php
		if(isset($_GET["pvm"])){
			echo "<script type='text/javascript'>alert('The paasword did not match! Please enter them again');</script>";
			unset($_GET["pvm"]);
		}
		else if(isset($_GET["ivu"])){
			echo "<script type='text/javascript'>alert('Invalid user name! Please enter again');</script>";
			unset($_GET["ivu"]);
		}
		else if(isset($_GET["ivn"])){
			echo "<script type='text/javascript'>alert('Please enter your name!');</script>";
			unset($_GET["ivn"]);
		}
		else if(isset($_GET["ivp"])){
			echo "<script>alert('Invalid password! Password must be atleast 8 characters');</script>";
			unset($_GET["ivp"]);
		}
		else if(isset($_GET["ive"])){
			echo "<script type='text/javascript'>alert('Invalid email address! Please enter again');</script>";
			unset($_GET["ive"]);
		}
		else if(isset($_GET["nuu"])){
			echo "<script type='text/javascript'>alert('Username already taken, Please enter a different username!');</script>";
			unset($_GET["nuu"]);
		}
		else if(isset($_GET["nue"])){
			echo "<script type='text/javascript'>alert('There is an account already associated with this email!');</script>";
			unset($_GET["nue"]);
		}
		else if(isset($_GET["dbe"])){
			echo "<script type='text/javascript'>alert('Error writing to the database!');</script>";
			unset($_GET["dbe"]);
		}
	?>
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../html/index.php">Nesh</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <!-- <li><a href="../basicPages/signUp.html">Sign Up</a></li> -->
                    <li><a href="#">About (dead)</a></li>
                    <li><a href="#">Contact (dead)</a></li>
                </ul>

                <form class="navbar-form pull-right" name="login" action="php/authentication.php?login" method="post">
                  <input class="span2" type="text" name="uid" placeholder="Username">
                  <input class="span2" type="password" name="password" placeholder="Password">
                  <button class="btn btn-sm btn-primary" onClick="" type="submit">Sign In</button>
                </form>   
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>


	<div class="container-fluid">
		<div class="row">
        	<div class="col-xs-6">
           	<img id="imagine" src="images/google_analytics_report.png">
      			<p id="bound">To improve developer-user feedback interaction, we have developed a web-based, event-driven analytic and A/B testing system. Event triggered snippets, embedded in clients' websites or mobile apps, send usage data to the cloud, where clients can observe trends in customizable graphs.</p>
           </div>
           <div class="col-xs-6">
           	<div class="page-header">
            		<h2>Sign Up</h2>
            		<p>Just fill out the below information and you'll be good to go.</p>
        		</div>
        		<form class="signup form-horizontal" action="php/authentication.php?signup" method="post">
                   <div class="form-group"> 
                   	<label for="first" class="col-sm-2 control-label">First Name:</label>
                    	<div class="col-sm-8">
            				<input class="form-control" name="first" type="text" placeholder="First Name">
                     	</div>
                   </div>
                   <div class="form-group"> 
                   	<label for="last" class="col-sm-2 control-label">Last Name:</label>
                    	<div class="col-sm-8">
            				<input class="form-control" name="last" type="text" placeholder="Last Name">
            			</div>
                 	</div>
                  <div class="form-group"> 
                   	<label for="uid" class="col-sm-2 control-label">User Name:</label>
                    	<div class="col-sm-8">
            				<input class="form-control" name="uid" type="text" placeholder="Username">
            			</div>
                	</div>
                  <div class="form-group"> 
                   	<label for="email" class="col-sm-2 control-label">Email:</label>
            			<div class="col-sm-8">
                       	<input class="form-control" name="email" type="email" placeholder="Email Address">
            			</div>
                	</div>
                  <div class="form-group"> 
                   	<label for="nPassword" class="col-sm-2 control-label">Password:</label>
                    	<div class="col-sm-8">
            				<input class="form-control" name="nPassword" type="password" placeholder="Password">
                   	</div>
            		</div>
                  <div class="form-group"> 
                   	<label for="confPassowrd" class="col-sm-2 control-label">Confirm Password:</label>
                    	<div class="col-sm-8">
            				<input class="form-control" name="confPassword" type="password" placeholder="Confirm Password">
                     	</div>
            		</div>
                   <div style="text-align:center">
            			<button class="btn btn-large btn-primary" type="submit">Sign Up</button>
                   </div>
        		</form>
          </div>
      </div>

   	</div>
    <!--footer--> 
    <footer class="navbar basic-footer" role="footerInfo">
        <div class="container">
            <p>Designed and styled using
                <a target="_blank" href="http://getbootstrap.com"> bootstrap </a>
                and
                <a target="_blank" href="https://github.com"> github.</a>
            </p>
            <p>For questions, email
            		<a target="_blank" href="http://gmail.scu.edu"> anarra@scu.edu,</a>
					      <a target="_blank" href="http://gmail.scu.edu"> bsilva1@scu.edu,</a>
                <a target="_blank" href="http://gmail.scu.edu"> mhowlesbanerji@scu.edu,</a>
                <a target="_blank" href="http://gmail.scu.edu"> mjevans@scu.edu.</a>
            </p>
        </div>
    </footer>

    <script src="scripts/jquery-1.11.0.js"></script>
    <script src="scripts/bootstrap.js"></script>
</body>

</html>