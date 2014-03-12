<?php
	session_start();
		if(!isset($_SESSION['userid'])){
			header("Location: ../index.php");
		}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Front Page</title>
    <link rel="stylesheet" type="text/css" href="../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../styles/addon.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

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
               
        		<div class="page-header"><h4>Please fill out the appropriate information:</h4></div>
        			<form name="newproj" class="form-horizontal" action="../php/projMgmt.php?newproj" method="post">
						<div class="form-group">
                        	<label for="projectName" class="col-sm-2 control-label">Project Name:</label>
                    		<div class="col-sm-8">
                            <input class="form-control" type="projectName" autofocus required="" placeholder="Project Name"> 
                      	</div>
                      </div>            
                		<div class="page-header">
                        <h4>Tags:	<button type="button" class="btn btn-info"><span class="glyphicon glyphicon-question-sign"></span></button></h4>
                      </div>	
                      <div id="dynamicTags">
                      	<div class="form-group">
                      		<label for="tag1" class="col-sm-2 control-label">Tag:</label>
                      		<div class="col-sm-8">
                    				<input class="form-control" type="tag1" placeholder="Tag Name">
                        		</div>
                       	</div>
                  	</div>
                      <button type="button" onClick="addTags('dynamicTags')" style="float:left;"><span class="glyphicon glyphicon-plus-sign"></span></button>
                      
                      <div class="page-header"><h4>Events:</h4></div>
                      <div id="dynamicEvents"> 
                      	<div class="form-group"> 
                				<label for="eventName1" class="col-sm-2 control-label">Event Name:</label>
                         		<div class="col-sm-8">
                             	<input class="form-control" type="event1" placeholder="Event Name">
                        		</div>
                         	</div>
                      </div>
                      <button type="button" onClick="addEvents('dynamicEvents')" style="float:left;"><span class= "glyphicon glyphicon-plus-sign" ></span></button>
                      <div style="clear:both;"></div>
                      <br />
                      <button class="btn btn-sm btn-primary" type="submit">Create Project</button>
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
            		<a target="_blank" href="http://gmail.scu.edu"> anarra@scu.edu.</a>
					<a target="_blank" href="http://gmail.scu.edu"> bsilva1@scu.edu,</a>
                  <a target="_blank" href="http://gmail.scu.edu"> mhowlesbanerji@scu.edu,</a>
                	<a target="_blank" href="http://gmail.scu.edu"> mjevans@scu.edu,</a>
            </p>
        </div>
    </footer>

    <script src="../scripts/jquery-1.11.0.js"></script>
    <script src="../scripts/bootstrap.js"></script>
    <script>
		var totTags = 1;
		var totEvents = 1;
		function addTags(tableID) {
			totTags = totTags + 1;
			var table = document.getElementById(tableID);
			if(totTags < 6){  
				table.innerHTML = table.innerHTML + "<div class=\"form-group\"><label for=\"tag"+totTags+"\" class=\"col-sm-2 control-label\">Tag:</label><div class=\"col-sm-8\"><input class=\"form-control\" type=\"tag1\" placeholder=\"Tag Name\"></div></div>";                          // limit the user from creating fields more than your limits
			}
			else{
		 		alert("Maximum number of tags allowed are 5!");		   
			}
		}
	
		function addEvents(tableID) {
			totEvents = totEvents + 1;
			var table = document.getElementById(tableID);
 			
			table.innerHTML = table.innerHTML + "<div class=\"form-group\"><label for=\"eventName"+totEvents+"\" class=\"col-sm-2 control-label\">Event Name:</label><div class=\"col-sm-8\"><input class=\"form-control\" type=\"event1\" placeholder=\"Event Name\"></div></div>";                          // limit the user from creating fields more than your limits

		}
		
		function deleteRow(tableID) {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {               // limit the user from removing all the fields
						alert("Cannot Remove all the Passenger.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}
			}
		}
	</script>
</body>

</html>
