URET XML EDITOR
=============

URET XML Editor for generate custom xml files with own configration datas. Build your own xml files and configs. There is only one class and thats it. Nodatabase requirement. I used jquery and jquery ui in this project.

Uret XML EDITOR = XML Config Creator + XML File Creator  

* Create custom xml files (config item sortable and dragable)
* Edit custom xml files (item sortable and dragable)
* Backup this files (if you want)
* Delete xml file with password proctection page.
* Show and Hide function added (Sortable dont work)

Configration
-------

* ?name=config : Create new xml file.
* ?name=xmlfilename : Edit xml file with all items
* ?special=uretxml : Delete xml file with password (password: goaway)

NOTE: Didn\'t create "config.xml" file. Because of run config function.

Usage
-----
Include uret_xml class top of the page.
	
	include "class_uretxml.php";
	$read_xml = new URET_XML_Creator; 

Init functions
-----
	
	$read_xml->list_xml_files($folder); // List all xml (not *_backup.xml) files in $folder
	$read_xml->create_backup_xml($file_name); // Only write file_name and backup this file in $folder. (name of the backup file: *_backup.xml)
	$read_xml->create_first_xml($file_name,$data); // Create first xml file with config datas. Build config datas and default item data.
	$read_xml->create_xml($file_name,$data); // Finished xml file edit, you run this function.
	$read_xml->delete_xml($file_nem,$password); // Delete xml file with password (password: goaway)

URETGEC
-----
Uret Xml Editor was made by [Uretgec](http://www.uretgec.com). 

MIT Open Source License
-----
The Uret XML Editor is released under the MIT public license.

Coming Soon:
-------
* Edit config file
* Custom error message
* Read and generate html to XML Files with one function