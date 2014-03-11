<?php
		session_start();
		if(!isset($_SESSION['userid'])){
			header("Location: ../index.html");
		}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Front Page</title>
    <link rel="stylesheet" type="text/css" href="../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../styles/addon.css">

</head>

<body>
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-loggedout">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">NESH</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-loggedout">
                <ul class="nav navbar-nav">
                    <li><a href="#">Create a New Project</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Review Existing Projects
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Project 1</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">Project 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">User Options
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Setting</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="../php/authentication.php?logout">Sign Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
	
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-xs-6">
            	<div class="page-header">
            		<h2>Create a New Project</h2>
            		<!--<p>Create a new project using whatever user-triggered event you wish and compare between your site's versions.</p>-->
        		</div>
        		<h4>Please fill out the appropriate information:</h4>
        			<form name="newproj" action="../php/projMgmt.php?newproj" method="post">
            			<div class="row">
                			<div class="col-md-3">
                    			<input class="form-control" type="projectName" autofocus required="" placeholder="Project Name">
                			</div>
             
                			<div class="col-md-3">
                    			<input class="form-control" type="eventName" autofocus required="" placeholder="Event Name">
                			</div>
                			
                			<div class="col-md-2">
                    			<button class="btn btn-sm btn-primary" type="submit">Create Project</button>
                			</div>
            			</div>
        			</form>
			</div>
           <div class="col-xs-6">
           	<div class="page-header">
            		<h2>View Existing Projects</h2>
            		<!--<p>View you existing projects here!</p>-->
        		</div>
            	<table class="table table-hover">
                	<?php
						include ("../php/mysqli.php");
						global $db_obj;
				
						$query = "SELECT * FROM Products WHERE uid = '". $_SESSION['userid']."'";
				
						if ( ($result = $db_obj->query($query)) && ($result->num_rows != 0) ){  // success!
							$st = "";
				 			while ($row = $result->fetch_assoc()) {
								$st .= "<tr><td>";
								$st .= $row['product']. "<span class='glyphicon glyphicon-chevron-right pull-right'></span></td></tr>";
    						}
							echo $st;
						}
						else{
			 				echo "<tr><td>No Projects so far!</td></tr>";
						}
					?>
              	</table>
           </div>
        </div>
    </div>
      
    <!--footer--> 
    <footer class="basic-footer" role="footerInfo">
        <div class="container">
            <p>Designed and styled using
                <a target="_blank" href="http://getbootstrap.com"> bootstrap </a>
                and
                <a target="_blank" href="https://github.com"> github.</a>
            </p>
            <p>For questions, email
                <a target="_blank" href="http://gmail.scu.edu"> mjevans@scu.edu,</a>
                <a target="_blank" href="http://gmail.scu.edu"> mhowlesbanerji@scu.edu,</a>
                <a target="_blank" href="http://gmail.scu.edu"> bsilva1@scu.edu,</a>
                <a target="_blank" href="http://gmail.scu.edu"> anarra@scu.edu.</a>
            </p>
        </div>
    </footer>

    <script src="scripts/jquery-1.11.0.js"></script>
    <script src="scripts/bootstrap.js"></script>
</body>

</html>
