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

</head>

<body>
	    <nav class="navbar navbar-default navbar-static-top nav-bar" role="navigation">
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
                <li class="sidebar-brand"><a href="#">Project Name</a>
                </li>
                <li><a href="#">Registered Events</a>
                </li>
                <li><a href="#">Registered Tags</a>
                </li>
                <li class="sidebaractive"><a href="projectReview.php">Analytics</a>
                </li>
                <li><a href="#">Trends</a>
                </li>
                <li><a href="#">Code Snippets</a>
                </li>
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
										<label for="events" class="control-label col-sm-1">Events:</label>
										<div class="col-sm-2">
											<div class="btn-group">
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Select an Event <span class="caret"/>
												</button>
											<ul class="dropdown-menu" role="menu">
												<li> <a href="#">Event 1</a></li>
												<li><a href="#">Event 2</a></li>
											</ul>
											</div>
										</div>  
										<div class="col-sm-1">
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
										<div class="col-sm-2">
											<div class="btn-group">
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Unique User <span class="caret"/>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li> <a href="#">Event 1</a></li>
													<li><a href="#">Event 2</a></li>
												</ul>
											</div>
										</div> 
                  					<div class="pull-right">
										<div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Bar Graph <span class="caret"/>
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
                             <div class="graph">
                             	Graphs go here!
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

    <script src="../scripts/raphael.js"></script>
    <script src="../scripts/graphael.js"></script>
    <script src="../scripts/g.bar.js"></script>

    <!-- Custom JavaScript for the Menu Toggle -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
    </script>
</body>

</html>