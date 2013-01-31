<?php
/**
 * Uret XMl Editor - Generate Custom XML files
 *
 * @author      Tuna Aras <iletisim@uretgec.com>
 * @copyright   2012 Tuna Aras
 * @link        http://www.uretgec.com
 * @version     1.1
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
class URET_XML_Creator {
    // which folder create and backup xml files
    var $folder_name = "./xml/";

    function create_file($file_name){
        if($file_name != 'config' && !empty($file_name)) {
            $file_name = trim($file_name);
            $file = $this->folder_name.$file_name.".xml";
            return $file;
        } else {
            return false;
        }
    }

    /*Create*/
    function create_xml($file_name,$data){
        $file = $this->create_file($file_name);

        // xml start
        $xml = new DOMDocument('1.0', 'utf-8');
        $xml_channel = $xml->createElement("articles");

        // Config Main
        $xml_config = $xml->createElement("config");

        // config parameter
        $values = array();
        $config_datas = unserialize($data['config']);
        foreach ($config_datas as $value) {
            $xml_item = $xml->createElement("c");
            if(isset($value['title']) && !empty($value['title'])) $xml_item->setAttribute("title", $value['title']);
            if(isset($value['name']) && !empty($value['name'])) $xml_item->setAttribute("name", $value['name']);
            if(isset($value['desc']) && !empty($value['desc'])) $xml_item->setAttribute("desc", htmlspecialchars($value['desc']));
            if(isset($value['type']) && !empty($value['type'])) $xml_item->setAttribute("type", $value['type']);
            if(isset($value['value']) && !empty($value['value'])) $xml_item->setAttribute("value", $value['value']);
            $xml_config->appendChild($xml_item);

            // create one of default item
            $values[] = $value['name'];
        }
        $xml_channel->appendChild($xml_config);

        // create items
        unset($data['config']);
        unset($data['create_xml']);
        unset($data['action']);
        foreach ($data as $data_value) {
            $xml_article = $xml->createElement("item");
            foreach ($data_value as $d_key => $d_val) {
                if(strlen($d_val) > 50 && strpos($d_val, 'ttp://',1) === false){
                    $descriptionCdata = $xml->createCDATASection($d_val);
                    $xml_article_item = $xml->createElement($d_key);
                    $xml_article_item->appendChild($descriptionCdata);
                } else {
                    if($file_name === 'milliyet-rss' && $d_key === 'image'){
                        $xml_image_url = $xml->createElement('url',htmlspecialchars($d_val));
                        $xml_article_item = $xml->createElement($d_key);
                        $xml_article_item->appendChild($xml_image_url);
                    } else {
                        $xml_article_item = $xml->createElement($d_key,htmlspecialchars($d_val));
                    }
                }
                $xml_article->appendChild($xml_article_item);
            }
            $xml_channel->appendChild($xml_article);
        }

        $xml->appendChild($xml_channel);
        //print_r($xml->saveXML());
        if($file) {
            $xml->save($file);
            if(file_exists($file)){
                return 'OK';
            } else {
                return 'NO';
            }
        } else {
            return 'Can\'t create config.xml file.';
        }

    }
    function create_first_xml($file_name,$data){
        $file = $this->create_file($file_name);

        // xml start
        $xml = new DOMDocument('1.0', 'utf-8');
        $xml_channel = $xml->createElement("articles");

        // Config Main
        $xml_config = $xml->createElement("config");

        // config parameter
        unset($data['file_name']);
        unset($data['create_xml']);
        unset($data['action']);
        $values = array();
        foreach ($data as $value) {
            $xml_item = $xml->createElement("c");
            if(isset($value['title_name']) && !empty($value['title_name'])) $xml_item->setAttribute("title", $value['title_name']);
            if(isset($value['tag_name']) && !empty($value['tag_name'])) $xml_item->setAttribute("name", $value['tag_name']);
            if(isset($value['tag_desc']) && !empty($value['tag_desc'])) $xml_item->setAttribute("desc", $value['tag_desc']);
            if(isset($value['tag_type']) && !empty($value['tag_type'])) $xml_item->setAttribute("type", $value['tag_type']);
            if(isset($value['type_value']) && !empty($value['type_value'])) $xml_item->setAttribute("value", $value['type_value']);
            $xml_config->appendChild($xml_item);

            // create one of default item
            $values[] = $value['tag_name'];
        }
        $xml_channel->appendChild($xml_config);

        // create one of default item
        $xml_article = $xml->createElement("item");
        foreach ($values as $val) {

            $xml_article_item = $xml->createElement($val,'Default');
            $xml_article->appendChild($xml_article_item);

        }

        $xml_channel->appendChild($xml_article);
        $xml->appendChild($xml_channel);
        //print_r($xml->saveXML());
        if($file) {
            $xml->save($file);
            if(file_exists($file)){
                return 'OK';
            } else {
                return 'NO';
            }
        } else {
            return 'Can\'t create config.xml file.';
        }
    }

    /*Read*/
    function read_xml($file_name){
        $xml = $this->xml_to_string($file_name);
        $config_data = $this->config_file($xml);
        $var = $this->item_file($xml);
        return $this->form_creator($config_data,$var);
    }
    function read_config($file_name){
        $xml = $this->xml_to_string($file_name);
        $config_data = $this->config_file($xml);
        return serialize($config_data);
    }
    function xml_to_string($file_name){
        $file = $this->folder_name.$file_name.".xml";
        $xml = simplexml_load_file($file, 'SimpleXMLElement',LIBXML_NOCDATA);
        return $xml;
    }
    function config_file($xml){
        // config data
        $config = $xml->config->c;
        $config_count = count($config);
        $config_data = array();
        for ($i=0; $i < $config_count; $i++) {
            $config_array_key = (string) $config[$i]->attributes()->name;
            foreach ($config[$i]->attributes() as $key => $value) {
                $config_data[$config_array_key][$key] = (string) $value;
            }
        }
        return $config_data;
    }
    function item_file($xml){
        // item data
        $item = $xml->item;
        $count_item = count($item);
        $var = array();
        for ($i=0; $i < $count_item; $i++) {
            foreach ($item[$i]->children() as $key => $values) {
                if($values->url){
                    $var[$i][$key] = (string) $values->url;
                } else {
                    $var[$i][$key] = (string) $values;
                }
            }
        }
        return $var;
    }
    function form_creator($config_data,$var){
        $field = '';
        $i = 0;
        foreach ($var as $value) {
            $show_title = (isset($value['title'])) ? $value['title'] : 'No Description';
            $field .= '<li class="create" id="u'.$i.'"><div id="show_hide"><span>'.$show_title.'</span><a href="#" id="show">Show</a></div><div class="show_me_pls"><span class="item_id">'.$i.'</span>';
            foreach ($value as $key => $val) {
                $title = $config_data[$key]['title'];
                $name = $config_data[$key]['name'];
                $desc = htmlspecialchars($config_data[$key]['desc']);
                $type = $config_data[$key]['type'];
                $input_value = (isset($val)) ? $val : '';
                // form fields
                $field .= '<p>';
                switch ($type) {
                    case 'text':
                        $field .= '<label for="'.$name.'">'.$title.':</label><input type="text" name="u'.$i.'['.$name.']" id="'.$name.'" value="'.$input_value.'" /><span class="desc">'.$desc.'</span>';
                        break;
                    case 'textarea':
                        $field .= '<label for="'.$name.'">'.$title.':</label><textarea name="u'.$i.'['.$name.']" id="'.$name.'">'.htmlspecialchars($input_value).'</textarea><span class="desc">'.$desc.'</span>';
                        break;
                    case 'image':
                        $field .= '<label for="'.$name.'">'.$title.':</label><input type="text" name="u'.$i.'['.$name.']" id="'.$name.'" value="'.$input_value.'" /><span class="desc">'.$desc.'</span>';
                        break;
                    case 'selectbox':
                        $selected_values = explode('|', $config_data[$key]['value']);
                        $option = '';
                        foreach ($selected_values as $sel) {
                            $selected = ($input_value == $sel) ? ' selected="selected"' : '';
                            $option .= '<option'.$selected.' value="'.$sel.'">'.strtoupper($sel).'</option>';
                        }
                        $field .= '<label for="'.$name.'">'.$title.':</label><select name="u'.$i.'['.$name.']" id="'.$name.'">'.$option.'</select><span class="desc">'.$desc.'</span>';
                        break;
                    case 'radio':
                        $field .= '<label for="'.$name.'">'.$title.':</label><input type="text" name="u'.$i.'['.$name.']" id="'.$name.'" value="'.$input_value.'" /><span class="desc">'.$desc.'</span>';
                        break;
                    case 'checkbox':
                        $selected = ($input_value == 'true') ? ' checked="checked"' : '';
                        $field .= '<label for="'.$name.'">'.$title.':</label><input'.$selected.' type="checkbox" name="u'.$i.'['.$name.']" id="'.$name.'" value="true" /><span class="desc">'.$desc.'</span>';
                        break;
                    case 'multitext':
                        $field .= $type.'-'.$val;
                        break;
                    case 'multitextarea':
                        $field .= $type.'-'.$val;
                        break;
                    case 'multiselectbox':
                        $field .= $type.'-'.$val;
                        break;
                    case 'multiradio':
                        $field .= $type.'-'.$val;
                        break;
                    case 'multicheckbox':
                        $field .= $type.'-'.$val;
                        break;
                    case 'multiimage':
                        $field .= $type.'-'.$val;
                        break;
                    default:
                        $field .= 'Default value.';
                        break;
                }
                $field .= '</p>';
            }
            $field .= '<a href="#" id="delete">Delete</a></div></li>';
            $i++;
        }
        return $field;
    }

    // xml file list
    function list_xml_files($folder=false){

        if(isset($folder)) {
            $folder = $this->folder_name.$folder;
        } else {
            $folder = $this->folder_name;
        }
        $dir = dirname($folder);
        if(!is_dir($dir)){
            mkdir($dir);
        }
        if(!$contents = opendir($folder)) {
            return false;
        } else {
            $list = '';
            while(($files = readdir($contents)) !== false) {
                if($files!=="." && $files!==".." && $files!=="local" && strpos($files,"_backup.xml")=== false)  {
                    $name = str_replace('.xml', '', $files);
                    $backup_new = '<form method="POST" action=""><input type="hidden" name="action" value="backup"><input type="hidden" name="filename" value="'.$name.'"><input type="submit" value="Backup"></form>';
                    $backup = (file_exists($folder.'/'.$name.'_backup.xml')) ? date ("d.m.Y H:i:s", @filemtime($folder.'/'.$name.'_backup.xml')) : 'Not avaliable.';
                    $date = date ("d.m.Y H:i:s", @filemtime($folder.'/'.$files));
                    $url = "?name=".$name;
                    $list .= '<tr><td>'.$name.'</td><td>'.$date.'</td><td>'.$backup.'</td><td>'.$backup_new.'</td><td><a href="'.$url.'">Edit XML</a></td></tr>';
                }
            }
            return $list;
        }
    }

    // create backup xml
    function create_backup_xml($file_name){
        $file = $this->create_file($file_name);
        $backup_file = $this->create_file($file_name.'_backup');
        if (!copy($file, $backup_file)) {
            return 'NO';
        } else {
            return 'OK';
        }
    }
    function delete_xml($file_name=false,$password=false){
        $file = $this->create_file($file_name);
        $real_password = md5('goaway');
        if($real_password === md5($password)) {
            if (!file_exists($file)) {
                return 'NO';
            } else {
                if(unlink($file)) return 'OK';
                else return 'NO';
            }    
        } else {
            return 'Opps.';
        }
    }
    function select_xml($folder=false){
        if(isset($folder)) {
            $folder = $this->folder_name.$folder;
        } else {
            $folder = $this->folder_name;
        }
        $dir = dirname($folder);
        if(!is_dir($dir)){
            mkdir($dir);
        }
        if(!$contents = opendir($folder)) {
            return false;
        } else {
            $select_form = '<select name="filename">';
            $select_form .= '<option>Select One</option>';
            while(($files = readdir($contents)) !== false) {
                if($files!=="." && $files!==".." && $files!=="local" && strpos($files,"_backup.xml")=== false)  {
                    $name = str_replace('.xml', '', $files);
                    $file = (file_exists($folder.'/'.$name.'.xml')) ? date ("d.m.Y H:i:s", @filemtime($folder.'/'.$name.'.xml')) : 'Not avaliable.';
                    $select_form .= '<option value="'.$name.'">'.$name.'</option>';
                }
            }
            $select_form .= '</select>';
            return $select_form;
        }
    }
}
?>
