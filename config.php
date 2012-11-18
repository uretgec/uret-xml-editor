<?php
// Demo Config XML File Creator
include "class_uretxml.php";
if($_POST){
$read_xml = new URET_XML_Creator; 
echo $read_xml->create_first_xml($_POST['file_name'],$_POST);
}
?>
<html>
<head>
	<title>XML Config</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.9.1.custom.min.css">
	<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.9.1.custom.min.js"></script>
	<script type="text/javascript" src="js/runfunctions.js"></script>
</head>
<body>
<div id="xml_config">
	<h2>XML Config File Creator</h2>
	
	<form method="POST" id="config_form" action="">
		<p><label for="file_name">File Name</label>:<input name="file_name" id="file_name">.xml<span class="desc">Write this option title</span></p>
		<ul id="config"></ul>
		<?php /*<div class="config">
			<p><label for="title_name">Title</label>:<input name="title_name" id="title_name"><span class="desc">Write this option title</span></p>
			<p><label for="tag_name">Tag Name</label>:<input name="tag_name" id="tag_name"><span class="desc">Write this option title</span></p>
			<p><label for="tag_type">Tag Type</label>:
				<select name="tag_type" id="tag_type">
					<option value="text">Text Box</option>
					<option value="textarea">Textarea</option>
					<option value="selectbox">Selectbox</option>
					<option value="radio">Radio Box</option>
					<option value="checkbox">Check Box</option>
					<option value="image">Image Box</option>
					<option value="multitext">Multi Text Box</option>
					<option value="multitextarea">Multi Textarea</option>
					<option value="multiselectbox">Multi Selectbox</option>
					<option value="multiradio">Multi Radio Box</option>
					<option value="multicheckbox">Multi Check Box</option>
					<option value="multiimage">Multi Image Box</option>
				</select>
				<span class="desc">Write this option title</span>
			</p>
			<p><label for="type_value">Tag Values</label>:<input name="type_value" id="type_value"><span class="desc">Write this option title</span></p>
			<a href="#" id="delete">Delete</a>
		</div> */ ?>
		<div id="controller"><a href="#" id="add">Add</a></div>
		<div id="save"><input type="submit" name="create_xml" value="Create XML"><input type="reset" name="reset" value="Reset"></div>
	</form>
	
</div>
</body>
</html>