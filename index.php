<?php 
// Main File - All of action in it.
include "class_uretxml.php";
$read_xml = new URET_XML_Creator; 
if(isset($_POST['action']) && $_POST['action'] === 'config'){
	$result = $read_xml->create_first_xml($_POST['file_name'],$_POST);
} elseif(isset($_POST['action']) && $_POST['action'] === 'create') {
	$file_name = $_GET['name'];
	$result = $read_xml->create_xml($file_name,$_POST);
} elseif(isset($_POST['action']) && $_POST['action'] === 'backup') {
	$result = $read_xml->create_backup_xml($_POST['filename']);
} elseif(isset($_POST['action']) && $_POST['action'] === 'delete') {
	$result = $read_xml->delete_xml($_POST['filename'],$_POST['password']);
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
<?php 
if(isset($result)) { echo '<div class="alert"><p>'.$result.'</p></div>'; }
if(isset($_GET['name']) && $_GET['name'] === 'config') { ?>
<div id="xml_config">
	<h2>XML Config File Creator<span>Return: <a href="?">Home</a></span></h2>
	
	<form method="POST" id="config_form" action="">
		<p class="filename"><label for="file_name">File Name</label>:<input  type="text" name="file_name" id="file_name">.xml</p>
		<ul id="config"></ul>
		<div id="controller"><a href="#" id="add">Add</a></div>
		<div id="save"><input type="hidden" name="action" value="config"><input type="submit" name="create_xml" value="Create XML"></div>
	</form>
	
</div>
<?php } elseif (isset($_GET['name']) && $_GET['name'] != 'config') { ?>
<div id="xml_creator">
	<h2>XML Creator<span>Return: <a href="?">Home</a></span></h2>
	
	<form method="POST" id="create_form" action="">
		<ul id="creator">
			<?php echo $read_xml->read_xml($_GET['name']); ?>
		</ul>
		<div id="add_new"><a href="#" id="add_item">Add New Item</a></div>
		<div id="save"><input type="hidden" name="action" value="create"><input type="hidden" name="config" value='<?php echo $read_xml->read_config($_GET['name']); ?>'><input type="submit" name="create_xml" value="Update XML"></div>
	</form>
</div>
<?php } elseif (isset($_GET['special']) && $_GET['special'] == 'uretxml') { ?>
<div id="xml_special">
	<h2>My Page<span>Return: <a href="?">Home</a></span></h2>
	<form method="POST" action="?special=tunaaras">
		<p><?php echo $read_xml->select_xml(false); ?></p>
		<p><input name="password" type="password" /></p>
		<div id="save"><input type="hidden" name="action" value="delete"><input type="submit" name="delete_xml" value="Delete XML"></div>
	</form>
</div>
<?php } else { ?>
<div id="mainpage">
	<h2>XML Files List<span>Create New XML: <a href="?name=config">Add New</a></span></h2>
	<table>
		<thead>
			<tr class="heading">
				<th>File Name</th>
				<th>Last Modified Date</th>
				<th>Last Backup Date</th>
				<th>Backup</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $read_xml->list_xml_files(false); ?>
		</tbody>	
	</table>
</div>
<?php } ?>
<pre>
<?php 	
$text = '
URET XML EDITOR
=============

Simple XML Editor for create custom xml files. Build your own xml files and configs. There is only one class and thats it.
Uret XMl EDITOR = XMl Config Creator + XML File Creator  

Configration
-------

* ?name=config : Create new xml file.
* ?name=xmlfilename : Edit xml file with all items

NOTE: Didn\'t create "config.xml" file. Because of run config function.

Usage
-----
Include uret_xml class top of the page.
	
	include "class_uretxml.php";
	$read_xml = new XML_Creator; 

Init functions
-----
	
	$read_xml->list_xml_files($folder); // List all xml (not *_backup.xml) files in $folder
	$read_xml->create_backup_xml($file_name); // Only write file_name and backup this file in $folder. (name of the backup file: *_backup.xml)
	$read_xml->create_first_xml($file_name,$data); // Create first xml file with config datas. Build config datas and default item data.
	$read_xml->create_xml($file_name,$data); // Finished xml file edit, you run this function.
	$read_xml->delete_xml($file_nem,$password); // Delete xml file with password

Coming Soon:
-------
* Edit config file
* Custom error message'; 
echo htmlspecialchars($text);
?>
</pre>
</body>
</html>