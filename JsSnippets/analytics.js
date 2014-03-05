//<![CDATA[
    var invocation;
    var url = 'http://nesh.co/php/getData';
    var invocationHistoryText;
    var body = 'key=1, event_id= calcBmi';
    
    function callOtherDomain(){
    	invocation = new XMLHttpRequest();
        if(invocation)
        {
        	alert("Get's into invocation");
            invocation.open('POST', url, true);
            invocation.setRequestHeader('X-PINGARUNER', 'pingpong');
            invocation.setRequestHeader('Content-Type', 'text/html');
            invocation.onreadystatechange = handler;
            invocation.send("body"); 
        }
        else
        {
        	alert("Doesn't get into invocation");
            invocationHistoryText = "No Invocation TookPlace At All";
            var textNode = document.createTextNode(invocationHistoryText);
            var textDiv = document.getElementById("textDiv");
            alert(textNode);
        }
        
    }
    function handler(evtXHR)
    {
        if (invocation.readyState == 4)
        {
                if (invocation.status == 200)
                {
                	alert("Gets into readyState");
                    var response = invocation.responseText;
                    //var invocationHistory = response.getElementsByTagName('invocationHistory').item(0).firstChild.data;
                    invocationHistoryText = document.createTextNode(response);
                    alert(invocationHistoryText);
                    
                }
                else
                {
                	alert("Doesn't get into readyState");
                    alert("Invocation Errors Occured " + invocation.readyState + " and the status is " + invocation.status);
                }
        }
        else
        {
            dump("currently the application is at" + invocation.readyState);
        }
    }
    //]]>