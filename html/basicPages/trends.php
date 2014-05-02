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
                	$st .= '<li class="sidebaractive"><a href="trends.php?pid='.$pid.'">Trends</a></li>';
		           $st .= '<li><a href="projSettings.php?pid='.$pid.'">Settings</a></li>';
               	$st .= '<li><a href="codeSnippets.php?pid='.$pid.'">Code Snippets</a></li>';
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
			
			
			/********************************************************
									GRAPH AREA
			*********************************************************/
			var r = Raphael(document.getElementById("graph"), document.getElementById("graph").clientWidth, 490),
			txtattr = { font: "12px sans-serif" };
                
                var x = [], y = [], y2 = [], y3 = [];

                for (var i = 0; i < 1e6; i++) {
                    x[i] = i * 10;
                    y[i] = (y[i - 1] || 0) + (Math.random() * 7) - 3;
                    y2[i] = (y2[i - 1] || 150) + (Math.random() * 7) - 3.5;
                    y3[i] = (y3[i - 1] || 300) + (Math.random() * 7) - 4;
                }
				var width = document.getElementById("graph").clientWidth - 20;
                var lines = r.linechart(20, 0, width, 480, [1, 2, 3, 4, 5, 6, 7],[12, 32, 23, 15, 17, 27, 22], { nostroke: false, axis: "0 0 1 1", symbol: "circle"}).hoverColumn(function () {
                    this.tags = r.set();

                    for (var i = 0, ii = this.y.length; i < ii; i++) {
                        this.tags.push(r.tag(this.x, this.y[i], this.values[i], 200, 10).insertBefore(this).attr([{ fill: "#fff" }, { fill: this.symbols[i].attr("fill") }]));
                    }
                }, function () {
                    this.tags && this.tags.remove();
                });

                lines.symbols.attr({ r: 6 });
                // lines.lines[0].animate({"stroke-width": 6}, 1000);
                // lines.symbols[0].attr({stroke: "#fff"});
                // lines.symbols[0][1].animate({fill: "#f00"}, 1000);
           /*         fin = function () {
                        this.flag = r.popup(this.bar.x, this.bar.y, this.bar.value || "0").insertBefore(this);
                    },
                    fout = function () {
                        this.flag.animate({opacity: 0}, 300, function () {this.remove();});
                    },
                    txtattr = { font: "12px sans-serif" };
                
                r.text(160, 10, "Single Series Chart").attr(txtattr);
                
                r.barchart(0, 0, document.getElementById("graph").clientWidth/2, 500, [55, 20, 13, 32, 5, 1, 2, 10]).hover(fin, fout);
			var r = Raphael(document.getElementById("graph"), document.getElementById("graph").clientWidth, 480);
			r.barchart(0, 0, document.getElementById("graph").clientWidth/5, 480, [76, 70, 67, 71, 69], {});
			r.piechart(100, 100, 90, [55, 20, 13, 32, 5, 1, 2],
			{
				legend: ["User 1", "User 2", "User 3", "User 4", "User 5", "User 6", "User 7"]
			});
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
					 });*/
		}
		/********************************************************
						FUNCTIONS FOR DROPDOWNS
		*********************************************************/
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