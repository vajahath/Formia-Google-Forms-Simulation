<!--

	Console Home Page Main Content
====================================================================
-->
<?php
require 'core.inc.php';
require 'connect.inc.php';

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


?>

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
					<td class="tbl-cell"><a href="<?php echo $dataCount[3]; ?>" title="Preview"><?php echo $dataCount[0]; ?></a></td>
						<td class="tbl-cell"><?php if($dataCount[1]=='1') echo "published"; else echo "not published"; ?></td>
						<td class="tbl-cell"><a href="<?php echo $addressBase.$dataCount[3]; ?>"><?php echo $addressBase.$dataCount[3]; ?></a></td>
				</tr>
			<?php
		}
	}
else echo "<br> You don't have any saved forms yet!<br><br>Create new one by hitting 'Build New Form<br><br>";		
?>			
 
</table>
