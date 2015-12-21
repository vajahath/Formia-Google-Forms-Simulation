
<?php
require '../connect.inc.php';
require '../core.inc.php';

//get * from the corresponding table
$tdata = getanyfield('*', 't1_1', '\'1\'', '1', $conn);

$q1 = array_fill(0, 3, 0);

$q2 = array_fill(0, 3, 0);



?>
<!DOCTYPE html>
<html>
<head>
	<title>kjlasf Survey Response | Formia</title>
	<link rel="stylesheet" type="text/css" href="cssreset.css">
	<link rel="stylesheet" type="text/css" href="resStyle.css">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu|Roboto+Condensed:700,300,400' rel='stylesheet' type='text/css'>
	<!--Load the AJAX API from Google for Generating chart-->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>


<body>
<header class="mainHeader">

	<header class="formia">
		<a href="../index.php">Formia Home</a> | <a href="../console1.php">Admin Console</a>
		 || kjlasf 
	</header>

	<header class="formTitle">
		<div class="review">
			<span class="thick">Formia</span> <span class="thin">analytics</span>
		</div>
		<div class="ftitle">kjlasf</div>
	</header>

	<footer class="desc">
lk;lkfg;s
</footer>
</header>

<div class="summ">
	<h1>Summary</h1><br>
<div id="chart_div0">Processing your data to generate response summary 1</div><br><div id="chart_div1">Processing your data to generate response summary 2</div><br>
</div>

<div class="resTab">
	<h1>Responses</h1>
	<div class="tbl">
		<table>
			<tr>
<?php
$fieldNum=0;
while(@$finfo = $tdata->fetch_field())
{ ?>
	<td class="tbl-h">
	<?php echo $finfo->name; $fieldNum++; ?>
	</td>
<?php
}
?>
			</tr>
<?php
//$tdata = getanyfield('*', 't58_3', '\'1\'', '1', $conn);
if($tdata)
{
	while(@$resdata = $tdata->fetch_row())
	{ ?> <tr class="tbl-r"> <?php
		$resi=0;
		for($resi;$resi<$fieldNum;$resi++)
		{ ?><td class="tbl-cell"><?php 
			echo $resdata[$resi];
//--------------processing for summary

if($resi==3)
					{
						$token = strtok($resdata[$resi], ",");
						while ($token !== false)
						{if(trim($token)=="sdfs")
		{
			$q1[0]++;
		}
		if(trim($token)=="fsdf")
		{
			$q1[1]++;
		}
		$token = strtok(",");
	}
}elseif($resi==4)
					{
						$token = strtok($resdata[$resi], ",");
						while ($token !== false)
						{if(trim($token)=="gsdfg")
		{
			$q2[0]++;
		}
		if(trim($token)=="sdfgs")
		{
			$q2[1]++;
		}
		$token = strtok(",");
	}
}
//--------------
			?></td><?php 
		}?>
		</tr>
<?php	}
}
else echo "empty tdata";
?>
		</table>
	</div>
</div>

<footer class="bott">
	<p>Copyright 2015 | Formia</p>
</footer>
</body>
<head>
	<script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});//for pi

      // Set a callback to run when the Google Visualization API is loaded.
	//------
		google.load('visualization', '1.0', {packages: ['corechart', 'bar']});//for bar.	

      google.setOnLoadCallback(drawChartPi1);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChartPi1() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
				['sdfs', <?php echo $q1[0]; ?>],
					['fsdf', <?php echo $q1[1]; ?>],
					
]);

        // Set chart options
        var options = {'title':'sdfsd',
                    'width':900,
                    'height':500
                      };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div0'));
        chart.draw(data, options);
      }

			
		google.setOnLoadCallback(drawChartBar1);

function drawChartBar1() {
      //create the data table
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'fruits');
      data.addColumn('number', 'numbers');

      data.addRows([
				['gsdfg', <?php echo $q2[0]; ?>],
					['sdfgs', <?php echo $q2[1]; ?>],
					
]);

      var options = {
      	'width': 700,
        	'height': 300,
        title: 'lksflgs',
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
        document.getElementById('chart_div1'));

      chart.draw(data, options);
    }
				
</script>

</head>
</html>
