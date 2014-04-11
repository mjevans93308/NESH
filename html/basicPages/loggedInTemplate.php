<?php
    session_start();
        if(!isset($_SESSION['userid'])){
            header("Location: ../basicPages/first.php");
        }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Template Test</title>
    <link rel="stylesheet" type="text/css" href="../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../styles/addon.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    
    <script src="../scripts/jquery-1.11.0.js" type="text/javascript"></script>
    <script src="../scripts/bootstrap.js" type="text/javascript"></script>

    <script src="scripts/raphael.js"></script>
    <script src="scripts/graphael.js"></script>
    <script src="scripts/g.bar.js"></script>
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
                
                <ul class="nav nav-tabs navbar-left">
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
                <!--
                <div class="nav navbar-nav">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default">Create a New Project</button>
                        <div class="btn-group">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            Action <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                          </ul>
                        </div>
                    </div>
                </div>
                -->

                <ul class="nav nav-tabs navbar-right">
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

    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <div class="btn-group-vertical">    
                    <button class="btn btn-default">Project Name</button>
                    <button class="btn btn-default">Registered Events</button>
                    <button class="btn btn-default">Registered Tags</button>
                    <button class="btn btn-default">Analytics</button>
                    <button class="btn btn-default">Trends</button>
                    <button class="btn btn-default">Code Snippets</button>
                </div>
            <!--sidebar-->
            </div>
        </div>
    </div>

</body>

</html>