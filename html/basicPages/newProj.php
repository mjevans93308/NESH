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

    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active">
                        <a href="#">Project Name</a>
                    </li>
                    <li>
                        <a href="#">Registered Events</a>
                    </li>
                    <li>
                        <a href="#">Registered Tags</a>
                    </li>
                    <li>
                        <a href="#">Analytics</a>
                    </li>
                    <li>
                        <a href="#">Trends</a>
                    </li>
                    <li>
                        <a href="#">Code Snippets</a>
                    </li>
                </ul>
            <!--sidebar-->
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <div class="container" style="border: 1px solid #EEEEEE;">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Event:<span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Event 1</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Event 3</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Event 2</a></li>
                                <li class="divider"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--footer--> 
    <footer class="navbar-fixed-bottom basic-footer" role="footerInfo">
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
</body>

</html>