<!-- this file is used when user clicks the build new form.-->

<?php
;
?>

<style type="text/css">
.newform-ul{
	background-color: #FFF;
	list-style: none;
	margin-top: 1%;
	padding-bottom: 1%;
	border-bottom: solid gray thin;
	margin-bottom:  1%;
}
.newform-ul li{
	display: inline-block;
	margin-right: 1.5%;
}
#form-title-copy{
	color: #FF0088;
}
.labelFormx{
	display: inline-block;
	width: 20%;
}
.f-row{
	margin-bottom: 1%;
	margin-top: 1%;
}
#addi{
	padding: 1% 2%;
	background-color: #FF0088;
	border: solid thin #FF0088;
	border-radius: 5px;
	color: #FFF;
	margin-top: 2%;
	margin-bottom: 1%;
}
#formSubmit{
	
}
.qnlabel{
	display: inline-block;
	width: 20%;
}
.t-field{
	display: inline-block;
	padding: 1%;
	border-radius: 5px;
	border:solid thin #FF0088;

}
.elements{
	padding: 1%;
}
.elements:hover,
.elements:active{
	background-color: #F1F1F1;
}
.realType{
	padding: 1%;
}
.submit0{
	padding: 1% 2%;
	background-color: #0574e8;
	border: solid thin #0574e8;
	border-radius: 5px;
	color: #FFF;
	margin-bottom: 4%;
}
.discard{
	background-color: #717171;
	color: #FFF;
	border-color: #717171;
	width: 100px;
	height: 30px;
}
.butts{
	margin-left: 40%;
}
.iptypeTxt{
	padding: 1%;
	border-radius: 5px;
	border:solid thin #FF0088;
}
.iptypeSel{
	padding: .2%;
	border-radius: 5px;
	border:solid thin #FF0088;
}
</style>

<ul class="newform-ul">
	<li><h1 id="form-title-copy">Untitled form</h1></li>
	<!--<li><input type="submit" name="save" value="Save"></li>-->
	<!--<li><input type="submit" name="publish" value="Publish"></li>-->
	<li><a href="console1.php"><input type="button" class="discard" name="discard" value="Discard"></a></li>
</ul>
<div class="formCreate">
	<form method="POST" action="console1.php">
		<div class="f-row"><div class="labelFormx">Form Title :</div><input type="text" id="ttl" class="iptypeTxt" name="title" onkeypress="showit()" onkeyup="showit()" placeholder="Untitled Form"></div>
		<div class="f-row"><div class="labelFormx">Form description :</div><textarea cols="30" class="iptypeTxt" name="description" placeholder="About this form"></textarea></div>

		<div id="question"></div>
		<div class="butts">
			<input id="addi" type="button" name="item" value="Add New Item" onclick="addNewItem()"><br>
			<input id="formSubmit" class="submit0" type="submit" name="formSubmit" value="Publish">
		</div>
	<!--onclick="ajaxLoad('qnValidate','questionValidate.php')"-->
		
</div>
</form>
<!--validation confirmation section
====================================-->
	<!--<div id="qnValidate" class="qn-validate"></div>-->