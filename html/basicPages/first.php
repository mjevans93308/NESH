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
        			<form name="newproj" class="form-horizontal" role="form" action="../php/projMgmt.php?newproj" method="post">
						<div class="form-group">
                        	<label for="projectName" class="col-sm-2 control-label">Project Name:</label>
                    		<div class="col-sm-9">
                      	<input class="form-control" name="projectName" autofocus required="" placeholder="Project Name"> 
                     		</div>
                      </div>
                      <div style="clear:both"></div>   
                      
                     <!--**********************************************************************************
                     *                     This is the section for Tags                                   *
                     ***********************************************************************************-->    
                		<div class="page-header">
                        <h4>Tags	<a href="#" class="tip" data-toggle="tooltip" data-placement="right" title="" data-original-title="These are tags universal to the Project! Only 5 Tags are allowed.">
<span class="glyphicon glyphicon-question-sign"/>
</a>
							:</h4>
                      </div>	
                      <div id="dynamicTags" >
                      	<div class="form-group" id="tag1">
                      		<label for="tag1" class="col-sm-2 control-label">Tag:</label>
                        		<div class="col-sm-9">
                    				<input class="form-control" type='text' name="tag" placeholder="Tag Name">
                         		</div>
                         		<div class="col-sm-1">
                        			<button type="button" class="close" onClick="addTags(this.form);">&#43;</button>
                      		</div>
                      	</div>
                      </div>
                      <div style="clear:both"></div> 
                      
                      
                       <!--**********************************************************************************
                       *                     This is the section for Events                                 *
                       ************************************************************************************--> 
                      <div class="page-header"><h4>Events:</h4></div>
                      <div id="dynamicEvents">
                      	<div class="form-group" id="event1"> 
                				<label for="eventName1" class="col-sm-2 control-label">Event Name:</label>
                       		<div class="col-sm-9">
                            		<input class="form-control" type='text' name="events" placeholder="Event Name">
                        		</div>
                        		<div class="col-sm-1">
                         			<button type="button" class="close" onClick="addEvents(this.form)">&#43;</button>
                      		</div>
                         	</div>
                      </div>
                      <div style="clear:both;"></div>
                      
                      <!--**********************************************************************************
                       *              This is the section for Create Project Button                        *
                       ************************************************************************************--> 
                      <button class="btn btn-sm btn-primary" type="submit">Create Project</button>
        			</form>
			</div>
           <div class="col-xs-6">
           	<div class="page-header">
            		<h2>View Existing Projects</h2>
            		<!--<p>View you existing projects here!</p>-->
        		</div>
            	<div class="list-group">
                	<?php 
        						include ("../php/mysqli.php");
        						global $db_obj;
        				
        						$query = "SELECT * FROM Members WHERE username = '". $_SESSION['userid']."'";
        						
        						if ( ($result = $db_obj->query($query)) && ($result->num_rows != 0) ){  // success!
        							while($row = $result->fetch_assoc()){
        								$uid = $row['uid'];
        							}
        						}
        						$query1 = "SELECT * FROM Products WHERE uid = '" .$uid."'";
        							$st = "";
        						if ( ($result1 = $db_obj->query($query1)) && ($result1->num_rows != 0) ){
        				 			while ($row1 = $result1->fetch_assoc()) {
        								$st .= "<a href=\"newProj.php\" class=\"list-group-item\">".$row1['product']. "<span class=\"pull-right\"><span class='glyphicon glyphicon-chevron-right'></span></span></a>";
            					}
        							echo $st;
        						}
        						else{
        			 				echo "<div class=\"list-group-item-info\">No Projects so far!</div>";
        						}
        					?>
              	</div>
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

    <script src="../scripts/jquery-1.11.0.js" type="text/javascript"></script>
    <script src="../scripts/bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript">
    	$("[data-toggle=tooltip").tooltip();
	  </script>
    <script>
		var totTags = 1;
		var totTagCount = 1;
		var totEvents = 1;
		
		function addTags(form) {
      		if(totTagCount < 5){
        		totTags = totTags + 1;
				totTagCount = totTagCount + 1;
       			var ttag = "<div class = \"form-group\" id=\"tag"+totTags+"\"><label for=\"tag"+totTags+"\" class=\"col-sm-2 control-label\">Tag Name:</label><div class=\"col-sm-9\"><input class=\"form-control\" type=\"text\" name=\"tagArr[]\" value='"+form.tag.value+"' placeholder=\"Tag Name\"></div><div class = \"col-sm-1\"><button type=\"button\" class=\"close\" onClick=\"deleteTags("+totTags+");\">&times;</button></div></div></div>" ; 
        		jQuery('#dynamicTags').before(ttag);
      			form.tag.value='';
			}
      		else{
        		alert("Maximum number of tags allowed are 5!");      
      		}
		}
      
	  	function addEvents(eventForm) {
			totEvents = totEvents + 1;
			var eventsVar = "<div class = \"form-group\" id=\"event"+totEvents+"\"><label for=\"eventName"+totEvents+"\" class=\"col-sm-2 control-label\">Event Name:</label><div class=\"col-sm-9\"><input class=\"form-control\" name=\"eventArr[]\" value='"+eventForm.events.value+"' placeholder=\"Event Name\"></div><div class = \"col-sm-1\"><button type=\"button\" class=\"close\" onClick=\"deleteEvents("+totEvents+")\">&times;</button></div></div></div>";                       
			jQuery('#dynamicEvents').before(eventsVar);
			eventForm.events.value='';
		}
		
		function deleteTags(tNum) {
			totTagCount = totTagCount - 1;
      		jQuery('#tag'+tNum).remove();
		}
		function deleteEvents(eNum) {
			jQuery('#event'+eNum).remove();
		}
	</script>
</body>

</html>
