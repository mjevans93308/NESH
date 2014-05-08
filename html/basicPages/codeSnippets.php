<?php
    session_start();
        if(!isset($_SESSION['userid'])){
            header("Location: ../basicPages/first.php");
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reveiw Project Analytics</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="../styles/bootstrap.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link rel="stylesheet" type="text/css" href="../styles/addon.css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../styles/bootstrap-select.css">

</head>

<body>
	    <nav class="navbar navbar-default navbar-fixed-top nav-bar" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-loggedout">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://nesh.co/basicPages/first.php">NESH</a>
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

 <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
            	 <?php
				 	$st = '<li class="sidebar-brand"><a href="#">';
    				include ("../php/mysqli.php");
					if(isset($_GET['pid'])){
						$pid = $_GET['pid'];
					}
					global $db_obj;
					$query = "SELECT * FROM Products WHERE pid = '".$pid."'";
					if ( ($result = $db_obj->query($query)) && ($result->num_rows != 0) ){  // success!
						while($row = $result->fetch_assoc()){
          								$st .= $row['product'];
          				}		
					}
					$query1 = "SELECT * FROM Hash_Products WHERE pid = '".$pid."'";
					if ( ($result1 = $db_obj->query($query1)) && ($result1->num_rows != 0) ){  // success!
						while($row1 = $result1->fetch_assoc()){
          								$hash_num = $row1['hash_number'];
          				}		
					}
					$st .= '</a></li>';
                	$st .= '<li><a href="projectReview.php?pid='.$pid.'">Analytics</a></li>';
                	$st .= '<li><a href="trends.php?pid='.$pid.'">Trends</a></li>';
					$st .= '<li><a href="abAnalytics.php?pid='.$pid.'">AB Analytics</a></li>';
		           $st .= '<li><a href="projSettings.php?pid='.$pid.'">Settings</a></li>';
               	$st .= '<li class="sidebaractive"><a href="codeSnippets.php?pid='.$pid.'">Code Snippets</a></li>';
					echo $st;
				?>
            </ul>
        </div>

        <!-- Page content -->
        <div id="page-content-wrapper">
        <!-- Keep all page content within the page-content inset div! -->
        	<div class="page-content inset">
           	<a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
            	<div class="row">
              		<div class="col-md-12"> 
                    	<div class="well">
                        <div class="page-header">
                    		<h4>Basic Code Snippets</h4> 
                        </div>
                        <h5>The custom JavaScript file generated at the following link should be included into your project</h5>
                        <p>link here</p>
                        <h5>This is a general format of how the code snippet should look</h5>
                        <p>nesh.track("event", "tag, tag, tag, tag, tag");</p>               
                  	</div>
                  </div>
                  <div class="col-md-12">
                  	<div class="well">
                    		<div class="page-header">
                         		<h4>Create a custom code snippet:</h4>
                         </div>
                    		<form class="form-horizontal" role="form">
                            <div class="form-group" id="marginLeft">
                            <!--****************************************************
                            	This is the section for selecting Events for graphs
                            *******************************************************-->
                            <div class="pull-left padding" id="eventGraph">
                            		<select id="eventSelect" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true" onChange='eventSelected()'>
                            		<div id="eventOptions">
									<?php
                                    $st1 = '<option selected>Event</option>';
										$query2 = "SELECT * FROM Events WHERE hash_number = '".$hash_num."'";
										if ( ($result2 = $db_obj->query($query2)) && ($result2->num_rows != 0) ){  // success!
											while($row2 = $result2->fetch_assoc()){
												$st1 .= '<option value="'.$row2['event_id'].'">'.$row2['description'].'</option>';
											}
										}
										echo $st1;
									?>
                                	</div>
                    				</select>
                				</div>
                             <div id="tagGraph">
                             <div id= "tagSection1">
                             	<div class="pull-left padding">
                    					<select id="property1" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true" onChange="tagSelected()">                                        
										<?php
												$st2 = '<option selected>Tag</option>';
												$query3 = "SELECT * FROM Products WHERE pid = '".$pid."'";
													if ( ($result3 = $db_obj->query($query3)) && ($result3->num_rows == 1) ){  // success!
														while($row3 = $result3->fetch_assoc()){
															if($row3['tag0'] != ""){
          														$st2 .= '<option>'.$row3['tag0'].'</option>';	
															}
															if($row3['tag1'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag1'].'</option>';
															}
															if($row3['tag2'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag2'].'</option>';
															}
															if($row3['tag3'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag3'].'</option>';
															}
															if($row3['tag4'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag4'].'</option>';
															} 
          												}		
													}
												echo $st2;
												
											?>
                    					</select>
                                    <?php
											$temp = $st2;
											echo "<script> window.additionalTags='".$temp."'</script>"; 
										?>  
                					</div>
                             </div>
                             <div id= "tagSection2">
                             	<div class="pull-left padding">
                    					<select id="property2" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true" onChange="tagSelected()">                                        
										<?php
												$st2 = '<option selected>Tag</option>';
												$query3 = "SELECT * FROM Products WHERE pid = '".$pid."'";
													if ( ($result3 = $db_obj->query($query3)) && ($result3->num_rows == 1) ){  // success!
														while($row3 = $result3->fetch_assoc()){
															if($row3['tag0'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag0'].'</option>';	
															}
															if($row3['tag1'] != ""){
          														$st2 .= '<option>'.$row3['tag1'].'</option>';
															}
															if($row3['tag2'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag2'].'</option>';
															}
															if($row3['tag3'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag3'].'</option>';
															}
															if($row3['tag4'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag4'].'</option>';
															}
          												}		
													}
												echo $st2;
												
											?>
                    					</select>
                                    <?php
											$temp = $st2;
											echo "<script> window.additionalTags='".$temp."'</script>"; 
										?>  
                					</div>
                             </div>
                             <div id= "tagSection3">
                             	<div class="pull-left padding">
                    					<select id="property3" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true" onChange="tagSelected()">                                        
										<?php
												$st2 = '<option selected>Tag</option>';
												$query3 = "SELECT * FROM Products WHERE pid = '".$pid."'";
													if ( ($result3 = $db_obj->query($query3)) && ($result3->num_rows == 1) ){  // success!
														while($row3 = $result3->fetch_assoc()){
															if($row3['tag0'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag0'].'</option>';	
															}
															if($row3['tag1'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag1'].'</option>';
															}
															if($row3['tag2'] != ""){
          														$st2 .= '<option>'.$row3['tag2'].'</option>';
															}
															if($row3['tag3'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag3'].'</option>';
															}
															if($row3['tag4'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag4'].'</option>';
															}
          												}		
													}
												echo $st2;
												
											?>
                    					</select>
                                    <?php
											$temp = $st2;
											echo "<script> window.additionalTags='".$temp."'</script>"; 
										?>  
                					</div>
                             </div>
                             <div id= "tagSection4">
                             	<div class="pull-left padding">
                    					<select id="property4" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true" onChange="tagSelected()">                                        
										<?php
												$st2 = '<option selected>Tag</option>';
												$query3 = "SELECT * FROM Products WHERE pid = '".$pid."'";
													if ( ($result3 = $db_obj->query($query3)) && ($result3->num_rows == 1) ){  // success!
														while($row3 = $result3->fetch_assoc()){
															if($row3['tag0'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag0'].'</option>';	
															}
															if($row3['tag1'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag1'].'</option>';
															}
															if($row3['tag2'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag2'].'</option>';
															}
															if($row3['tag3'] != ""){
          														$st2 .= '<option>'.$row3['tag3'].'</option>';
															}
															if($row3['tag4'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag4'].'</option>';
															}
          												}		
													}
												echo $st2;
												
											?>
                    					</select>
                                    <?php
											$temp = $st2;
											echo "<script> window.additionalTags='".$temp."'</script>"; 
										?>  
                					</div>
                             </div>
                             <div id= "tagSection5">
                             	<div class="pull-left padding">
                    					<select id="property5" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true" onChange="tagSelected()">                                        
										<?php
												$st2 = '<option selected>Tag</option>';
												$query3 = "SELECT * FROM Products WHERE pid = '".$pid."'";
													if ( ($result3 = $db_obj->query($query3)) && ($result3->num_rows == 1) ){  // success!
														while($row3 = $result3->fetch_assoc()){
															if($row3['tag0'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag0'].'</option>';	
															}
															if($row3['tag1'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag1'].'</option>';
															}
															if($row3['tag2'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag2'].'</option>';
															}
															if($row3['tag3'] != ""){
          														$st2 .= '<option disabled="disabled">'.$row3['tag3'].'</option>';
															}
															if($row3['tag4'] != ""){
          														$st2 .= '<option>'.$row3['tag4'].'</option>';
															}
          												}		
													}
												echo $st2;
												
											?>
                    					</select>
                                    <?php
											$temp = $st2;
											echo "<script> window.additionalTags='".$temp."'</script>"; 
										?>  
                					</div>
                             </div>
                             </div>
                             </div>
        						</form>  
                              <div id="customSnippet" class="well">
                             	<p>Custom code snippet will be displayed here once an option is selected</p>
                             </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
    <!-- JavaScript -->
    <script src="../scripts/jquery-1.11.0.js" type="text/javascript"></script>
    <script src="../scripts/bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript" src="../scripts/bootstrap-select.js"></script>

    <script src="../scripts/raphael.js"></script>
    <script src="../scripts/graphael.js"></script>
    <script src="../scripts/g.bar.js"></script>
    <script src="../scripts/g.pie.js"></script>
    <script src="../scripts/g.line.js"></script>
	<script>
		window.onload = function(){
			alert("window onload works!");
			/********************************************************
						INITIAL SETTINGS FOR THE DROPDOWNS
			*********************************************************/
			$('.selectpicker').selectpicker();
		}

		/********************************************************
						FUNCTIONS FOR DROPDOWNS
		*********************************************************/
		var codeString = '';
		function eventSelected(){
			codeString = '';
			var eventSelected = $('#eventSelect option:selected').val();
			codeString += 'nesh.track("'+eventSelected;
			codeString += '", "';
			var tagSelected1 = $('#property1 option:selected').val();
			var tagSelected2 = $('#property2 option:selected').val();
			var tagSelected3 = $('#property3 option:selected').val();
			var tagSelected4 = $('#property4 option:selected').val();
			var tagSelected5 = $('#property5 option:selected').val();
			
			if(tagSelected1 == 'Tag'){
				alert(tagSelected1);
				codeString += ', ';
			}
			else{
				codeString += tagSelected1+', ';	
			}
			if(tagSelected2 == 'Tag'){
				codeString += ', ';
			}
			else{
				codeString += tagSelected2+', ';
			}
			if(tagSelected3 == 'Tag'){
				codeString += ', ';
			}
			else{
				codeString += tagSelected3+', ';
			}
			if(tagSelected4 == 'Tag'){
				codeString += ', ';
			}
			else{
				codeString += tagSelected4+', ';
			}
			if(tagSelected5 == 'Tag'){
				codeString += '");';
			}
			else{
				codeString += tagSelected5+'");';
			}
			alert(codeString);
			document.getElementById('customSnippet').innerHTML = codeString;
		}
	
		function tagSelected(){
			codeString = '';
			var eventSelected = $('#eventSelect option:selected').val();
			codeString += 'nesh.track("'+eventSelected;
			codeString += '", "';
			var tagSelected1 = $('#property1 option:selected').val();
			var tagSelected2 = $('#property2 option:selected').val();
			var tagSelected3 = $('#property3 option:selected').val();
			var tagSelected4 = $('#property4 option:selected').val();
			var tagSelected5 = $('#property5 option:selected').val();
			
			if(tagSelected1 == 'Tag'){
				alert(tagSelected1);
				codeString += ', ';
			}
			else{
				codeString += tagSelected1+', ';	
			}
			if(tagSelected2 == 'Tag'){
				codeString += ', ';
			}
			else{
				codeString += tagSelected2+', ';
			}
			if(tagSelected3 == 'Tag'){
				codeString += ', ';
			}
			else{
				codeString += tagSelected3+', ';
			}
			if(tagSelected4 == 'Tag'){
				codeString += ', ';
			}
			else{
				codeString += tagSelected4+', ';
			}
			if(tagSelected5 == 'Tag'){
				codeString += '");';
			}
			else{
				codeString += tagSelected5+'");';
			}
			alert(codeString);
			document.getElementById('customSnippet').innerHTML = codeString;
		}
		

		/********************************************************
					Custom JavaScript for the Menu Toggle 
		*********************************************************/
		$("#menu-toggle").click(function(e) {
			e.preventDefault();
        	$("#wrapper").toggleClass("active");
    	});
    </script>
</body>

</html>