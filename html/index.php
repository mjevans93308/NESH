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
                    <li><a href="../html/basicPages/signUp.html">Sign Up</a></li>
                    <li><a href="#">About (dead)</a></li>
                    <li><a href="#">Contact (dead)</a></li>
                </ul>

                <form class="navbar-form pull-right">
                  <input class="span2" type="text" placeholder="Username">
                  <input class="span2" type="password" placeholder="Password">
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
      			<p id="bound">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ut lobortis dui, et lacinia mauris. Aliquam a condimentum odio. Ut in dignissim arcu. Vivamus vitae feugiat risus. Proin nisi nunc, hendrerit sed lectus sit amet, congue faucibus ante. Etiam dapibus blandit auctor. Quisque rutrum et sem in convallis.</p>
           </div>
           <!--
           <div class="col-xs-6">
           	<ul class="tabs">
       	 			<li>
          				<input type="radio" checked name="tabs" id="tab1">
          				<label for="tab1">Sign-Up</label>
          					<div id="tab-content1" class="tab-content animated fadeIn">
            					<form name="signup" action="php/authentication.php?signup" method="post">
       	    						<p>First Name: <input type="text" name= "first" class="textarea"> </p>
           						<p>Last Name: <input type="text" name="last" class="textarea"> </p>
           						<p>Username: <input type="text" name="uid" class="textarea"></p>
           						<p>E-Mail: <input type="email" name="email" class="textarea" ></p>
           						<p>New Password: <input type="password" name="nPassword" class="textarea"></p>
           						<p>Confirm Password: <input type="password" name="confPassword" class="textarea"></p>
            						<div style="clear:both"></div>
									<input type="submit" value="signup" class="button"><br/>              
       							</form>
          					</div>
        		</li>
        		<li>
          			<input type="radio" name="tabs" id="tab2">
          			<label for="tab2">Log-In</label>
          				<div id="tab-content2" class="tab-content animated fadeIn">
              				<form name="login" action="php/authentication.php?login" method="post">
              					<p>Username:
              					<input type="text" name="uid" class="textarea">
              					</p>
              					<p>Password:
              					<input type="password" name="password" class="textarea">
              					</p>
             					 <div style="clear:both"></div>
              					<input type="submit" value="login" class="button">
             					 <br/>
              					<a href="#">Forgot Password?</a>
              				</form>
          				</div>
        		</li>
        	</ul>
          </div>
          -->
      </div>

   	</div>
    <!--footer--> 
    <footer class="navbar navbar-fixed-bottom basic-footer" role="footerInfo">
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