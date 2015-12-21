//consolejs
//--------------
// JavaScript functions used in console.
// Adds new questions while creating forms.
// helps to choose the answer types.


var active, normal, actionID, questionNum=0, optionNum=0; 
var questionNumCopy;
var opti = new Array();
var cbxi = new Array();
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
		//alert("actionID=0");
		ajaxLoad("changingContent", "consoleHomeContent.php");
	}
	else if(actionID == 1)
	{
		ajaxLoad("changingContent", "misl.php");	
	}
	//ajaxLoad("changingContent", "misl.php")
	// add functions here when swithching between tabs.
}

function showit()//display chars as they are typed.
{
	normal = document.getElementById("ttl").value;
	if(normal)
		document.getElementById("form-title-copy").innerText =""+document.getElementById("ttl").value;
	else
		document.getElementById("form-title-copy").innerText ="Untitled Form";
}

function addNewItem() //Adds new question.
{
	questionNum++;
	opti[questionNum]=0;
	cbxi[questionNum]=0;
	var qns = document.getElementById("question");

    var qn = document.createElement("div");
    qn.innerHTML = "<div class=\"elements\"><div class=\"f-row\"><div class=\"qnlabel\">Question"+questionNum+" :</div><input type=\"text\" class=\"t-field\" name=\"qn"+questionNum+"\"></div>"
    				+"<div class=\"answer\">"
	+"<div class=\"qnlabel\">Answer type :</div>"
	+"<select class=\"iptypeSel\" name=\"ansType"+questionNum+"\" onchange=\"loadType("+questionNum+")\" id=\"optionslist"+questionNum+"\">"
		+"<option value=\"1\" selected=\"selected\">Text</option>"
		+"<option value=\"2\" >Multiple Choice</option>"
		+"<option value=\"3\" >Check box</option>"
	+"</select>"
	+"<div class=\"realType\" id=\"realType"+questionNum+"\">Answer for this question will be text type.</div>"
	+"</div></div>";

    qns.appendChild(qn);
}
function addOption(questionNumCopy) //adds new option for multiple choice questions.
{
	opti[questionNumCopy]++;
	var qns = document.getElementById("optionx"+questionNumCopy);
	var qn = document.createElement("div");
	qn.innerHTML = "<div class=\"f-row\">"
				+"<div class=\"qnlabel\">Option "+opti[questionNumCopy]+" : </div>"
				+"<input type=\"text\" name=\"opt"+questionNumCopy+"_"+opti[questionNumCopy]+"\" placeholder=\"option\">"
				+"</div>";
	qns.appendChild(qn);

}

function addCBox(questionNumCopy) // adds new check boxes for check box type questions.
{
	cbxi[questionNumCopy]++;
	var qns = document.getElementById("checkx"+questionNumCopy);
	var qn = document.createElement("div");
	qn.innerHTML = "<div class=\"f-row\">"
				+"<div class=\"qnlabel\">Choice "+cbxi[questionNumCopy]+" : </div>"
				+"<input type=\"text\" name=\"box"+questionNumCopy+"_"+cbxi[questionNumCopy]+"\" placeholder=\"cbxnum\">"
				+"</div>";
	qns.appendChild(qn);
}

function loadType(questionNumCopy)
{
	var e= document.getElementById("optionslist"+questionNumCopy);
	var x=e.options[e.selectedIndex].value;
	if(x==1)
	{
		document.getElementById("realType"+questionNumCopy).innerHTML = "Answer for this question will be text type.";
		opti[questionNumCopy]=0;
		cbxi[questionNumCopy]=0;
	}
	else if (x==2)
	{
		document.getElementById("realType"+questionNumCopy).innerHTML = "<div id=\"optionx"+questionNumCopy+"\"></div><input type=\"button\" onclick=\"addOption("+questionNumCopy+")\" name=\"addopt\" value=\"Add Option\">";
		opti[questionNumCopy]=0;
		cbxi[questionNumCopy]=0;
	}
	else if(x==3)
	{
		document.getElementById("realType"+questionNumCopy).innerHTML = "<div id=\"checkx"+questionNumCopy+"\"></div><input type=\"button\" onclick=\"addCBox("+questionNumCopy+")\" name=\"addcbx\" value=\"Add Check Box\">";
		opti[questionNumCopy]=0;
		cbxi[questionNumCopy]=0;
	}
	else alert("none");
}

//////////////////////////////////////////
//important function to load using AJAX //
//////////////////////////////////////////
function ajaxLoad(modid, incfile) // modifying_id, including_file
{
	//alert("alax load called");
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
