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
		           $st .= '<li><a href="'.$hash_num.'">Registered Events</a></li>';
                	$st .= '<li><a href="'.$hash_num.'">Registered Tags</a></li>';
                	$st .= '<li class="sidebaractive"><a href="projectReview.php?pid='.$pid.'">Analytics</a></li>';
                	$st .= '<li><a href="'.$hash_num.'">Trends</a></li>';
               	$st .= '<li><a href="'.$hash_num.'">Code Snippets</a></li>';
				
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
								<form class="form-horizontal" role="form">
            					<div class="form-group">
                                <!--****************************************************
                                		This is the section for selecting Events for graphs
                                *******************************************************-->
                					<div class="pull-left padding" id="eventGraph">
                    					<select id="event" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true">
                                        <?php
												$st1 = '<option selected>Event</option>';
												$query2 = "SELECT * FROM Events WHERE hash_number = '".$hash_num."'";
													if ( ($result2 = $db_obj->query($query2)) && ($result2->num_rows != 0) ){  // success!
														while($row2 = $result2->fetch_assoc()){
          													$st1 .= '<option>'.$row2['description'].'</option>';
          												}		
													}
												echo $st1;
											?>
                    					</select>
                					</div>
                                 <div class="pull-left">
                          			<button type="button" class="close" onClick="addTags(this.form);">&#43;</button>
                                	</div>
              					</div>
                             <div class="form-group">
                             	<div class="pull-left padding">
                             		<select id="prepositions" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true">
                                			<option selected>By</option>
                                			<option>Is</option>
                                    
                                		</select>
                                 </div>
                             	<div class="pull-left padding">
                    					<select id="property" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true">
                                        <?php
												$st2 = '<option selected>Property</option>';
												$query3 = "SELECT * FROM Products WHERE pid = '".$pid."'";
													if ( ($result3 = $db_obj->query($query3)) && ($result3->num_rows == 1) ){  // success!
														while($row3 = $result3->fetch_assoc()){
															if($row3['tag0'] != ""){
          														$st2 .= '<option>'.$row3['tag0'].'</option>';
															}
															if($row3['tag1'] != ""){
          														$st2 .= '<option>'.$row3['tag1'].'</option>';
															}
															if($row3['tag2'] != ""){
          														$st2 .= '<option>'.$row3['tag2'].'</option>';
															}
															if($row3['tag3'] != ""){
          														$st2 .= '<option>'.$row3['tag3'].'</option>';
															}
															if($row3['tag4'] != ""){
          														$st2 .= '<option>'.$row3['tag4'].'</option>';
															}
          												}		
													}
												echo $st2;
											?>
                    					</select>
                					</div>
                                <div class="pull-left">
                          			<button type="button" class="close" onClick="addTags(this.form);">&#43;</button>
                                	</div>
                             </div>
        						</form>  
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="well" id="box">
                        		<div class="sub-box">
        							<form class="form-horizontal" role="form">
									<div class="form-group">
											<div class="btn-group">
                                            <button type="button" class="btn btn-default">Unique User</button>
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"/>
													  <span class="sr-only">Toggle Dropdown</span>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li> <a href="#">Event 1</a></li>
													<li><a href="#">Event 2</a></li>
												</ul>
											</div>
                  					<div class="pull-right">
										<div class="btn-group">
											<button type="button" class="btn btn-default">Bar Graph</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"/>
													  <span class="sr-only">Toggle Dropdown</span>
												</button>
											<ul class="dropdown-menu" role="menu">
												<li> <a href="#">Event 1</a></li>
												<li><a href="#">Event 2</a></li>
											</ul>
										</div>
										</div> 
									</div>
									</form> 
       				 			</div>
                             <div id="graph">
                             <p> graphs </p>
                             	<script>
										window.onload = function(){

											var r = Raphael(document.getElementById("graph"), document.getElementById("graph").clientWidth, 480);
											r.piechart(100, 100, 90, [55, 20, 13, 32, 5, 1, 2],
                                                {
                                                    legend: ["User 1", "User 2", "User 3", "User 4", "User 5", "User 6", "User 7"]
                                                }
                                            );
                                            var userDetails = ["User 1 stuff", "User 2 stuff", "User 3 stuff", "User 4 stuff", "User 5 stuff", "User 6 stuff", "User 7 stuff"]
                                            pie.hover(function(){
                                                var info = [
                                                    "<b>" + this.label[i].attrs["text"] + "</b>",
                                                    userDetails[this.value.order],
                                                    "Details:" + this.value.value
                                                ].join("");
                                                $("#graph").html(info);
                                            }, function(){
                                                $("#graph").html("");
                                            });
                                        }

/*											var r = Raphael(document.getElementById("graph"), document.getElementById("graph").clientWidth, 480);
											r.piechart(320, 240, 100, [55, 20, 13, 32, 5, 1, 2]);*/

                                </script>
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

    <!-- Custom JavaScript for the Menu Toggle -->
    <script>
		$("#menu-toggle").click(function(e) {
			e.preventDefault();
        	$("#wrapper").toggleClass("active");
    	});
	
		$(window).on('load', function () {
			$('.selectpicker').selectpicker({
				'selectedText': 'cat'
			});
            // $('.selectpicker').selectpicker('hide');
		});
		
		var totTags = 1;
		
		function addTags(form) {
        	totTags = totTags + 1;
      		var ttag = ""; 
        	jQuery('#dynamicTags').before(ttag);
      		form.tag.value='';
		}
    </script>
</body>

</html>