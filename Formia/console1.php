
<?php
//
// AJAX usen in bulding forms.
//

require 'core.inc.php';
require 'connect.inc.php';
$qryStatus= "";

// login status
if(loggedin())
{
	global $userData;

	$userData = getfield('firstname, id', 'logindata', $conn);

	//test table.
	$query = "SELECT 1 FROM t".$userData[1].";";
	if ($query=$conn->query($query))
	{
		//echo "table detected success";
	}
	else die("query fault while checking table. probably, table does not exist, please reach me at 7736600957");

}
else
	{
		die("Woah! you are not logged in. Login <a href=\"index.php\">here</a>");
		//header('Location :'.$http_referer);
	}
$title = "";
$data = "";
$fileName = "Untitled";
$resFileName = "Untitled";
$resStr="";
$multQn=0;
$cbxQn=0;
$resJS1="";

/////////////////////////////////////
//question submit from newform.php //
/////////////////////////////////////

if(isset($_POST['formSubmit']))
{
	if(!empty($_POST['title']))
	{
		//generate file name and path.
		$title = $_POST['title'];
		$title = $conn->real_escape_string($title);
		$tokk = strtok($title, " ");
		$fileName = "DataCenter/".$tokk.".php";
		$resFileName = "responseSum/".$tokk.".php";
		$count=0;
		if(file_exists("$fileName"))
		{
			while(file_exists("$fileName"))
			{
				$count++;
				$tokk = strtok($title, " ");
				$fileName ="DataCenter/".$tokk.$count.".php";
				$resFileName = "responseSum/".$tokk.$count.".php";
			}
		}
		//open the file for write.
		$hostFile = fopen($fileName, "a+") or die("Unable to open hostFile");
		$resHost = fopen($resFileName, "a+") or die("Unable to open ResHostFile");
		
		}
	else
	{
		$resFileName = "responseSum/Untitled.php";
		$fileName ="DataCenter/Untitled.php";
		$title = "Untitled Form";
		$count=0;
		while(file_exists("$fileName"))
		{
			$count++;
			$fileName ="DataCenter/Untitled".$count.".php";
			$resFileName = "responseSum/Untitled".$count.".php";
			$title = "Untitled Form-".$count;
		}
		//open the file for write.
		$hostFile = fopen($fileName, "a+") or die("Unable to open hostFile");
		$resHost = fopen($resFileName, "a+") or die("Unable to open ResHostFile");
	}

//	$fileTitle = $title
	$data = strtok($title, " ")." ".strtok(" ");
	$query = "INSERT INTO t$userData[1] (formID, fileLoc, published, link, name)
				 VALUES ('', '$fileName', '1', '$resFileName', '$data')";
	 

	if($conn->query($query))
	{
		$qryStatus = "Your form has successfully saved. Share the link to collect data";
		
	}
	else die("insertion Aborted. query fault during saving to t<id> table. :(  please inform 7736600957");
	

	//////////////////////////////////////////
	//query to create table for each user. //
	//////////////////////////////////////////
	$formID = $conn->insert_id;
	$tableCreateQry = "CREATE TABLE t".$userData[1]."_".$formID." (id INT(6) PRIMARY KEY AUTO_INCREMENT, timeStamp VARCHAR(40)";
	//$tableUpdateQry ="INSERT INTO t".$userData[1]."_".$formID." (id, timeStamp, ";
	

	if(!empty($_POST['description']))
	{
		$data = $_POST['description'];
		$data = $conn->real_escape_string($data);
	}

	//write to file section , save $data to reuse $data.
	//==================================================
	//
	
	$fphp_tag = "
<?php

require '../connect.inc.php';
require '../core.inc.php';

if (isset(\$_POST['submitx']))
{
	\$ctime= date(\"Y/m/d\").\" \".date(\"h:i:sa\");
	\$query= \"INSERT INTO t".$userData[1]."_".$formID." VALUES ('', '\$ctime'\";";

	fwrite($hostFile, "

			<!DOCTYPE html>
			<html>
			<head>
				<title>".$title."</title>
				<link rel=\"stylesheet\" type=\"text/css\" href=\"cssreset.css\">
				<link rel=\"stylesheet\" type=\"text/css\" href=\"qnstyle.css\">
			</head>
			<body>
			<div class=\"fhead\">
				<a href=\"#\">Formia</a>
			</div>
			<div class=\"entireQn\">
				<header>"
					.$title.
				"</header>
				<footer>".$data."</footer>

			");
	///////////////////
	//response file //
	///////////////////
	///.$userData[1]."_".$formID.
	fwrite($resHost,
"
<?php
require '../connect.inc.php';
require '../core.inc.php';

//get * from the corresponding table
\$tdata = getanyfield('*', 't".$userData[1]."_".$formID."', '\'1\'', '1', \$conn);
");
	//fwrite resHost over
	$summQn=0; //store the value of no(multiple ch qns)+no(cbx qns)
	
	$qnNum = 1;
	fwrite($hostFile, "<div class=\"questions\">
		<form method=\"POST\">");
	while(!empty($_POST['qn'.$qnNum]))
	{
		//echo "in while start<br>";


		$tableCreateQry = $tableCreateQry.", `".$conn->real_escape_string($_POST['qn'.$qnNum])."` VARCHAR(250)";
		

		
		$data = $conn->real_escape_string($_POST['ansType'.$qnNum]);
		if(!empty($data))
		{
			//echo "in if - ansType not empty $data<br>";
			if($data==1)
			{

				fwrite($hostFile, "<div class=\"quest\">
				<div class=\"textField\">".$conn->real_escape_string($_POST['qn'.$qnNum])."</div>
				<div class=\"ansField\"><input class=\"typeText\" type=\"text\" placeholder=\"your response\" name=\"a".$qnNum."_".$data."\"></div>	
				</div>");

				$fphp_tag = $fphp_tag."
				\$query = \$query.\", '\".\$_POST['a".$qnNum."_".$data."'].\"'\";";
				//echo "text";

			}
			elseif($data==2)
			{
				$multQn++;
				$summQn++;
				$temp=$qnNum+1;
				if($summQn==1)
				{
					$temp2="";
				}
				else
				{
					$temp2="else";
				}
				$resJS1 = $resJS1."
      google.setOnLoadCallback(drawChartPi".$multQn.");

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChartPi".$multQn."() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
				";
				$resStr=$resStr.$temp2."if(\$resi==".$temp.")
					{
						\$token = strtok(\$resdata[\$resi], \",\");
						while (\$token !== false)
						{";
				//---------------------------
				$i = 1;
				fwrite($hostFile, "<div class=\"quest\">
					<div class=\"textField\">".$conn->real_escape_string($_POST['qn'.$qnNum])."</div><div class=\"ansField\">");
				while(!empty($_POST['opt'.$qnNum."_".$i]))
				{
					fwrite($hostFile, "<input class=\"typeRadio\" type=\"radio\" name=\"opt".$qnNum."_".$data."\" value=\"".$conn->real_escape_string($_POST['opt'.$qnNum."_".$i])."\">".$conn->real_escape_string($_POST['opt'.$qnNum."_".$i])."<br>");
					$temp3=$i-1;
					$resJS1=$resJS1."['".$conn->real_escape_string($_POST['opt'.$qnNum."_".$i])."', <?php echo \$q".$summQn."[".$temp3."]; ?>],
					";
					
					$resStr=$resStr."if(trim(\$token)==\"".$conn->real_escape_string($_POST['opt'.$qnNum."_".$i])."\")
		{
			\$q".$summQn."[".$temp3."]++;
		}
		";

					$i++;

				}
				$fphp_tag = $fphp_tag."
				\$query = \$query.\", '\".@\$_POST['opt".$qnNum."_".$data."'].\"'\";";
				fwrite($hostFile, "</div></div>");
				fwrite($resHost, 
"
\$q".$summQn." = array_fill(0, ".$i.", 0);
");
			
			$resStr=$resStr."\$token = strtok(\",\");
	}
}";
			$temp3=$summQn-1;
			$resJS1=$resJS1."
]);

        // Set chart options
        var options = {'title':'".$conn->real_escape_string($_POST['qn'.$qnNum])."',
                    'width':900,
                    'height':500
                      };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div".$temp3."'));
        chart.draw(data, options);
      }

			";

				//echo "multiple";
			

			}
			elseif($data==3)
			{
				$cbxQn++;
				$summQn++;
				$temp=$qnNum+1;
				if($summQn==1)
				{
					$temp2="";
				}
				else
				{
					$temp2="else";
				}
				$resJS1=$resJS1."
		google.setOnLoadCallback(drawChartBar".$cbxQn.");

function drawChartBar".$cbxQn."() {
      //create the data table
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'fruits');
      data.addColumn('number', 'numbers');

      data.addRows([
				";
				$resStr=$resStr.$temp2."if(\$resi==".$temp.")
					{
						\$token = strtok(\$resdata[\$resi], \",\");
						while (\$token !== false)
						{";
				//---------------------------

				$i = 1;
				fwrite($hostFile, "<div class=\"quest\">
				<div class=\"textField\">".$conn->real_escape_string($_POST['qn'.$qnNum])."</div>
				<div class=\"ansField\">");
				while(!empty($_POST['box'.$qnNum."_".$i]))
				{
					fwrite($hostFile, "<input class=\"typeBox\" type=\"checkbox\" name=\"box".$qnNum."_".$data."[]\" value=\"".$conn->real_escape_string($_POST['box'.$qnNum."_".$i])."\">".$conn->real_escape_string($_POST['box'.$qnNum."_".$i])."<br>");
													//['mango', <?php echo $q2[0]; ],
					$temp=$i-1;
					$resJS1=$resJS1."['".$conn->real_escape_string($_POST['box'.$qnNum."_".$i])."', <?php echo \$q".$summQn."[".$temp."]; ?>],
					";
					$resStr=$resStr."if(trim(\$token)==\"".$conn->real_escape_string($_POST['box'.$qnNum."_".$i])."\")
		{
			\$q".$summQn."[".$temp."]++;
		}
		";

					$i++;
				}
				fwrite($hostFile, "</div></div>");
				fwrite($resHost, 
"
\$q".$summQn." = array_fill(0, ".$i.", 0);
");
				$fphp_tag = $fphp_tag."
\$cbname = @\$_POST['box".$qnNum."_".$data."'];
\$N = count(\$cbname);

\$cbxaid=\"\";
for(\$i=0; \$i < \$N; \$i++)
{
	if(\$i==0) \$cbxaid=\$cbxaid.\$cbname[\$i]; 
	else \$cbxaid=\$cbxaid.\", \".\$cbname[\$i];
}
\$query = \$query.\", '\$cbxaid'\";
";
			
				$resStr=$resStr."\$token = strtok(\",\");
	}
}";
	$temp3=$summQn-1;
				$resJS1=$resJS1."
]);

      var options = {
      	'width': 700,
        	'height': 300,
        title: '".$conn->real_escape_string($_POST['qn'.$qnNum])."',
        hAxis: {
          title: 'Options',
          format: 'string',
          viewWindow: {
            min: [],
            max: []
          }
        },
        vAxis: {
          title: 'Rating'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div".$temp3."'));

      chart.draw(data, options);
    }
				";

				//echo "check box";
			
			}
			else die("Undefined question type encountered");

		}
		//-----------
		$qnNum++;
		//echo "qnNum++<br>";
	}
	$tableCreateQry = $tableCreateQry.");"; 
	
	//echo $tableCreateQry;

	if($conn->query($tableCreateQry))
	{
		;
	}
	else die("unable to create table");


	fwrite($hostFile, "<input type=\"submit\" name=\"submitx\" class=\"submit0\" value=\"Submit\">
		</form>
		
	</div></div>
	<footer class=\"fixFooter\">
		<p>Powered by <a href=\"../index.php\" title=\"Home Page\">Formia</a></p>
	</footer>
</body>");	
	$fphp_tag = $fphp_tag."
	\$query= \$query.\");\";
	if(\$conn->query(\$query))
	{
		header('Location:'.\$addressBase.\"/DataCenter/thanks.html\");
	}
	else
	{
		header('Location:'.\$addressBase.\"/DataCenter/sorry.html\");	
	}
}
?>";
	fwrite($hostFile, $fphp_tag);
	fwrite($resHost,
"


?>
<!DOCTYPE html>
<html>
<head>
	<title>".$title." Survey Response | Formia</title>
	<link rel=\"stylesheet\" type=\"text/css\" href=\"cssreset.css\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"resStyle.css\">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu|Roboto+Condensed:700,300,400' rel='stylesheet' type='text/css'>
	<!--Load the AJAX API from Google for Generating chart-->
	<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>
</head>


<body>
<header class=\"mainHeader\">

	<header class=\"formia\">
		<a href=\"../index.php\">Formia Home</a> | <a href=\"../console1.php\">Admin Console</a>
		 || ".$title." 
	</header>

	<header class=\"formTitle\">
		<div class=\"review\">
			<span class=\"thick\">Formia</span> <span class=\"thin\">analytics</span>
		</div>
		<div class=\"ftitle\">".$title."</div>
	</header>

	<footer class=\"desc\">
");
	if(!empty($_POST['description']))
	{
		$temp = $conn->real_escape_string($_POST['description']);
		fwrite($resHost,$temp);
		//$data = $conn->real_escape_string($data);
	}
fwrite($resHost, 
"
</footer>
</header>

<div class=\"summ\">
	<h1>Summary</h1><br>
");
for($i=0;$i<$summQn;$i++)
{
	$temp=$i+1;
	fwrite($resHost, 
		"<div id=\"chart_div".$i."\">Processing your data to generate response summary ".$temp."</div><br>");
}
fwrite($resHost,
"
</div>

<div class=\"resTab\">
	<h1>Responses</h1>
	<div class=\"tbl\">
		<table>
			<tr>
<?php
\$fieldNum=0;
while(@\$finfo = \$tdata->fetch_field())
{ ?>
	<td class=\"tbl-h\">
	<?php echo \$finfo->name; \$fieldNum++; ?>
	</td>
<?php
}
?>
			</tr>
<?php
//\$tdata = getanyfield('*', 't58_3', '\'1\'', '1', \$conn);
if(\$tdata)
{
	while(@\$resdata = \$tdata->fetch_row())
	{ ?> <tr class=\"tbl-r\"> <?php
		\$resi=0;
		for(\$resi;\$resi<\$fieldNum;\$resi++)
		{ ?><td class=\"tbl-cell\"><?php 
			echo \$resdata[\$resi];
//--------------processing for summary

".$resStr."
//--------------
			?></td><?php 
		}?>
		</tr>
<?php	}
}
else echo \"empty tdata\";
?>
		</table>
	</div>
</div>

<footer class=\"bott\">
	<p>Copyright 2015 | Formia</p>
</footer>
</body>
<head>
	<script type=\"text/javascript\">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});//for pi

      // Set a callback to run when the Google Visualization API is loaded.
	//------
		google.load('visualization', '1.0', {packages: ['corechart', 'bar']});//for bar.	
".$resJS1."
</script>

</head>
</html>
");


	//echo "out of while<br>";
	fclose($hostFile);
	fclose($resHost);


}

?>

<!DOCTYPE>
<html>
<head>
	<meta charset="utf-8">
	<title>Console | Formia</title>
	<link rel="stylesheet" type="text/css" href="cssreset.css">
	<link rel="stylesheet" type="text/css" href="css/console_common_style.css">
	<link rel="stylesheet" type="text/css" href="css/console1_mainCont_style.css">
	<script src="consolejs.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu|Roboto+Condensed:700,300,400' rel='stylesheet' type='text/css'>

</head>
<body>
	<header class="console_header">
		<div class="c-h-left">
			<p><span class="c-h-thick">Formia</span><!--<span class="sep">|</span>--><span class="c-h-thin"> admin console </span></p>
		</div>
		<div class="c-h-right">
			<p><a href="#">Learn How</a> | <a href="#">About Us</a></p>
		</div>
	</header>
	<aside class="c-sideBar">
		<header>
			<p class="c-pageName" id="i-pageName">Console Home</p>
		</header>
		<a href="#" onclick='ajaxLoad("changingContent", "newform.php"), ajaxLoad("i-pageName", "newFormName.php")'><div id="c-button-navBar" class="c-button">Build New Form</div></a>
		<section class="c-navBar">
			<ul>
				<a class="c-active" id="con-home" onclick="changeActive('con-home', 'con-saved', 0)" href="#"><li>Console Home</li></a>
			<!--	<a class="c-normal" id="con-saved" onclick="changeActive('con-saved', 'con-home', 1)" href="#"><li>Saved Forms</li></a>-->
				<a class="c-normal" href="index.php"><li>Home</li></a>
			</ul>
		</section>
		<footer class="c-navBar-footer">
			<a href="logout.php"><div class="c-butt-signOut">Sign Out</div></a>
		</footer>
	</aside>
	<section class="c-mainContent">
		<header>
			<div class="c-wish">
				<div class="c-wish-left">Hi  
					<?php global $userData;
				 if($userData[0] =="reema"||$userData[0] =="Reema"||$userData[0] =="REEMA")
				 	echo $userData[0].", ****Where is that hindi song? That paper?";
				 elseif($userData[0] =="Bhagya"||$userData[0] =="bhagya"||$userData[0] =="BHAGYA")
				 	echo $userData[0].", ****Tum hi ho. Do you remember that song?";
				 elseif($userData[0] =="Remya"||$userData[0] =="remya"||$userData[0] =="REMYA")
				 	echo $userData[0].", ****U got amzing level of tolerance!";
				 elseif($userData[0] =="Jisy"||$userData[0] =="jisy"||$userData[0] =="JISY")
				 	echo $userData[0].", ****send my regards to Vishnu.";
				 elseif($userData[0] =="Akhil"||$userData[0] =="akhil"||$userData[0] =="AKHIL")
				 	echo $userData[0].", ****nee oru vattana... :)";
				 elseif($userData[0] =="Ajmal"||$userData[0] =="ajmal"||$userData[0] =="AJMAL")
				 	echo $userData[0].", ****mindout!";
				 elseif($userData[0] =="Hari"||$userData[0] =="hari"||$userData[0] =="HARI")
				 	echo $userData[0].", ****Ne oru sambhavava. enn ne vicharikknnundo?";
				 elseif($userData[0] =="Athira"||$userData[0] =="athira"||$userData[0] =="ATHIRA")
				 	echo $userData[0].", ****Ne vere leveladi..";
				 elseif($userData[0] =="Asha"||$userData[0] =="asha"||$userData[0] =="ASHA")
				 	echo $userData[0].", ****chinna chinna ash..";
				 elseif($userData[0] =="Arathi"||$userData[0] =="arathi"||$userData[0] =="ARATHI")
				 	echo $userData[0].", ****kuyil voice.";
				 elseif($userData[0] =="Jiju"||$userData[0] =="jiju"||$userData[0] =="JIJU")
				 	echo $userData[0].", pwo***.. neeritt ennod choicha mathi...";
				 elseif($userData[0] =="Azhar"||$userData[0] =="azhar"||$userData[0] =="AZHAR")
				 	echo $userData[0].", thadiya...";
				 else echo $userData[0].",";
				 	 ?></div>
				<div class="c-wish-right"><a href="logout.php">Sign Out</a></div>
			</div>
		</header>
		<div class="c-homeOverview" id="changingContent">

<!--========================================================================
	========================================================================-->
			<style type="text/css">
			.c-qrystatus{
				background-color: #FEFFBC;
				margin: 1% 50% 1% .3%;
				padding:1%;
				}

			</style>
			<?php
			if(!empty($qryStatus))
			{ ?>
			<div class="c-qrystatus"><?php echo $qryStatus; ?></div>
			<?php } ?>
			<div class="c-cnf">
				<p>Create new survey form <a href="#" onclick='ajaxLoad("changingContent", "newform.php"), ajaxLoad("i-pageName", "newFormName.php")'><span class="c-button" id="c-button-cont0">New Form</span></a></p>
				<!--<div id="c-button-cont0" class="c-button">New Form</div>-->
			</div>

			


			<?php
				global $userData, $tableData, $tableName;
				$tableName = "t".$userData[1];
				$tableData = getanyfield('name, published, link, fileLoc', $tableName, '\'1\'', '1', $conn);
				if($tableData)
				{	?>
				<p class="t-heading">Current Forms</p>
				<!--style for h3 tag -->
				<table>
					<tr><!--head-->
						<td class="tbl-h">Form Title</td>
						<td class="tbl-h">Status</td>
						<td class="tbl-h">Link</td>
					</tr>
				<?php
					while(@$dataCount = $tableData->fetch_row())
					{
						?>
							<tr class="tbl-r">
								<td class="tbl-cell"><a href="<?php echo $addressBase.$dataCount[2]; ?>" title="Preview" target="_blank"><?php echo $dataCount[0]; ?></a></td>
									<td class="tbl-cell"><?php if($dataCount[1]=='1') echo "published"; else echo "not published"; ?></td>
									<td class="tbl-cell">
									<?php
									if($dataCount[1]=='1')
									{ ?>
										<a href="<?php echo $addressBase.$dataCount[3]; ?>" target="_blank"><?php echo $addressBase.$dataCount[3]; ?></a></td>
									<?php 
									}
									else{
										?>
										<input type="button" value = "Publish">
									<?php 
									}
									?>
							</tr>
						<?php
					}
				}
			else echo "<br> You don't have any saved forms yet!<br><br>Create new one by hitting 'Build New Form<br><br>";		
			?>			
			 
			</table>
<!--========================================================================
	========================================================================-->
		</div>
	</section>



	<footer class="c-cont-footer">
			<div class="c-foot-left">
				<p><a href="#">Learn How</a> | <a href="#">The Dev Team</a></p>
			</div>
			<div class="c-foot-Formia"\>Formia</div>
			<footer>Copyright 2015 | Formia Console WorkStation</footer>
	</footer>
</body>

	</table>
</html>
