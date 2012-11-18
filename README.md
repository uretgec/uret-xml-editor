URET XML EDITOR
=============

URET XML Editor for generate custom xml files with own configration datas. Build your own xml files and configs. There is only one class and thats it.
Uret XML EDITOR = XMl Config Creator + XML File Creator  

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