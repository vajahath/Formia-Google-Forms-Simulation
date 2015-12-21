var active, normal, actionID ;

//	active	: id of active navigation bar.
//	normal	: id of rest of nav bars.
//	actionID: unique integer to identify the tasks to be performed.
//			actionID = 0 - activate functions in consoleHome.
//			actionID = 1 - activate functions in saved Forms-detailed view.

function changeActive(active, normal, actionID) //active, normal, actionID
{
	document.getElementById(active).className = "c-active";
	document.getElementById(normal).className = "c-normal";

	if(actionID == 0)
	{
		alert("actionID=0");
		ajaxLoad("changingContent", "consoleHomeContent.php");
	}
	else if(actionID == 1)
	{
		ajaxLoad("changingContent", "./misl.php");	
	}
	//ajaxLoad("changingContent", "misl.php")
	// add functions here when swithching between tabs.
}

//////////////////////////////////////////
//important function to load using AJAX //
//////////////////////////////////////////
var modid, incfile;
function ajaxLoad(modid, incfile) // modifying_id, including_file
{
	alert("alax load called");
	var xmlhttp;
	if(window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET", incfile, true);
	xmlhttp.send();

	xmlhttp.onreadystatechange = function()
	{
		if((xmlhttp.readyState == 4)&&(xmlhttp.status == 200))
		{
			document.getElementById(modid).innerHTML = xmlhttp.responseText;
		}
	}
}
