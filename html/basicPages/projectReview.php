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
					echo '<script>window.hash_num ='.$hash_num.' </script>';
					$st .= '</a></li>';
                	$st .= '<li class="sidebaractive"><a href="projectReview.php?pid='.$pid.'">Analytics</a></li>';
                	$st .= '<li><a href="trends.php?pid='.$pid.'">Trends</a></li>';
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
                        <div class="well">
								<form class="form-horizontal" role="form">
            					<div class="form-group">
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
              					</div>
                             <div id="tagGraph">
                             <div class="form-group" id= "tagSection1">
                             	<div class="pull-left padding">
                             		<select id="prepositions" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true">
                                			<option selected>By</option>
                                			<option>Is</option>
                                    
                                		</select>
                                 </div>
                             	<div class="pull-left padding">
                    					<select id="property1" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true" onChange="tagSelected(this.id)">                                        
										<?php
												$st2 = '<option selected>Property</option>';
												$query3 = "SELECT * FROM Products WHERE pid = '".$pid."'";
													if ( ($result3 = $db_obj->query($query3)) && ($result3->num_rows == 1) ){  // success!
														while($row3 = $result3->fetch_assoc()){
															if($row3['tag0'] != ""){
          														$st2 .= '<option value="tag0">'.$row3['tag0'].'</option>';
																
																/******************************************************************
																						TAG DETAILS FOR TAG 0
																******************************************************************/
																
																$query4 = "SELECT DISTINCT tag0 FROM Session WHERE hash_number='".$hash_num."'";
																if($tag0 = $db_obj->query($query4)){
																	$tag0Str = '<div class="pull-left padding"><select id="tagDetailSelect" class="selectpicker show-tick form-control padding" style="float:left;">';
																	$tag0Str .= '<option selected>Value</option>';
																	while($row4 = $tag0->fetch_array()){
																		$tag0Str .= '<option>'.$row4['tag0'].'</option>';
																	}
																	$tag0Str .= '</select></div>';	
																}
																
															}
															if($row3['tag1'] != ""){
          														$st2 .= '<option value="tag1">'.$row3['tag1'].'</option>';
																$query5 = "SELECT DISTINCT tag1 FROM Session WHERE hash_number='".$hash_num."'";
																if($tag1 = $db_obj->query($query5)){
																	$tag1Str = '<div class="pull-left padding"><select id="tagDetailSelect" class="selectpicker show-tick form-control padding" style="float:left;">';
																	$tag1Str .= '<option selected>Value</option>';
																	while($row5 = $tag1->fetch_array()){
																		$tag1Str .= '<option>'.$row5['tag1'].'</option>';
																	}
																	$tag1Str .= '</select></div>';	
																}
															}
															if($row3['tag2'] != ""){
          														$st2 .= '<option value="tag2">'.$row3['tag2'].'</option>';
																
																$query6 = "SELECT DISTINCT tag2 FROM Session WHERE hash_number='".$hash_num."'";
																if($tag2 = $db_obj->query($query6)){
																	$tag2Str = '<div class="pull-left padding"><select id="tagDetailSelect" class="selectpicker show-tick form-control padding" style="float:left;">';
																	$tag2Str .= '<option selected>Value</option>';
																	while($row6 = $tag2->fetch_array()){
																		$tag2Str .= '<option>'.$row6['tag2'].'</option>';
																	}
																	$tag2Str .= '</select></div>';	
																}
															}
															if($row3['tag3'] != ""){
          														$st2 .= '<option value="tag3">'.$row3['tag3'].'</option>';
																$query7 = "SELECT DISTINCT tag3 FROM Session WHERE hash_number='".$hash_num."'";
																if($tag3 = $db_obj->query($query7)){
																	$tag3Str = '<div class="pull-left padding"><select id="tagDetailSelect" class="selectpicker show-tick form-control padding" style="float:left;">';
																	$tag3Str .= '<option selected>Value</option>';
																	while($row7 = $tag3->fetch_array()){
																		$tag3Str .= '<option>'.$row7['tag3'].'</option>';
																	}
																	$tag3Str .= '</select></div>';	
																}
															}
															if($row3['tag4'] != ""){
          														$st2 .= '<option value="tag4">'.$row3['tag4'].'</option>';
																
																$query8 = "SELECT DISTINCT tag4 FROM Session WHERE hash_number='".$hash_num."'";
																if($tag4 = $db_obj->query($query8)){
																	$tag4Str = '<div class="pull-left padding"><select id="tagDetailSelect" class="selectpicker show-tick form-control padding" style="float:left;">';
																	$tag4Str .= '<option selected>Value</option>';
																	while($row8 = $tag4->fetch_array()){
																		$tag4Str .= '<option>'.$row8['tag4'].'</option>';
																	}
																	$tag4Str .= '</select></div>';	
																}
															}
          												}		
													}
												echo $st2;
												
											?>
                    					</select>  
                                    <?php
											$temp = $st2;
											echo "<script> window.tag0Str='".$tag0Str."'</script>"; 
											echo "<script> window.tag1Str='".$tag1Str."'</script>"; 
											echo "<script> window.tag2Str='".$tag2Str."'</script>"; 
											echo "<script> window.tag3Str='".$tag3Str."'</script>"; 
											echo "<script> window.tag4Str='".$tag4Str."'</script>"; 
											echo "<script> window.additionalTags='".$temp."'</script>"; 

										?>
                					</div>
                                <div class="pull-left">
                          			<button type="button" id="addTagDet1" class="close" onClick="addTagDetails('#tagSection1', 1);">&#62;</button>
                                	</div>
                             </div>
                             </div>
                             <div class="form-group">
                              	<div class="pull-left">
                          			<button type="button" id="addTagOpt" class="close" onClick="addTagGraphs(this.form);">&#43;</button>
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
			//alert("window onload works!");
			/********************************************************
						INITIAL SETTINGS FOR THE DROPDOWNS
			*********************************************************/
			//alert("2");
			$('#prepositions').prop('disabled', true);
			$('#prepositions').selectpicker('refresh');
			$('#property1').prop('disabled', true);
			$('#property1').selectpicker('refresh');
			$('.selectpicker').selectpicker();
			//alert("3");
			document.getElementById("addTagDet1").disabled = true;
			document.getElementById("addTagOpt").disabled = true;
			window.xAxis = [[1, 2, 3, 4, 5, 6, 7], [3.5, 4.5, 5.5, 6.5, 7, 8]];
			window.yAxis =  [[12, 32, 23, 15, 17, 27, 22], [10, 20, 30, 25, 15, 28]];
			createGraph();
		}
		
			/********************************************************
									GRAPH AREA
			*********************************************************/
		function createGraph(){
			alert("gets into the function");
			var r = Raphael(document.getElementById("graph"), document.getElementById("graph").clientWidth, 490),
			txtattr = { font: "12px sans-serif" };
			var width = document.getElementById("graph").clientWidth - 20;
			var j = 0;
			var lines = r.linechart(20, 0, width, 480, window.xAxis, window.yAxis, { nostroke: false, axis: "0 0 1 1", symbol: "circle"}).hoverColumn(function () {
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
			var myTextElem = lines.axis[0].text.items;
			for(var l = 0; l < myTextElem.length; l++){
				myTextElem[l].attr({'text' : window.xAxisLabels[l]});
			}
		}
		
		function checkMonth(number){
			switch( number ){
				case 1: 
					return 31;
					break;
				case 2: 
					return 28 + 31;
					break;
				case 3:
					return 31 + 28 + 31;
					break;
				case 4:
					return 30 + 31 + 28 + 31;
					break; 
				case 5: 
					return 31 + 30 + 31 + 28 + 31;
					break;
				case 6: 
					return 30 + 31 + 30 + 31 + 28 + 31;
					break;
				case 7: 
					return 31 + 30 + 31 + 30 + 31 + 28 + 31; 
					break;
				case 8: 
					return 31 + 31 + 30 + 31 + 30 + 31 + 28 + 31; 
					break;
				case 9: 
					return 30 + 31 + 31 + 30 + 31 + 30 + 31 + 28 + 31; 
					break;
				case 10:
					return 31 + 30 + 31 + 31 + 30 + 31 + 30 + 31 + 28 + 31; 
					break;
				case 11: 
					return 30 + 31 + 30 + 31 + 31 + 30 + 31 + 30 + 31 + 28 + 31; 
					break;
				case 12:
					return 31 + 30 + 31 + 30 + 31 + 31 + 30 + 31 + 30 + 31 + 28 + 31; 
					break;
				default: 
					return 0;
					break;
			}
		}
		var tag = 1;
		var tagNum = 1;
		var postString = '';
		/*********INVOKING THE SCRIPT ON THE SERVER TO GET DATA***********/
		function invokeScript(){
			var xmlhttp;
			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  				xmlhttp=new XMLHttpRequest();
  			}
			else{// code for IE6, IE5
  				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  			}
			xmlhttp.open("POST","http://nesh.co/php/graphScript.php", true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send(postString);
			
			/*********because this is an asynchronous request, we must look for a 
			statechange and then use the response text***********/
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					var res = xmlhttp.responseText;
					//alert(res);
					var obj = $.parseJSON(res);
					//alert("json status: "+obj.STATUS);
					//alert(obj.tags.tag0.blue.x[0]);
					window.xAxis = [];
					window.yAxis = [];
					for (var tagSet in obj.tags){
						//alert("gets into the first for: "+tagSet);
						window.labelArray = [];
						window.xAxisLabels = [];
						for ( var tagName in obj.tags[tagSet] ){
							//alert("gets into the second loop for: "+tagName);
							var tempX = [];
							var tempY = [];
							for ( var k = 0; k < obj.tags[tagSet][tagName].x.length; k++ ){
		//						alert("gets into the third loop");
			//					alert("1:"+obj[tags][tagName].x[k]);
				//				alert("2:"+obj[tags][tagName].y[k]);
								var dateSet = obj.tags[tagSet][tagName].x[k].split("-");
								var dateNum = ((parseInt(dateSet[0])-2014)*365)+checkMonth(parseInt(dateSet[1]))+parseInt(dateSet[2]);
								window.xAxisLabels.push(obj.tags[tagSet][tagName].x[k]);
								tempX.push(dateNum);
								tempY.push(obj.tags[tagSet][tagName].y[k]);
							}
							document.getElementById('graph').innerHTML='';
							window.labelArray.push(tagName); //tagName = Mozila, Firefox etc
							window.xAxis.push(tempX);
							window.yAxis.push(tempY);
						}
					}
					//alert("finish for");
					//for(var l = 0; l < window.xAxis.length; l++){
					//	alert("x, y=["+window.xAxis[l].join(",")+"],["+window.yAxis[l].join(",")+"]");
					//}
					createGraph();
				}
  			}
		}
		/********************************************************
						FUNCTIONS FOR DROPDOWNS
		*********************************************************/
		
		
		function eventSelected(){
			//alert("onclick works");
			var eventSelected = $('#eventSelect option:selected').val();
			postString = '';
			alert(eventSelected);
			$('#prepositions').prop('disabled', false);
			$('#prepositions').selectpicker('refresh');
			$('#property1').prop('disabled', false);
			$('#property1').selectpicker('refresh');
			document.getElementById('addTagDet1').disabled = false;
			document.getElementById('addTagOpt').disabled = false;
			postString += "hash_number="+window.hash_num+"&event_id="+eventSelected;
			alert(postString);
			invokeScript();			
		}
	
		function tagSelected(propID){
			postString = '';
			var eventSelected = $('#eventSelect option:selected').val();
			postString += "hash_number="+window.hash_num+"&event_id="+eventSelected;
			postString += "&";
			var query = '#'+propID+' option:selected';
			var i;
			alert(query);
			var tagSelected1 = $(query).val();
			alert(tagSelected1);
			alert("tagNum: "+tagNum);
			alert("tag: "+ tag);
			if(tagNum >1){
				for(i = 1; i <= tag; i++){
					var tagIDD = "#tagSection"+i;
					var id = "#property"+i;
					alert(id);
					alert($(tagIDD).find(id).length);
					alert("gets here");
					if($(tagIDD).find(id).length){
						var query1 = id+' option:selected';
						var tagSelected2 = $(query1).val();
						if(tagSelected2 == 'tag0'){
							postString += "tag0=_ALL";
						}
						if(tagSelected2 == 'tag1'){
							postString += "tag1=_ALL";
						}
						if(tagSelected2 == 'tag2'){
							postString += "tag2=_ALL";
						}
						if(tagSelected2 == 'tag3'){
							postString += "tag3=_ALL";
						}
						if(tagSelected2 == 'tag4'){
							postString += "tag4=_ALL";
						}
						if(i != tag){
							postString += '&';
						}
					}
				}
			}
			else{
				if(tagSelected1 == 'tag0'){
					postString += "tag0=_ALL";
				}
				else if(tagSelected1 == 'tag1'){
					postString += "tag1=_ALL";
				}
				else if(tagSelected1 == 'tag2'){
					postString += "tag2=_ALL";
				}
				else if(tagSelected1 == 'tag3'){
					postString += "tag3=_ALL";
				}
				else if(tagSelected1 == 'tag4'){
					postString += "tag4=_ALL";
				}
			}
			alert(postString);
			invokeScript();
		}

		function addTagDetails(form, num) {
			var query = '#property'+num+' option:selected';	
			alert(query);
			var tagSelected1 = $(query).val();
			alert(tagSelected1);
			var addTagPrep = '<div class="pull-left padding"><select id="prepositions" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true"><option selected>Contains</option></select></div>';
			$(form).append(addTagPrep);
			//alert(window.tag0Str);
			if(tagSelected1 == 'tag0'){
				$(form).append(window.tag0Str);
			}
			else if(tagSelected1 == 'tag1'){
				$(form).append(window.tag1Str);
			}
			else if(tagSelected1 == 'tag2'){
				$(form).append(window.tag2Str);
			}
			else if(tagSelected1 == 'tag3'){
				$(form).append(window.tag3Str);
			}
			else if(tagSelected1 == 'tag4'){
				$(form).append(window.tag4Str);
			}
			string = '<div class="pull-left"><button type="button" id="removeTag" class="close" onClick="deleteTag(\'#tagSection'+tag+'\')">&#120;</button></div></div>';
			$(form).append(string);
			$('.selectpicker').selectpicker();
			var tagDetId = '#addTagDet'+num;
			alert(tagDetId);
			$(tagDetId).remove();
		}
		
		function addTagGraphs(form) {
		if(tagNum < 5){
			tag += 1;
			tagNum += 1;
			var string = '<div class="form-group" id= "tagSection'+tag+'"><div class="pull-left padding"><select id="prepositions" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true"><option selected>By</option><option>Is</option></select></div><div class="pull-left padding"><select id="property'+tag+'" class="selectpicker show-tick form-control padding" style="float:left;" data-live-search="true" onChange="tagSelected(this.id)">'
			string += window.additionalTags;
			string += '</select></div><div class="pull-left"><button type="button" id="addTagDet'+tag+'" class="close" onClick="addTagDetails(\'#tagSection'+tag+'\', '+tag+');">&#62;</button></div></div>';
			
			
			$('#tagGraph').append(string);
			$('.selectpicker').selectpicker();
		}
		else
			alert("Maximum number of tags reached!");
		}

		function deleteTag(form) {
			if(tagNum != 1){
				tagNum = tagNum - 1;
				jQuery(form).remove();
			}
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