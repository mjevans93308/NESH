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
    <title>Project Review</title>
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

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-sm-3 col-md-2 span2 sidebar">
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
            </div>
            <!--sidebar-->

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <div class="container">
                        <!-- Dropdowns and javascript here -->
                        <div class="row">

                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        
                                        <div class="page-header">
                                            <h4>Event Selection</h4>
                                        </div>
                                        <form name="currProj" role="form"><!--class, action, method? -->
                                            <div class="btn-group">
                                                <button type="button" style="width: 150px;" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                                                    <span data-bind="label">Event Name Here </span>&nbsp;<span class="caret"></span>                                         
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Event 1</a></li>
                                                    <li><a href="#">Event 2</a></li>
                                                    <li><a href="#">Event 3</a></li>
                                                </ul>
                                            </div>

                                            <div class="page-header">
                                                <h4>Tag Selection</h4>
                                            </div>
                                            <div id="dynTags">
                                                <div class="form-group" id="form1">
                                                    <div class="btn-group">
                                                        <button type="button" style="width: 150px;" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                                                            <span data-bind="label">Account Type </span>&nbsp;<span class="caret"></span>                                         
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Event 1</a></li>
                                                            <li><a href="#">Event 2</a></li>
                                                            <li><a href="#">Event 3</a></li>
                                                        </ul>
                                                    </div>
                                                    ===============
                                                    <div class="btn-group">
                                                        <button type="button" style="width: 150px;" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                                                            <span data-bind="label">By </span>&nbsp;<span class="caret"></span>                                         
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Event 1</a></li>
                                                            <li><a href="#">Event 2</a></li>
                                                            <li><a href="#">Event 3</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button type="button" style="width: 150px;" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                                                            <span data-bind="label">Number of Results </span>&nbsp;<span class="caret"></span>                                         
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Event 1</a></li>
                                                            <li><a href="#">Event 2</a></li>
                                                            <li><a href="#">Event 3</a></li>
                                                        </ul>
                                                    </div>
                                                    <br />
                                                    ||
                                                    <br />
                                                    ================================
                                                    <div class="btn-group">
                                                        <button type="button" style="width: 150px;" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                                                            <span data-bind="label">Contains </span>&nbsp;<span class="caret"></span>                                         
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Event 1</a></li>
                                                            <li><a href="#">Event 2</a></li>
                                                            <li><a href="#">Event 3</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button type="button" style="width: 150px;" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
                                                            <span data-bind="label">Enterprise </span>&nbsp;<span class="caret"></span>                                         
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Event 1</a></li>
                                                            <li><a href="#">Event 2</a></li>
                                                            <li><a href="#">Event 3</a></li>
                                                        </ul>
                                                    </div>
                                                    <button type="button" class="close" onClick="addForm(this.form)">&#43;</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                        </div>
                    </div>
                    <!-- Graph display here -->
            </div>
        </div>
    </div>

<script>
    var totalForms =  1;
    var totalFormCount = 1;

    function addForm(form){
        if(totalFormCount < 5){
            totalForms++;
            totalFormCount++;

            var newForm = "
                            <div class=\"form-group\" id=\"tag"+totalForms+"\">
                                <div class=\"btn-group\">
                                    <button type=\"button\" style=\"width: 150px;\" class=\"btn btn-default dropdown-toggle form-control\" data-toggle=\"dropdown\">
                                        <span data-bind=\"label\">Account Type </span>&nbsp;<span class=\"caret\"></span>                                         
                                    </button>
                                    <ul class=\"dropdown-menu\" role=\"menu\">
                                        <li><a href=\"#\">Event 1</a></li>
                                        <li><a href=\"#\">Event 2</a></li>
                                        <li><a href=\"#\">Event 3</a></li>
                                    </ul>
                                </div>
                                ===============
                                <div class=\"btn-group\">
                                    <button type=\"button\" style=\"width: 150px;\" class=\"btn btn-default dropdown-toggle form-control\" data-toggle=\"dropdown\">
                                        <span data-bind=\"label\">By </span>&nbsp;<span class=\"caret\"></span>                                         
                                    </button>
                                    <ul class=\"dropdown-menu\" role=\"menu\">
                                        <li><a href=\"#\">Event 1</a></li>
                                        <li><a href=\"#\">Event 2</a></li>
                                        <li><a href=\"#\">Event 3</a></li>
                                    </ul>
                                </div>
                                <div class=\"btn-group\">
                                    <button type=\"button\" style=\"width: 150px;\" class=\"btn btn-default dropdown-toggle form-control\" data-toggle=\"dropdown\">
                                        <span data-bind=\"label\">Number of Results </span>&nbsp;<span class=\"caret\"></span>                                         
                                    </button>
                                    <ul class=\"dropdown-menu\" role=\"menu\">
                                        <li><a href=\"#\">Event 1</a></li>
                                        <li><a href=\"#\">Event 2</a></li>
                                        <li><a href=\"#\">Event 3</a></li>
                                    </ul>
                                </div>
                                <br />
                                ||
                                <br />
                                ================================
                                <div class=\"btn-group\">
                                    <button type=\"button\" style=\"width: 150px;\" class=\"btn btn-default dropdown-toggle form-control\" data-toggle=\"dropdown\">
                                        <span data-bind=\"label\">Contains </span>&nbsp;<span class=\"caret\"></span>                                         
                                    </button>
                                    <ul class=\"dropdown-menu\" role=\"menu\">
                                        <li><a href=\"#\">Event 1</a></li>
                                        <li><a href=\"#\">Event 2</a></li>
                                        <li><a href=\"#\">Event 3</a></li>
                                    </ul>
                                </div>
                                <div class=\"btn-group\">
                                    <button type=\"button\" style=\"width: 150px;\" class=\"btn btn-default dropdown-toggle form-control\" data-toggle=\"dropdown\">
                                        <span data-bind=\"label\">Enterprise </span>&nbsp;<span class=\"caret\"></span>                                         
                                    </button>
                                    <ul class=\"dropdown-menu\" role=\"menu\">
                                        <li><a href=\"#\">Event 1</a></li>
                                        <li><a href=\"#\">Event 2</a></li>
                                        <li><a href=\"#\">Event 3</a></li>
                                    </ul>
                                </div>
                                <button type=\"button\" class=\"close\" onClick=\"deleteForm("+totalForms+");\">&times;</button>
                            </div>";
            jQuery('#dynTags').before(newForm);
            /*form.tag.value='';*/
        }
        else {
            alert("Maximum number of tags allowed is 5.");
        }
    }

    function deleteForm(formNum){
        totalFormCount--;
        jQuery('#tag'+formNum).remove();
    }

    $( document.body ).on( 'click', '.dropdown-menu li', function( event ) {

        var $target = $( event.currentTarget );

        $target.closest( '.btn-group' )
        .find( '[data-bind="label"]' ).text( $target.text() )
        .end()
        .children( '.dropdown-toggle' ).dropdown( 'toggle' );

    return false;

    });
</script>

</body>

</html>