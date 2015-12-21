

			<!DOCTYPE html>
			<html>
			<head>
				<title>kjlasf</title>
				<link rel="stylesheet" type="text/css" href="cssreset.css">
				<link rel="stylesheet" type="text/css" href="qnstyle.css">
			</head>
			<body>
			<div class="fhead">
				<a href="#">Formia</a>
			</div>
			<div class="entireQn">
				<header>kjlasf</header>
				<footer>lk;lkfg;s</footer>

			<div class="questions">
		<form method="POST"><div class="quest">
				<div class="textField">dsdfsddsfsd</div>
				<div class="ansField"><input class="typeText" type="text" placeholder="your response" name="a1_1"></div>	
				</div><div class="quest">
					<div class="textField">sdfsd</div><div class="ansField"><input class="typeRadio" type="radio" name="opt2_2" value="sdfs">sdfs<br><input class="typeRadio" type="radio" name="opt2_2" value="fsdf">fsdf<br></div></div><div class="quest">
				<div class="textField">lksflgs</div>
				<div class="ansField"><input class="typeBox" type="checkbox" name="box3_3[]" value="gsdfg">gsdfg<br><input class="typeBox" type="checkbox" name="box3_3[]" value="sdfgs">sdfgs<br></div></div><input type="submit" name="submitx" class="submit0" value="Submit">
		</form>
		
	</div></div>
	<footer class="fixFooter">
		<p>Powered by <a href="../index.php" title="Home Page">Formia</a></p>
	</footer>
</body>
<?php

require '../connect.inc.php';
require '../core.inc.php';

if (isset($_POST['submitx']))
{
	$ctime= date("Y/m/d")." ".date("h:i:sa");
	$query= "INSERT INTO t1_1 VALUES ('', '$ctime'";
				$query = $query.", '".$_POST['a1_1']."'";
				$query = $query.", '".@$_POST['opt2_2']."'";
$cbname = @$_POST['box3_3'];
$N = count($cbname);

$cbxaid="";
for($i=0; $i < $N; $i++)
{
	if($i==0) $cbxaid=$cbxaid.$cbname[$i]; 
	else $cbxaid=$cbxaid.", ".$cbname[$i];
}
$query = $query.", '$cbxaid'";

	$query= $query.");";
	if($conn->query($query))
	{
		header('Location:'.$addressBase."/DataCenter/thanks.html");
	}
	else
	{
		header('Location:'.$addressBase."/DataCenter/sorry.html");	
	}
}
?>